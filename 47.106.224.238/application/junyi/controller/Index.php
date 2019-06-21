<?php
	namespace app\junyi\controller;

	use app\junyi\controller\Base;

	/**
	* 首页
	*/
	class Index extends Base
	{
		public  function index(){
			return view("index");
		}
	}

	