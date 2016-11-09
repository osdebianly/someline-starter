<?php

namespace Someline\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class PayValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'number' => 'required|numeric|min:10|max:10000'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'verify_code' => 'required|numeric|min:1000|max:9999'
        ],
    ];
}
