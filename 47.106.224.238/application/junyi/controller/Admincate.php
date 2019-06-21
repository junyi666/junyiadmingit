<?php
namespace app\junyi\Controller;
use app\junyi\controller\Base;
use app\junyi\model\Admincate as AdminModel;
/**
* 权限分类控制器
*/
class Admincate extends Base
{
	
	public function index(){
		$qx = $this->qx();

		if (in_array('权限分类',$qx)) {
			// 查找数据
			$res = (new AdminModel)->lst();
			
			$this->assign('res',$res);
			return view("index");
		}else{
			return view("noauthority/index");
		}	
	}


	public function add(){
		// 执行添加;
		if (request()->isAjax()) {
			$x_qx = $this->x_qx();
			if(!$x_qx){
				return false;
			}else{
				foreach ($x_qx as $key => $value) {
					if($value=='Admincate/add'){
						$name = $_POST['name'];
						$data = [
							"name"=>$name,
						];
						$insert = (new AdminModel)->add($data);
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
	 * [upd 修改分类]
	 * @param  [type] $id [修改分类的ID]
	 * @return [type]     [description]
	 */
	public function upd($id){

		if (request()->isPost()) {
			// 获取修改参数
			$data = $_REQUEST['data'];
			$upd = (new AdminModel)->upd($id,$data);
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

					if($value=='Admincate/upd'){
						return true;
					}
				}	
				return false;
			}
		}

		if (request()->isGet()) {
			// 查询当前修改的数据赋予默认值
			$map['id'] = $id;
			$res = (new AdminModel)->one($map);
			$this->assign('res',$res);
			return view('upd');
		}
	}


	/**
	 * [del 删除分类   批量删除]
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

					if($value=='Admincate/del'){
						$del = (new AdminModel)->del($id);
						if($del){
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




}











