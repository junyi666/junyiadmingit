<?php
    namespace app\junyi\validate;

    use think\Validate;

    class User extends Validate
    {
        protected $rule = [
            //验证规则，require验证是否存在，
            //length验证长度
            'name'  =>  'require',
            'pass' =>  'require',
        ];

        protected $message = [
            'name.require'  =>  '用户名不能为空',
            'pass.require' =>  '密码不能为空',
        ];
    }
