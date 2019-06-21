<?php

	namespace app\junyi\controller;

	use app\junyi\controller\Base;
	use app\junyi\model\Member as MemberModel;
	use think\Db;
header("Content-type: text/html; charset=utf-8");
	/**
	* 会员列表
	*/
	class Member extends Base
	{	

		public function index(){
			$qx = $this->qx();
			if (in_array('会员列表',$qx)) {
				$res = (new MemberModel)->lst();
	
				$this->assign([
					"res"=>$res
				]);
				return view('index');
			}else{
				return view("noauthority/index");
			}	
		}


		/**
		 *	 
		 * [add 添加会员信息]
		 * unset  删除掉$data里多余的字段
		 * $result 调用验证器执行验证
		 * 
		 */
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
				if((new MemberModel)->add($data)){
					return true;
				}else{
					return false;
				}
			}

			if (request()->isAjax()) {
				$x_qx = $this->x_qx();
				if(!$x_qx){
					return false;
				}else{
					foreach ($x_qx as $key => $value) {

						if($value=='Member/add'){
							return true;
						}
					}	
					return false;
				}
			}

			if (request()->isGet()) {
				return view("add");
			}
			
		}


		/**
		 * [upd 修改会员基本信息，不包括密码]
		 * @param  [type] $id [会员的id]
		 * @return [type]     [description]
		 */
		public function upd($id){
			if (request()->isPost()) {
				if ((new MemberModel)->upd($_REQUEST['id'],$_REQUEST['data'])) {
					return true;
				}else{
					return false;
				}				
			}

			if (request()->isAjax()) {
				$x_qx = $this->x_qx();
				if(!$x_qx){
					return false;
				}else{
					foreach ($x_qx as $key => $value) {

						if($value=='Member/upd'){
							return true;
						}
					}	
					return false;
				}
			}

			if (request()->isGet()) {
				$res = (new MemberModel)->lst_d($id);
				$this->assign([
					"res"=>$res
				]);
				return view("upd");
			}
			
		}


		/**
		 * [upd_pass 修改会员的密码]
		 * @param  [type] $id [会员的id]
		 * @return [type]     [description]
		 */
		public function upd_pass($id){

			if (request()->isPost()) {
				//验证旧密码是否正确
				if ((new MemberModel)->lst_d($_REQUEST['id'])['pass']==md5($_REQUEST['oldpass'])) {
					$data = [
						'pass'=>md5($_REQUEST['pass'])
					];
					return (new MemberModel)->upd($_REQUEST['id'],$data);
				}
				return false;		
			}

			if (request()->isAjax()) {
				$x_qx = $this->x_qx();
				if(!$x_qx){
					return false;
				}else{
					foreach ($x_qx as $key => $value) {

						if($value=='Member/upd_pass'){
							return true;
						}
					}	
					return false;
				}
			}

			if (request()->isGet()) {
				$this->assign('id',$id);
				return view('upd_pass');
			}
		}


		/**
		 * [del 删除会员，添加至已删除列表，保存信息]
		 * @return [type] [description]
		 */
		public function del(){

			if (request()->isAjax()) {
				$x_qx = $this->x_qx();
				if(!$x_qx){
					return false;
				}else{
					foreach ($x_qx as $key => $value) {

						if($value=='Member/del'){
							$res = (new MemberModel)->lst_d($_REQUEST['id']);
							$res['time'] = date("Y-m-d H:i:s");
							$res['username'] = $_REQUEST['username'];
							
							if(db("junyi_user_sc")->insert($res)){
								return (new MemberModel)->del($_REQUEST['id']);
							}else{
								return 500;
							}
						}
					}	
					return false;
				}
			}
		}


		/**
		 * [dels 循环删除会员]
		 * @return [type] [description]
		 */
		public function dels(){
			if (request()->isAjax()) {
				$x_qx = $this->x_qx();
				if(!$x_qx){
					return false;
				}else{
					foreach ($x_qx as $key => $value) {
						if($value=='Member/del'){
							foreach ($_REQUEST['id'] as $k => $val) {
								$res = (new MemberModel)->lst_d($val);
								$res['time'] = date("Y-m-d H:i:s");
								$res['username'] = $_REQUEST['username'];
								if (db("junyi_user_sc")->insert($res)) {
									$res = (new MemberModel)->del($val);
								}
							}
							if ($res) {
								return true;
							}
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
				return db("junyi_user")->where('phone','like',"%".$_REQUEST['phone']."%")->limit(1)->select();				
			}
		}
	}