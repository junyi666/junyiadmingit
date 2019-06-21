<?php

	namespace app\junyi\controller;

	use app\junyi\controller\Base;
	use think\Db;
	/**
	* 	会员删除
	*/
	class Memberdel extends Base
	{

		/**
		 * 定义表名
		 */
		protected $table = "junyi_user_sc";

		/**
		 * [index description]
		 * @return [type] [description]
		 */
		public function index(){
			$qx = $this->qx();

			if (in_array('会员删除',$qx)) {
				$res = db($this->table)->paginate(2);
				return view('index',["res"=>$res]);
			}else{
				return view("noauthority/index");
			}	
		}
			
		/**
		 * [del 恢复该会员信息]
		 * @return [type] [description]
		 */
		public function del(){
			if (request()->isAjax()) {
				$x_qx = $this->x_qx();
				if ($x_qx!=false) {
					foreach ($x_qx as $key => $value) {
						if($value=='Memberdel/add'){
							$res = db($this->table)->where("id",$_REQUEST['id'])->find();
							unset($res['time']);
							unset($res['username']);
							if(db("junyi_user")->insert($res)){
								return db($this->table)->where("id",$_REQUEST['id'])->delete();
							}
							return false;
						}
					}
					return false;
				}else{
					return false;
				}
			}
		}


		public function dels(){
			if (request()->isAjax()) {
				$x_qx = $this->x_qx();
				if ($x_qx!=false) {
					foreach ($x_qx as $key => $value) {
						if($value=='Memberdel/add'){
							foreach ($_REQUEST['ids'] as $key => $val) {
								$res =  db($this->table)->where("id",$val)->find();

								unset($res['time']);
								unset($res['username']);
								
								if (db("junyi_user")->insert($res)) {
									$res = db($this->table)->where("id",$val)->delete();
								}
							}
							if ($res) {
								return true;
							}
							return false;
						}
					}
					return false;
				}
			}
		}

		/**
		 * [sreach 搜索会员]
		 * @return [type] phone [手机号码]
		 */
		public function sreach(){
			if (request()->isAjax()) {
				return db($this->table)->where('phone','like',"%".$_REQUEST['phone']."%")->limit(1)->select();				
			}
		}
	}