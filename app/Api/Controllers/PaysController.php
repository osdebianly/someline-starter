<?php

namespace Someline\Api\Controllers;

//use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Http\Request;

use Someline\Http\Requests;
use Illuminate\Support\MessageBag;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

use Someline\Http\Requests\PayCreateRequest;
use Someline\Http\Requests\PayUpdateRequest;
use Someline\Repositories\Interfaces\PayRepository;
use Someline\Validators\PayValidator;


class PaysController extends BaseController
{

    /**
     * @var PayRepository
     */
    protected $repository;

    /**
     * @var PayValidator
     */
    protected $validator;

    public function __construct(PayRepository $repository, PayValidator $validator)
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
        $userID = auth_user()->getUserId();
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $pays = $this->repository->findByField('user_id', $userID);

        return $pays;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PayCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth_user();
        $data = $request->all();

        $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

        if (empty($user->phone_number)) {
            throw new ValidatorException(new MessageBag(['未设置手机号码']));
        }

        if ($user->wealth < $data['number']) {
            throw new ValidatorException(new MessageBag(['余额不足']));
        }


        $data['state'] = 'init';
        $data['verify_code'] = (string)random_int(1000, 9999);
        $data['try_time'] = 0;
        $data['client_id'] = auth_client_id();


        $pay = $this->repository->create($data);

        //todo
        //send_sms($user->phone_number,$data['verify_code']) ;


        return $pay;

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
        $pay = $this->repository->find($id);

        return $pay;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $user = auth_user();

        $data = $request->only('verify_code');

        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $this->repository->skipPresenter();
            $pay = $this->repository->find($id);

            if ($pay->try_time > 3) {
                throw new ValidatorException(new MessageBag(['验证码错误次数过多,以关闭该订单']));
            }

            $user->wealth -= $pay->number;

            if ($user->wealth < 0) {
                throw new ValidatorException(new MessageBag(['余额不足']));
            }

            if ($pay->verify_code != $data['verify_code']) {
                throw new ValidatorException(new MessageBag(['验证码错误']));
            }

            $pay->state = 'complete'; //更新订单到完成状态
            //$pay = $this->repository->update($id, $updateData);
            $user->save();  //更新用户财富

        } catch (ValidatorException $e) {
//            return response()->json([
//                'error' => true,
//                'message' => $e->getMessageBag()->first()
//            ]);
            return $e;
        } finally {
            $pay->try_time++;
            $pay->save();
        }
        $returnDate['pay_id'] = $id;
        $returnDate['state'] = $pay->state;
        $returnDate['complete'] = (string)$pay->updated_at;


        return response()->json([
            'data' => $returnDate
        ]);
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
        $this->repository->skipPresenter();
        $pay = $this->repository->find($id);
        if ($pay->state != 'init') {
            throw new ValidatorException(new MessageBag(['已完成订单不可删除']));
        }
        $deleted = $this->repository->delete($id);

        return response()->json([
            'message' => 'Pay deleted.',
            'deleted' => $deleted,
        ]);
    }
}
