<?php
	namespace app\junyi\controller;

	use think\Controller;
	use think\Db;
	use think\Session;

	class Login extends Controller{
		
		public function index(){
			return view('index');
		}

		public function lst(){
			if(request()->isAjax()){
				$captcha = input("data.captcha");
				if(!captcha_check($captcha)){
				    return 10001;
				}else{
					$data = $_REQUEST['data'];
					
					//执行验证
					$result = $this->validate($data,'User');
					if(true !== $result){
					    // 验证失败 输出错误信息
					    return $result;
					}
					$data['pass'] = md5($data['pass']);
					unset($data['captcha']);
					$data['status'] = 1;

					if (db('junyi_username')->where($data)->find()) {
						session::set('name',$data['name']);
						return true;
					}else{
						return false;
					}					
				}
			}
		}
	}