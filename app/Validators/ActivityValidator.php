<?php

namespace Someline\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ActivityValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [],
        ValidatorInterface::RULE_UPDATE => [],
        /**
         * 好评过滤
         */
        'good_reputation' => [
            'message' => 'string',
            'pic_url' => 'required|url'
        ],
    ];
}
