<?php

namespace Someline\Api\Controllers;

use Carbon\Carbon;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Someline\Events\ActivityAward;
use Someline\Http\Requests\ActivityCreateRequest;
use Someline\Http\Requests\ActivityUpdateRequest;
use Someline\Repositories\Interfaces\ActivityRepository;
use Someline\Validators\ActivityValidator;
use Illuminate\Http\Request;

class ActivitiesController extends BaseController
{

    /**
     * @var ActivityRepository
     */
    protected $repository;

    /**
     * @var ActivityValidator
     */
    protected $validator;

    public function __construct(ActivityRepository $repository, ActivityValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->repository->all();
    }

    public function getGoodReputation()
    {
        $userId = current_auth_user()->getAuthUserId();
        try {
            $activity = $this->repository->where(['user_id' => $userId])->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return [];
        }
        return array_get($activity, 'data.good_reputation');

    }

    /**
     * 领取好评奖励
     * @return array|mixed
     */
    public function getGoodReputationAward()
    {
        $userId = current_auth_user()->getAuthUserId();
        try {
            $activity = $this->repository->where(['user_id' => $userId])->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return [];
        }

        $goodReputation = array_get($activity, 'data.good_reputation');

        if ($goodReputation['state'] != 'success' || isset($goodReputation['got_at']) && $goodReputation['got_at']) {
            throw new ResourceException('审核未通过或已领取过');
        }

        $goodReputation['got_at'] = (string)Carbon::now();

        $this->repository->updateOrCreate(['id' => $activity['data']['id']], ['good_reputation' => json_encode($goodReputation)]);
        //todo 触发加钱事件, 带上原因说明 ,通知服务端加钱
        event(new ActivityAward(['user_id' => $userId, 'note' => '好评送礼']));

        return response_message("领取成功,稍后打到您的账户");


    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  ActivityCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function goodReputation(Request $request)
    {

        $data = $request->only('pic_url', 'message');

        $this->validator->with($data)->passesOrFail('good_reputation');

        $userId = auth_user()->getAuthUserId();

        $data['state'] = 'wait';
        $data['note'] = '';

        $activity = $this->repository->updateOrCreate(['user_id' => $userId], ['good_reputation' => json_encode($data)]);

        return $activity;

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  ActivityCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityCreateRequest $request)
    {

        $data = $request->all();

        $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

        $activity = $this->repository->create($data);

        // throw exception if store failed
//        throw new StoreResourceFailedException('Failed to store.');

        // A. return 201 created
//        return $this->response->created(null);

        // B. return data
        return $activity;

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ActivityUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(ActivityUpdateRequest $request, $id)
    {

        $data = $request->all();

        $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

        $activity = $this->repository->update($data, $id);

        // throw exception if update failed
//        throw new UpdateResourceFailedException('Failed to update.');

        // Updated, return 204 No Content
        return $this->response->noContent();

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if ($deleted) {
            // Deleted, return 204 No Content
            return $this->response->noContent();
        } else {
            // Failed, throw exception
            throw new DeleteResourceFailedException('Failed to delete.');
        }
    }
}
