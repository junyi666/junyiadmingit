<?php
namespace app\junyi\Controller;
use app\junyi\controller\Base;
use app\junyi\model\Attr as AttrModel;
/**
* 商品属性控制器
*/
class Attr extends Base
{

	public function index(){
			$qx = $this->qx();
			if (in_array('商品属性',$qx)) {
				$list = (new AttrModel)->lst();

				$this->assign([
					"list"=>$list,
				]);
				return view("index");
			}else{
				return view("noauthority/index");
			}
	}

	/**
	 * [add 添加属性]
	 */
	public function add(){
		if (request()->isPost()) {
			$data = $_REQUEST['data'];
			$data['value'] = str_replace("，",",",$data['value']);

			if((new AttrModel)->add($data)){
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

					if($value=='Attr/add'){
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
	 * [upd 修改属性]
	 * @param  [type] $id [修改属性的ID值]
	 * @return [type]     [description]
	 */
	public function upd($id){
		if (request()->isPost()) {
			// 获取修改参数
			$data = $_REQUEST['data'];
			$data['value'] = str_replace("，",",",$data['value']);
			$upd = (new AttrModel)->upd($id,$data);
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

					if($value=='Attr/upd'){
						return true;
					}
				}	
				return false;
			}
		}

		if (request()->isGet()) {
			// 查询当前修改的数据赋予默认值
			$map['id'] = $id;
			$res = (new AttrModel)->one($map);
			$this->assign('res',$res);
			return view('upd');
		}
			
	}

	/**
	 * [del 删除属性，多选删除属性]
	 * @param  [type] $id [删除的属性ID  多个ID为数组格式]
	 * @return [type]     [description]
	 */
	public function del($id){
		if (request()->isAjax()){
			$x_qx = $this->x_qx();
			if(!$x_qx){
				return false;
			}else{
				foreach ($x_qx as $key => $value) {
					// 判断有没有删除权限
					if($value=='Attr/del'){
						return (new AttrModel)->del($id);
					}
				}
				return 10001;
			}
		}
	}
}
