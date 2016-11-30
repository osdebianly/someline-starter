<?php

namespace Someline\Api\Controllers;

use Carbon\Carbon;
use Dingo\Api\Exception\ResourceException;
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
            'client_id' => $data['client_id'],
            'os' => $data['os'],
            ['min_time', '<', Carbon::now()],
            ['max_time', '>', Carbon::now()],
        ];
        if (isset($data['source'])) {
            $where['source'] = $data['source'];
        }

        $publications = $this->repository->findWhere($where);
        if (empty($publications['data'])) {
            throw new ResourceException('未找到符合条件的配置文件');
        }
        $publications = $publications['data'];
        $config = array_first($publications);

        foreach ($publications as $publication) {
            /**
             * 比对版本,优先匹配白名单
             */
            if ($version < $publication['min_version'] || $version > $publication['max_version'])
                continue;
            if (empty($publication['uuids'])) {
                $config = $publication;
            } elseif (in_array($uuid, array_column($publication['uuids'], 'value'))) {
                $config = $publication;
                break;
            }
        }

        /**
         * 转换数据(原数据结构方便 vue 解析)
         */
        $publication_message = $config['publication_message'];
        $hot_upgrade = $config['hot_upgrade'];

        $online_config = [];
        array_map(function ($config) use (&$online_config) {
            $online_config[$config["key"]] = $config["value"];
        }, $config['online_config']);
        $server_list = [];
        array_map(function ($config) use (&$server_list) {
            $server_list[] = $config["value"];
        }, $config['server_list']);

        return compact('publication_message', 'server_list', 'online_config', 'hot_upgrade');

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
