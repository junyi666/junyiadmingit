<?php

	namespace app\junyi\controller;

	use app\junyi\controller\Base;
	use think\Db;
	use app\junyi\model\Junyiadmin as JunyiadminModel;


	/**
	* 管理员列表
	*/
	class Junyiadmin extends Base
	{
		public function index(){
			
			$qx = $this->qx();

			if (in_array('管理员列表',$qx)) {
				$role_id = db("junyi_role")->select();

				$res = db('junyi_username')->order('id asc')->paginate(5);
				$this->assign([
					'res' => $res,
					'role_id' => $role_id
				]);
				return view('index');

			}else{
				return view("noauthority/index");
			}	
		}

		public function add(){

			if (request()->isPost()) {

				$data = $_REQUEST['data'];
				unset($data['repass']);
				//执行验证
				

				$result = $this->validate($data,'Member');
				if(true !== $result){
				    // 验证失败 输出错误信息
				    return $result;
				}
				if (!db("junyi_username")->where('name',$data['name'])->find()) {
					$data['time'] =date('Y-m-d h:i:s', time());
					$data['pass'] = md5($data['pass']);
					if(db("junyi_username")->insert($data)){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}

			if (request()->isAjax()) {
				$x_qx = $this->x_qx();
				if ($x_qx!=false) {
					foreach ($x_qx as $key => $value) {
						if($value=='Junyiadmin/add'){
							return true;
						}
					}	
					return false;
				}else{
					return false;
				}
			}

			if (request()->isGet()) {
				$role_id = db("junyi_role")->select();
				$this->assign([
					'role_id' => $role_id
				]);
				return view("add");				
			}

		}

		/**
		 * [upd 修改账户资料 不包括密码]
		 * @param  [type] $id [description]
		 * @return [type]     [description]
		 */
		public function upd($id){

			if (request()->isPost()) {
				if (db("junyi_username")->where("id",$id)->update($_REQUEST['data'])) {
					return true;
				}else{
					return false;
				}
			}

			if (request()->isAjax()) {
				$x_qx = $this->x_qx();
				if ($x_qx!=false) {
					foreach ($x_qx as $key => $value) {
						if($value=='Junyiadmin/upd'){
							return true;
						}
					}	
					return false;
				}else{
					return false;
				}
			}

			if (request()->isGet()) {
				// 查询角色
				$role_id = db("junyi_role")->select();

				$res = db("junyi_username")->where('id',$id)->find();
				$this->assign([
					"res"=>$res,
					"role_id"=>$role_id
				]);
				return view("upd");				
			}
		}

		/**
		 * [upd_pass 修改账户密码]
		 * @param  [type] $id [description]
		 * @return [type]     [description]
		 */
		public function upd_pass($id){

			if (request()->isPost()) {
				$res = db("junyi_username")->where("id",$id)->find()['pass'];
				if($res==md5($_REQUEST['data']['pass'])){
					$data = [
						'pass'=>md5($_REQUEST['data']['upd_pass'])
					];
					$upd = db("junyi_username")->where("id",$id)->update($data);
					if($upd){
						return 2;
					}
				}else{
					return 1;
				}
			}

			if (request()->isAjax()) {
				$x_qx = $this->x_qx();
				if ($x_qx!=false) {
					foreach ($x_qx as $key => $value) {
						if($value=='Junyiadmin/upd_pass'){
							return true;
						}
					}	
					return false;
				}else{
					return false;
				}
			}

			if (request()->isGet()) {
				$this->assign('id',$id);
				return view('upd_pass');			
			}
		}

		/**
		 * [del 删除账户]
		 * @return [type] [description]
		 */
		public function del(){
			if (request()->isAjax()) {
				$x_qx = $this->x_qx();
				if ($x_qx!=false) {
					foreach ($x_qx as $key => $value) {
						if($value=='Junyiadmin/del'){
							return db("junyi_username")->where("id",$_REQUEST['id'])->delete();
						}
					}	
					return 10001;
				}else{
					return false;
				}
				
			}
		}

		/**
		 * [dels 批量删除]
		 * @return [type] [description]
		 */
		public function dels(){
			if (request()->isAjax()) {
				$x_qx = $this->x_qx();
				if ($x_qx!=false) {
					foreach ($x_qx as $key => $value) {
						if($value=='Junyiadmin/del'){
							foreach ($_REQUEST['id'] as $key => $val) {
								$res = db("junyi_username")->where("id",$val)->delete();
							}
							if ($res) {
								return true;
							}
						}
					}	
					return 10001;
				}else{
					return false;
				}
			}
		}

		/**
		 * [sreach 搜索]
		 * @return [type] [description]
		 */
		public function sreach(){
			return $_REQUEST['data']['end'];
			$res = db("junyi_username")->where('name','like',"%".$_REQUEST['data']."%")->limit(10)->select();
			if($res){
				return $res;
			}else{
				return false;
			}
		}


		/**
		 * [status 修改状态]
		 * @param  [type] $id [description]
		 * @return [type]     [description]
		 */
		public function status($id){

			if (request()->isAjax()) {
				$x_qx = $this->x_qx();

				if ($x_qx!=false) {
					foreach ($x_qx as $key => $value) {
						if($value=='Junyiadmin/status'){
							$status = db("junyi_username")->field('status')->where("id",$id)->find();
							// 判断当前状态是启用还是禁用1为启用;
							if($status['status']==1){
								$res = db("junyi_username")->where("id",$id)->update(["status"=>0]);
								if($res){
									return 1;
								}
							}else{
								$res = db("junyi_username")->where("id",$id)->update(["status"=>1]);
								if($res){
									return 2;
								}
							}
						}
					}	
					return 10001;
				}else{
					return false;
				}
			}
		}	

		/**
		 * [username 查询用户名是否存在]
		 * @param  [type] $name [输入的用户名]
		 * @return [type]       [description]
		 */
		public function username($name){
			$data = db("junyi_username")->where("name",$name)->select();
			if($data!=null){
				return false;
			}else{
				return true;
			}
		}

	}