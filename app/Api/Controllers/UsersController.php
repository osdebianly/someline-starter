<?php

namespace Someline\Api\Controllers;

use Hash;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Someline\Http\Requests\UserCreateRequest;
use Someline\Http\Requests\UserUpdateRequest;
use Someline\Repositories\Interfaces\UserRepository;
use Someline\Validators\UserValidator;
use Illuminate\Http\Request;
use Someline\Models\Foundation\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Dingo\Api\Exception\ResourceException;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Status;
use Someline\Events\OAuthTokenPasswordLogin;


class UsersController extends BaseController
{

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserValidator
     */
    protected $validator;


    public function __construct(UserRepository $repository, UserValidator $validator)
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {

        $data = $request->all();

        $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

        // encrypt password
        $data['password'] = bcrypt($data['password']);

        $user = $this->repository->create($data);

        // throw exception if store failed
//        throw new StoreResourceFailedException('Failed to store.');

        // A. return 201 created
//            return $this->response->created(null);

        // B. return data
        return $user;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     */
    public function loginMerge(UserCreateRequest $request)
    {

        /**
         * 校验
         */
        $this->validator->with($request->all())->passesOrFail('merge');
        $data = $request->all();

        /**
         * 检查一键登录(用户名密码为空)
         */
        if (empty($data['username'])) {
            /**
             * 检查该 uuid 是否注册过
             */
            try {
                $user = User::where('uuid', $data['uuid'])->where('guest', 1)->firstOrFail();
                $data['password'] = $data['username'] = $user->username;
            } catch (ModelNotFoundException $e) {
                $data['password'] = $data['username'] = username_generate();
                $data['guest'] = 1;
            }
        }
        /**
         * 检查用户名是否是手机号码
         */
        $validator = \Validator::make($data, [
            'username' => 'required|zh_mobile'
        ]);
        if (!$validator->fails()) {

            try {
                $user = User::where('phone_number', $data['username'])->firstOrFail();
                if (!Hash::check($data['password'], $user->password)) {
                    throw new ResourceException('手机号或密码错误');
                }
                $data['username'] = $user->username;
            } catch (ModelNotFoundException $e) {
                throw new ResourceException('该手机号码未绑定过');
            }

        } else {

            try {
                $user = User::where('username', $data['username'])->firstOrFail();
                if (!Hash::check($data['password'], $user->password)) {
                    throw new ResourceException('用户名或密码错误');
                }
            } catch (ModelNotFoundException $e) {
                /**
                 * 小号检查
                 */
                $maxUserNumber = config('game-server.maxUserNumber');
                $users = User::where('uuid', $data['uuid'])->get(['username']);
                if ($users->count() > $maxUserNumber) {
                    throw new ResourceException('该设备达到注册上限');
                }
                $user = User::create($data);
            }
        }
        /**
         * 获取 Token
         */
        $client = new \GuzzleHttp\Client(['base_uri' => config('app.url'), 'exceptions' => false,]);
        $postData = array_merge($data, ['grant_type' => 'password']);
        $response = $client->post('oauth/token', ['form_params' => $postData]);
        $resutJSON = $response->getBody();
        $tokenInfo = json_decode($resutJSON, true);

        /**
         *  登录成功推送到后台
         */

        if (isset($tokenInfo['access_token'])) {
            $tokenInfo['session'] = md5($tokenInfo['access_token']);
            $eventInfo = [
                'post_info' => $data,
                'user_info' => $user->toArray(),
                'token_info' => $tokenInfo
            ];
            event(new OAuthTokenPasswordLogin($eventInfo));
        }


        return $tokenInfo;

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
     * Display current logged in User info
     *
     * @return mixed
     */
    public function me()
    {
        $user_id = auth_user()->getUserId();
        return $this->repository->find($user_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(UserUpdateRequest $request, $id)
    {

        //验证用户信息,只有自己才能更新, todo 考虑放在 rule 验证
//        $authID = auth_user()->getUserId();
//        if ($authID != $id) {
//            throw new UpdateResourceFailedException();
//        }
        $data = $request->only('name', 'gender', 'birthday', 'phone_number', 'avatar');
        $data['gender'] = $data['gender'] ? 'M' : 'F';
        $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

        //处理头像

        $user = $this->repository->update($data, $id);

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
            throw new DeleteResourceFailedException();
        }
    }

    /**
     * 已登录用户修改密码
     * @param Request $request
     * @return array
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function restPassword(Request $request)
    {
        $this->validator->with($request->all())->passesOrFail('password');
        $user = current_auth_user();
        if (!Hash::check($request->old_password, $user->password)) {
            throw new ResourceException('旧密码错误');
        }
        $user->password = bcrypt($request->password);
        $user->save();

        return ['status_code' => Status::HTTP_OK, 'message' => '修改成功'];
    }


}
