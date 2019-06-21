<?php
	namespace app\junyi\controller;

	use app\junyi\controller\Base;

	/**
	* 首页
	*/
	class Welcome extends Base
	{
		
		public  function index(){
			$qx = $this->qx();
			if (in_array('首页',$qx)) {
				return view("index");

			}else{
				return view("noauthority/index");
			}					
		}
	}

	