<?php

	namespace app\junyi\controller;

	use app\junyi\controller\Base;

	/**
	* 三级地区联动
	*/
	class City extends Base
	{
		public function index(){
			$qx = $this->qx();

			if (in_array('三级地区联动',$qx)) {
				return view("index");
			}else{
				return view("noauthority/index");
			}	
		}
	}