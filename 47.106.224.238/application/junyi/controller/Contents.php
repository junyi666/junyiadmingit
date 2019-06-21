<?php
	namespace app\junyi\controller;

	use app\junyi\controller\Base;
	use app\junyi\model\Contents as ContentsModel;

	/**
	 *内容管理页面
	 */
	 class Contents extends ContentsModel
	 {
	 	public function index(){
	 		return view("index");
	 	}
	 } 