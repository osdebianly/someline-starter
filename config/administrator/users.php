<?php

use Someline\Models\Foundation\User;

return [

    'title' => '用户列表',
    'heading' => '用户管理',
    'single' => '用户',
    'model' => User::class,

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'name' => [
            'title' => '用户名',
        ],
        'username' => [
            'title' => '昵称',
            'type' => 'text'
        ],
        'phone_number' => [
            'title' => '手机号码',
            'type' => 'text'
        ],
        'email' => [
            'title' => 'Email',
        ],
        'created_at' => [
            'title' => '创建时间'
        ],

        'operation' => [
            'title' => '管理',
            'output' => function ($value, $model) {
                return $value;
            },
            'sortable' => false,
        ],
    ],

    'edit_fields' => [
        'name' => [
            'title' => '用户名',
            'type' => 'text'
        ],
        'gender' => [
            'title' => '性别',
        ],
        'birthday' => [
            'title' => '生日',
            'type' => 'date'
        ],
        'username' => [
            'title' => '昵称',
            'type' => 'text'
        ],
        'phone_number' => [
            'title' => '手机号码',
            'type' => 'text'
        ],
        'email' => [
            'title' => 'Email',
        ],
        'weixin_id' => [
            'title' => '微信 OpenID',
        ],
        'qq_id' => [
            'title' => 'QQ OpenID',
        ],
        'reg_uuid' => [
            'title' => '设备UUID',
        ],
        'source' => [
            'title' => '渠道',
        ],
        'device' => [
            'title' => '设备型号',
        ],
    ],

    'filters' => [
        'phone_number' => [
            'title' => '手机号',
        ],
        'username' => [
            'title' => '昵称',
        ],
        'name' => [
            'title' => '用户名',
        ],
        'email' => [
            'title' => 'Email',
        ],

    ],
];