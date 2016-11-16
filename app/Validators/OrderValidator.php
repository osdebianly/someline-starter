<?php

namespace Someline\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class OrderValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'price' => 'required|numeric|between:1,30000',  //单位是元
            'title' => 'max:100',
            'note' => 'max:100',
            'pay_type' => 'string|in:alipay,alipay_app,wechatpay,wechatpay_app',
            'no_pay' => 'integer|in:0,1',
            'once_pay' => 'integer|in:0,1',
            'notify_url' => 'url'
        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];
}
