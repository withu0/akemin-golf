<?php

return [

    'required' => ':attribute 为必填项。',
    'email'    => ':attribute 必须是有效的电子邮箱地址。',
    'max'      => [
        'string' => ':attribute 不能超过 :max 个字符。',
    ],

    'attributes' => [
        'name'     => '姓名',
        'email'    => '电子邮箱',
        'country'  => '国家 / 地区',
        'interest' => '感兴趣的内容',
        'message'  => '留言',
    ],

];
