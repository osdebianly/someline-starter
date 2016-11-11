<?php

namespace Someline\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class UserValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'username' => 'required|alpha_dash|min:3|max:32|unique:users',
            'email' => 'email|max:255',
            'password' => 'required|string|min:3|max:100',
            'uuid' => 'required|string|min:30|max:32',
            'source' => 'string|min:2|max:24',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'phone_number' =>'regex:/^1[34578][0-9]{9}$/',
            //'gender' => 'boolean' ,
        ],
        /**
         * 合并登录验证
         */
        'merge' => [
            //'username' => 'required|alpha_dash|min:3|max:32|regex:/[A-Za-z]+/',
            'username' => 'alpha_dash|min:3|max:32|unique:users',
            'email' => 'email|max:255',
            'password' => 'string|min:3|max:100',
            'uuid' => 'required|string|min:30|max:64',
            'source' => 'string|min:2|max:24',
            'client_id' => 'required',
            'client_secret' => 'required'
        ],
    ];


}