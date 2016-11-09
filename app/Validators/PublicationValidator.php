<?php

namespace Someline\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class PublicationValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'package_name' => 'required|unique:publications',
            'min_version' => 'required|string|min:1|max:10',
            'max_version' => 'string|string|min:1|max:10',
            'min_time' => 'required|datetime',
            'max_time' => 'required|datetime',
            'uuids' => 'json'

        ],
        ValidatorInterface::RULE_UPDATE => [
            'package_name' => 'required',
            'version' => 'required|string',
            'uuid' => 'required|string'
        ],
    ];
}
