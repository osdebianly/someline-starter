<?php

use Someline\Models\Publication;

return [

    'title' => '配置列表',
    'heading' => '公告配置',
    'single' => '公告配置',
    'model' => Publication::class,

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'package_name' => [
            'title' => '包名',
        ],
        'min_version' => [
            'title' => '最小版本',
        ],
        'min_time' => [
            'title' => '开始时间',
        ],
        'uuids' => [
            'title' => '设备白名单(留空-所有设备生效)',
        ],
        'created_at' => [
            'title' => '创建时间',
        ]

    ],

    'edit_fields' => [
        'package_name' => [
            'title' => '包名',
            'type' => 'text'
        ],
        'min_version' => [
            'title' => '最小版本',
            'type' => 'text'
        ],
        'max_version' => [
            'title' => '最大版本',
            'type' => 'text'
        ],
        'min_time' => [
            'title' => '开始时间(y-m-d h:i)',
            'type' => 'datetime',
        ],
        'max_time' => [
            'title' => '结束时间(y-m-d h:i:s)',
            'type' => 'datetime'
        ],
        'uuids' => [
            'title' => '设备UUID(json)',
            'type' => 'textarea'
        ],
        'publication_message' => [
            'title' => '公告消息(文本)',
            'type' => 'textarea'
        ],
        'online_config' => [
            'title' => '在线配置(json)',
            'type' => 'textarea'
        ],
        'server_list' => [
            'title' => '服务器列表(json)',
            'type' => 'textarea'
        ],
        'hot_upgrade' => [
            'title' => '热更(json)',
            'type' => 'textarea'
        ],


    ],

    'filters' => [
        'package_name' => [
            'title' => '包名',
        ],
    ],
    'rules' => array(
        'package_name' => 'required',
        'min_time' => 'required|date',
        'max_time' => 'required|date|after:min_time',
        'uuids' => 'json',
        'publication_message' => 'string',
        'online_config' => 'json',
        'server_list' => 'json',
        'hot_upgrade' => 'json'
    ),
    'messages' => array(
        'package_name.required' => '包名不能为空',
        'min_time.required' => '开始时间不能为空',
        'max_time.required' => '结束时间不能为空',
    ),
];