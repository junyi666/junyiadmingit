<?php
    namespace app\junyi\validate;

    use think\Validate;

    class Member extends Validate
    {
        protected $rule = [
            //验证规则，require验证是否存在，
            //length验证长度
            'name'  =>  'require',
            'phone' =>  'require',
            'email' => 'email',
            'pass' => 'require',
        ];

        protected $message = [
            'name.require'  =>  '用户名不能为空',
            'phone.require' =>  '手机号码不能为空',
            'email' => '邮箱格式错误',
            'pass.require' => '密码不能为空',
        ];

    }
