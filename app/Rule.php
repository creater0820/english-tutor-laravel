<?php

namespace App;

class Rule
{
    public static function memberStoreRules($type)
    {
        $rule =  [];
        switch ($type) {
            case 'create':
                $rule['name'] = 'required|max:50|unique:users,name';
                $rule['tags'] = "required";
                $rule['email'] = 'required|email|min:8|unique:users,email';
            case 'login':
                $rule['password'] = 'required|max:16|min:8';
                $rule['email'] = 'required|email|min:8';
         
        }
        return $rule;
    }
    public static function validationRule($type)
    {
        $rule =  [];
        switch ($type) {
            case 'plan':
                $rule['title'] = 'required|max:30';
                $rule['content'] = "required";
                $rule['amount'] = 'required|integer|max:10000000';
                $rule['tags'] = 'required';
        }
        return $rule;
    }
    public static function validationReview($type)
    {
        $rule =  [];
        switch ($type) {
            case 'review';
            $rule['review'] = 'required';
            $rule['star'] = 'required';
        }
        return $rule;
    }

    public static function memberStoreMessages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.unique' => 'このユーザー名は既に使用されています',
            'name.max' => '50文字以下で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.min' => '8文字以上で入力してください',
            'email.email' => 'メールアドレスの形式で入力してください',
            'email.different' => 'メールアドレスが一致しません  ',

            'email.unique' => 'このメールアドレスは既に使用されています',
            'password.required' => 'パスワードを入力してください',
            'password.different' => 'パスワードが',
            'password.max' => '16文字以下で入力してください',
            'password.min' => '8文字以上で入力してください',
            'tags.required' => 'タグを１つ以上選択してください',
            'title.required' => 'タイトルを入力してください',
            'title.max' => '３０文字以下で入力してください',
            'amount.required' => '金額を入力してください',
            'amount.integer' => '数値を入力してください',
            'amount.max' => '金額を少なく修正してください',
            'content.required' => '内容を入力してください',

            'review.required' => 'レビューを入力してください',
            'star.required' => '評価を選択してください',

        ];
    }
}
