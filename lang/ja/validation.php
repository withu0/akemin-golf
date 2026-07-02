<?php

return [

    'required' => ':attribute は必須です。',
    'email'    => ':attribute は有効なメールアドレスで入力してください。',
    'max'      => [
        'string' => ':attribute は:max文字以内で入力してください。',
    ],

    'attributes' => [
        'name'     => 'お名前',
        'email'    => 'メールアドレス',
        'country'  => 'お住まいの国・地域',
        'interest' => '興味のあること',
        'message'  => 'メッセージ',
    ],

];
