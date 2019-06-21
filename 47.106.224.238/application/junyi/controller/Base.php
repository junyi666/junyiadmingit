<?php
	namespace app\junyi\controller;

	use think\Controller;
	use think\Db;
	use think\Session;
	use think\Cache;

	/**
	* 
	*/
	class Base extends Controller
	{
		//自动执行验证
		public function _initialize(){
			if(!Session::get('name')){
				$this->redirect('Login/index');
			}
			$role_id = db("junyi_username")->where("name",Session::get('name'))->value("role_id");
		}

		/**
		 * [tc 退出]
		 * @return [type] [description]
		 */
		public function tc(){
			session_destroy();
			$this->redirect('Login/index');
		}

		/**
		 * [qx 权限校验]
		 * @return [type] [description]
		 */
		public function qx(){
			$role_id =  $this->role_id();

			$rule_id = db("junyi_access")->where('role_id',$role_id)->select();

			foreach ($rule_id as $key => $v) {
				$admincate[] = db("junyi_rule")->where("id",$v['rule_id'])->where("level",1)->value("name");
			}
			 return $admincate;
		}

		/**
		 * [x_qx 增删改权限]
		 * @return [type] [description]
		 */
		public function x_qx(){
			if (Cache::get('admincate')) {
				return Cache::get('admincate');
			}else{
				$role_id =  $this->role_id();
				
				// 查出角色对应权限
				$access = db("junyi_access")->where('role_id',$role_id)->where('level',2)->select();
				if ($access) {
					foreach ($access as $key => $value) {
						$admincate[] = db("junyi_rule")->where("id",$value['rule_id'])->value("url");
					}
					 
					Cache::set('admincate',$admincate,30);
					return Cache::get('admincate');	
				}else{
					return false;
					
				}
			}

		}	

		/**
		 * [role_id 查询当前的权限]
		 * @return [type] [description]
		 */
		public function role_id(){
			return db("junyi_username")->where("name",Session::get('name'))->value("role_id");
		}
	}