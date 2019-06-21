<?php
namespace app\junyi\Controller;
use app\junyi\controller\Base;
use app\junyi\model\Role as RoleModel;

/**
* 角色管理
*/
class Role extends Base
{

	public function index(){
		$qx = $this->qx();
		if (in_array('角色管理',$qx)) {
			$res = (new RoleModel)->lst();
			$admincate = db('junyi_admincate')->select();

			$this->assign([
				"res"=>$res,
				"admincate"=>$admincate,
			]);
			return view("index");
		}else{
			return view("noauthority/index");
		}	
	}

	/**
	 * [add 添加角色]
	 */
	public function add(){

	
		if (request()->isPost()) {

			$data = $_REQUEST['data'];
			// 拆分数组插入角色表角色拥有的分类
			$admincate_id = implode(",",$data['cate']);
			$rule = $data['id'];

			//定义角色表插入参数
			$roledata = [
				"name"=>$data['name'],
				"admincate_id"=>$admincate_id,
				"desc"=>$data['desc'],
				"add_time"=>time(),
			];
			$id = (new RoleModel)->add($roledata);
			if($id){
				foreach($rule as $v){
					// 定义插入access表的参数
					$tmp = explode(",",$v);
					$accdata =[
						"role_id"=>$id,
						"rule_id"=>$tmp[0],
						"level"=>$tmp[1],
					];
					$accinsert = db("junyi_access")->insert($accdata);
					if(!$accinsert){
						return false;
					}
				}
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

					if($value=='Role/add'){
						return true;
					}
				}	
				return false;
			}
		}

		if (request()->isGet()) {
			// 查出分类
			$admincate = db('junyi_admincate')->select();
			foreach($admincate as $k=>$v){
				// 定义查询条件
				$admincate[$k]['rule'] = db('junyi_rule')->where(['admincate_id'=>$v['id'],'level'=>1])->select();
				
			}
			//循环查找列表模块下面对应的方法然后插入到每个列表的模块下面
			foreach($admincate as $key=>$val){
				foreach($val['rule'] as $k=>$v){
					// 定义接收方法的键值，插入admincate下面rule数组里面然后再进入一层插入到每个列表模块下面对应起来
					$admincate[$key]['rule'][$k]['param'] =db('junyi_rule')->where(['pid'=>$v['id'],'level'=>2])->select();
				}
			}
			$this->assign([
				"admincate"=>$admincate,
			]);

			return view("add");
		}
	}	

	/**
	 * [upd 修改角色]
	 * @param  [type] $id [修改的角色ID]
	 * @return [type]     [description]
	 */
	public function upd($id){
	
		if (request()->isPost()) {

			$data = $_REQUEST['data'];
			// 拆分数组插入角色表角色拥有的分类
			$admincate_id = implode(",",$data['cate']);
			$rule = $data['id'];
			//定义角色表插入参数
			$roledata = [
				"name"=>$data['name'],
				"admincate_id"=>$admincate_id,
				"desc"=>$data['desc'],
				"edi_time"=>time(),
			];
			$updata = (new RoleModel)->upd($id,$roledata);
			if($updata){
				$del = db("junyi_access")->where("role_id",$id)->delete();
				if($del){
					foreach($rule as $v){
						// 定义插入access表的参数
						$tmp = explode(",",$v);
						$accdata =[
							"role_id"=>$id,
							"rule_id"=>$tmp[0],
							"level"=>$tmp[1],
						];
						if(!db("junyi_access")->insert($accdata)){
							return false;
						}
					}
				}else{
					return false;
				}
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

					if($value=='Role/upd'){
						return true;
					}
				}	
				return false;
			}
		}

		if (request()->isGet()) {
			// 查出修改角色的默认值
			$map['id']=$id;
			$res = (new RoleModel)->one($map);
			// 查出分类
			$admincate = db('junyi_admincate')->select();

			// 查出角色对应权限
			$access = db("junyi_access")->where('role_id',$id)->select();

			foreach($admincate as $k=>$v){
				// 定义查询条件
				$admincate[$k]['rule'] = db('junyi_rule')->where(['admincate_id'=>$v['id'],'level'=>1])->select();
				
			}
			//循环查找列表模块下面对应的方法然后插入到每个列表的模块下面
			foreach($admincate as $key=>$val){
				foreach($val['rule'] as $k=>$v){
					// 定义接收方法的键值，插入admincate下面rule数组里面然后再进入一层插入到每个列表模块下面对应起来
					$admincate[$key]['rule'][$k]['param'] =db('junyi_rule')->where(['pid'=>$v['id'],'level'=>2])->select();
				}
			}
			// print_r($access);
			$this->assign([
				"admincate"=>$admincate,
				"res"=>$res,
				"access"=>$access,
			]);
			return view("upd");
		}
	}

	public function del($id){

		if (request()->isAjax()){
			$x_qx = $this->x_qx();
			if(!$x_qx){
				return false;
			}else{
				foreach ($x_qx as $key => $value) {

					if($value=='Role/del'){
						$del = (new RoleModel)->del($id);
						if($del){
							return db("junyi_access")->where("role_id",$id)->delete();
						}
					}
				}	
				return false;
			}
		}
	}

}