<?php
namespace app\junyi\Controller;
use app\junyi\controller\Base;
use app\junyi\model\Rule as RuleModel;
use think\Db;
use think\Session;

/**
* 权限管理
*/
class Rule extends Base
{

	public function index(){
		$qx = $this->qx();

		if (in_array('权限管理',$qx)) {
			// 查出所有权限分类
			$cate = db("junyi_admincate")->select();

			// 获取当前文件的上级目录
			$con = dirname(__FILE__);
			// 扫描$con目录下的所有文件
			$filename = scandir($con);
			// 定义一个数组接收文件名
			$conname = array();
			foreach($filename as $k=>$v){
				// 跳过两个特殊目录   continue跳出循环
				if($v=="." || $v==".."){continue;}
				//截取文件名，我只需要文件名不需要后缀;然后存入数组
				$conname[] = substr($v,0,strpos($v,"."));
			}

			// 存储控制器名称给upd方法执行修改
			Session::set('conname',$conname);

			// 查询层级为1的菜单列表
			$rule = db("junyi_rule")->where("level",1)->select();

			// 查询权限管理列表
			$res = (new RuleModel)->All_list();
			$this->assign([
				"cate"=>$cate,
				"conname"=>$conname,
				"res"=>$res,
				"rule"=>$rule
			]);
			
			return view("index");
		}else{
			return view("noauthority/index");
		}	
	}

	/**
	 * [add 添加权限管理]
	 */
	public function add(){
		if (request()->isAjax()){
			$x_qx = $this->x_qx();
			if(!$x_qx){
				return false;
			}else{
				foreach ($x_qx as $key => $value) {
					
					if($value=='Rule/add'){
						$data = $_REQUEST['data'];
						// 不能为这三个;
						if($data['admincate_id']=="规则分类"){
							return 1;
						}else if($data['controller']=="请求控制器"){
							return 2;
						}else if($data['action']=="请求方法"){
							return 3;
						}

						$url[] = $data['controller'];
						$url[] = $data['action'];
						// 拆分规则
						$url = implode("/",$url);

						$indata = [
							"url"=>$url,
							"name"=>$data['name'],
							"admincate_id"=>$data['admincate_id'],
							"pid"=>$data['pid'],
							"level"=>$data['level']
						];

						$insert = (new RuleModel)->add($indata);
						
						if($insert){
							return 4;
						}else{
							return 5;
						}
					}
				}	
				return false;
			}
			
		}

	}

	/**
	 * [upd 修改权限管理]
	 * @param  [type] $id [修改的ID]
	 * @return [type]     [description]
	 */
	public function upd($id){

		if (request()->isPost()) {
			$data = $_REQUEST['data'];
			$url[] = $data['controller'];
			$url[] = $data['action'];
			// 拆分规则
			$url = implode("/",$url);

			$upddata = [
				"url"=>$url,
				"name"=>$data['name'],
				"admincate_id"=>$data['admincate_id'],
				"pid"=>$data['pid'],
				"level"=>$data['level']
			];
			return (new RuleModel)->upd($id,$upddata);
		}

		if (request()->isAjax()) {
			$x_qx = $this->x_qx();
			if(!$x_qx){
				return false;
			}else{
				foreach ($x_qx as $key => $value) {

					if($value=='Rule/upd'){
						return true;
					}
				}	
				return false;
			}
		}

		if (request()->isGet()) {
			// 查出所有权限分类
			$cate = db("junyi_admincate")->select();
			// 查询层级为1的菜单列表
			$rule = db("junyi_rule")->where("level",1)->select();
			// 获取控制器名称
			$conname = Session::get("conname");

			$map['id'] = $id;
			$res = (new RuleModel)->one($map);
			$this->assign([
				"cate"=>$cate,
				"conname"=>$conname,
				"res"=>$res,
				"rule"=>$rule
			]);
			return view('upd');
		}
	}

	/**
	 * [del 删除权限管理  多选删除]
	 * @param  [type] $id [删除的id]
	 * @return [type]     [description]
	 */
	public function del($id){
		if (request()->isAjax()){
			$x_qx = $this->x_qx();
			if(!$x_qx){
				return false;
			}else{
				foreach ($x_qx as $key => $value) {
					if($value=='Rule/del'){
						return (new RuleModel)->del($id);
					}
				}
				return false;
			}
		}
	}









}