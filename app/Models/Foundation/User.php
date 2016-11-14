<?php
/**
 * Created for someline-starter.
 * User: Libern
 */

namespace Someline\Models\Foundation;

use Someline\Model\Foundation\User as BaseUser;

class User extends BaseUser
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'gender', 'birthday', 'country', 'timezone', 'locale', 'username', 'phone_number', 'status', 'avatar',
        'client_id', 'wechat_id', 'qq_id', 'uuid', 'source', 'device', 'guest'
    ];
    //protected $guarded = ['id', 'created_at', 'updated_at', 'created_by', 'created_ip', 'updated_ip', 'wealth'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * Called when model is created
     * Other events available are in BaseModelEvents
     */
    public function onCreated()
    {
        parent::onCreated();

    }


    //自定义验证字段代替 email
    public function findForPassport($username)
    {
        $data['phone_number'] = $username;
        $validator = \Validator::make($data, [
            'phone_number' => 'required|zh_mobile'
        ]);
        if (!$validator->fails()) {
            return User::where('phone_number', $username)->first();
        }
        return User::where('username',$username)->first() ;
    }

}
