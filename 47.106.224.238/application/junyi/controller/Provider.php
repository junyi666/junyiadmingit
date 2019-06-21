<?php
namespace app\junyi\controller;
use app\junyi\controller\Base;
use app\junyi\model\Provider as ProviderModel;
/**
* 供应商控制器
*/
class Provider extends Base
{

	 public function index(){
			$qx = $this->qx();
			if (in_array('商品供货商',$qx)) {
				$list = (new ProviderModel)->lst();

				$this->assign([
					"list"=>$list,
				]);
				return view("index");
			}else{
				return view("noauthority/index");
			}
	 }

	 /**
	  * [add 执行添加]
	  */
	 public function add(){

		if(request()->isAjax()) {
			$x_qx = $this->x_qx();
			if(!$x_qx){
				return false;
			}else{
				foreach ($x_qx as $key => $value) {
					// 验证是否有权限  没有则不进行添加；
					if($value=='Provider/add'){

						$data = [
				 			'name'=>$_REQUEST['data']['name'],
				 		];
				 		if((new ProviderModel)->add($data)){
				 			return true;
				 		}else{
				 			return false;
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
			$upd = (new ProviderModel)->upd($id,$data);
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

					if($value=='Provider/upd'){
						return true;
					}
				}	
				return false;
			}
		}
		if (request()->isGet()) {
			// 查询当前修改的数据赋予默认值
			$map['id'] = $id;
			$res = (new ProviderModel)->one($map);
			$this->assign('res',$res);
			return view('upd');
		}
	}



	/**
	 * [del 删除供货商  多选删除]
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
					if($value=='Provider/del'){
						return (new ProviderModel)->del($id);
					}
				}
				return false;
			}
		}
	}

}