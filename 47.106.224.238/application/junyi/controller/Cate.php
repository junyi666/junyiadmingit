<?php
namespace app\junyi\controller;
use app\junyi\controller\Base;
use think\Db;
use app\junyi\model\Cate as CateModel;
/**
* 分类控制器
*/
class Cate extends Base
{
	public  function index(){
		$qx = $this->qx();

		
		if (in_array('多级分类',$qx)) {
			//调用递归查询查出3级分类
			$list = (new CateModel)->All_list();

			$this->assign([
				"list"=>$list,
			]);
			return view("index");
		}else{
			return view("noauthority/index");
		}	
	}

	/**
	 * [add 添加顶级分类]
	 * ajax提交
	 */
	public function add(){

		if (request()->isAjax()) {
			$x_qx = $this->x_qx();
			if(!$x_qx){
				return false;
			}else{
				foreach ($x_qx as $key => $value) {

					if($value=='Cate/add'){
						$name = $_POST['name'];
						$pid = 0;
						$data = [
							"name"=>$name,
							"pid"=>$pid,
						];
						$insert = (new CateModel)->add($data);
						if($insert){
							return 1;
						}else{
							return 2;
						}
					}
				}	
				return false;
			}
		}
	}

	/**
	 * [addsub 添加下级分类]
	 * @param  [type] $id [上级ID  默认为0不然程序会报错]
	 * @return [type]     [description]
	 */
	public function addsub($id=0){

		if (request()->isPost()) {

			// 定义插入参数
			$data = $_REQUEST['data'];
			$insert = (new CateModel)->add($data);
			if($insert){
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

					if($value=='Cate/add'){
						return true;
					}
				}	
				return false;
			}
		}

		if (request()->isGet()) {
			// 查询要插入子类的ID
			$id = db("junyi_cate")->field('id')->where('id',$id)->find();
			$this->assign('id',$id);
			return view('addsub');
		}

	}

	/**
	 * [upd 修改分类]
	 * @param  [type] $id [修改分类的ID]
	 * @return [type]     [description]
	 */
	public function upd($id){


		if (request()->isPost()) {

			// 获取修改参数
			$data = $_REQUEST['data'];
			$upd = (new CateModel)->upd($id,$data);
			if($upd){
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

					if($value=='Cate/upd'){
						return true;
					}
				}	
				return false;
			}
		}

		if (request()->isGet()) {
			// 查询当前修改的数据赋予默认值
			$map['id'] = $id;
			$res = (new CateModel)->one($map);
			$this->assign('res',$res);
			return view('upd');
		}
	}


	/**
	 * [del 删除分类]
	 * @param  [type] $id [删除分类的ID]
	 * @return [type]     [成功或失败]
	 */
	public function del($id){
		if (request()->isAjax()){
			$x_qx = $this->x_qx();
			if(!$x_qx){
				return false;
			}else{
				foreach ($x_qx as $key => $value) {
					if($value=='Cate/del'){
						$map['pid'] = $id;
						$res = (new CateModel)->one($map);
						// 判断当前分类是否有子类有则不执行删除
						if($res){
							return 1;
						}else{
							$del = (new CateModel)->del($id);
							if($del){
								return 2;
							}else{
								return 3;
							}
						}
					}
				}
				return false;
			}
		}
	}



}

	