<?php

namespace Someline\Api\Controllers;

use Carbon\Carbon;
use Faker\Provider\Base;
use Illuminate\Http\Request;

use Someline\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Someline\Http\Requests\PublicationCreateRequest;
use Someline\Http\Requests\PublicationUpdateRequest;
use Someline\Repositories\Interfaces\PublicationRepository;
use Someline\Validators\PublicationValidator;


class PublicationsController extends BaseController
{

    /**
     * @var PublicationRepository
     */
    protected $repository;

    /**
     * @var PublicationValidator
     */
    protected $validator;

    public function __construct(PublicationRepository $repository, PublicationValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        return $this->repository->all();

    }

    /**
     * get resource in storage.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        /**
         * 转换版本和 UUID
         */
        $version = version_to_int($data['version']);
        $uuid = trim($data['uuid']);

        $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
        //todo 减少时间精确度,来利用缓存
        $where = [
            'package_name' => $data['package_name'],
            ['min_time', '<', Carbon::now()],
            ['max_time', '>', Carbon::now()],
        ];

        $publications = $this->repository->findWhere($where);

        $publications = $publications['data'] ?: [];
        $config = array_first($publications);


        foreach ($publications as $publication) {

            //比对版本
            if ($version < $publication['min_version'] || $version > $publication['max_version'])
                continue;
            if (empty($publication['uuids'])) {
                $config = $publication;
            } elseif (in_array($uuid, $publication['uuids'])) {
                $config = $publication;
                break;
            }
        }

        $returnData = [
            'publication_message' => isset($config['publication_message']) ? $config['publication_message'] : '',
            'online_config' => isset($config['online_config']) ? $config['online_config'] : '',
            'server_list' => isset($config['server_list']) ? $config['server_list'] : '',
            'hot_upgrade' => isset($config['hot_upgrade']) ? $config['hot_upgrade'] : ''
        ];

        return $returnData;


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
        $publication = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $publication,
            ]);
        }

        return view('publications.show', compact('publication'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $publication = $this->repository->find($id);

        return view('publications.edit', compact('publication'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  PublicationUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(PublicationUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $publication = $this->repository->update($id, $request->all());

            $response = [
                'message' => 'Publication updated.',
                'data' => $publication->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Publication deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Publication deleted.');
    }
}
