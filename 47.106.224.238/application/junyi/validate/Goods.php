<?php
    namespace app\junyi\validate;

    use think\Validate;

    class Goods extends Validate
    {
        protected $rule = [
            //验证规则，require验证是否存在，
            //length验证长度
            'title'  =>  'require',
            'cost' =>  'require',
            'price' => 'require',
            'weight' => 'require',
            'inventory' => 'require',
        ];

        protected $message = [
            'title.require'  =>  '商品名称不能为空！',
            'cost.require' =>  '成本不能为空！',
            'price.require' =>  '售出价格不能为空！',
            'weight.require' =>  '重量不能为空！',
            'inventory.require' =>  '库存价格不能为空！',

        ];

    }