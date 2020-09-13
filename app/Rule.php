<?php

namespace App;

class Rule
{
    public static function memberStoreRules($type)
    {
        $rule =  [
        ];
        switch ($type) {
            case 'create':
                $rule['name'] = 'required|max:20';
                // $rule['address'] = 'required';
                // $rule['profile'] = 'required';
            case 'login':
                $rule['password'] = 'required';
                $rule['email'] = 'required';
        }
        return $rule;
    }

    public static function memberStoreMessages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.max' => '20文字以上は入力できません',
            'email.required' => 'メールアドレスを入力してください',
            'password.required' => 'パスワードを入力してください',
            // 'address.required' => '住所を入力してください',
            // 'profile.required' => 'プロフィールを入力してください',
        ];
    }
}
