<?php
namespace app\junyi\Controller;
use app\junyi\controller\Base;
use app\junyi\model\Provider;
use app\junyi\model\Cate;
use app\junyi\model\Attr;
/**
* 商品管理控制器
*/
class Goods extends Base
{

	public function index(){
		$qx = $this->qx();
		if (in_array('商品管理',$qx)) {
			

			return view('index');

		}else{
			return view("noauthority/index");
		}	
	}


	public function add(){

		if(request()->isPost()){
			// 定义插入参数
			// 这里处理商品的缩略图
		    // $pic_bre = request()->file('pic_bre');
	     //    foreach($pic_bre as $value){
		    //   // 移动到框架应用根目录/public/uploads/ 目录下
		    //   $info = $value->move(ROOT_PATH . 'public' . DS . '/uploads');
		    //   return $info;
		    //   if($info){
	     //   		// 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
		    //       $original = $info->getSaveName();

		    //    }else{
		    //        // 上传失败获取错误信息
		    //        echo $value->getError();
		    //    }    
		    // }	

			// 处理商品图片
		    //接收上传的文件
		    $data = $_REQUEST['data'];
			//执行验证
			$result = $this->validate($data,'Goods');
			if(true !== $result){
			    // 验证失败 输出错误信息
			    return $result;
			}
		    $file = request()->file('pic');
            if(!empty($file)){
            	$pic = $this->upload($file);
				$photo = str_replace("\\","/",$pic);

            }else{
            	return "请选择商品图片!";
            }
		    
			$data['pic'] = $photo;
			return $data;

		    

		}




		if (request()->isAjax()) {
			$x_qx = $this->x_qx();
			if ($x_qx!=false) {
				foreach ($x_qx as $key => $value) {
					if($value=='Goods/add'){
						return true;
					}
				}	
				return false;
			}else{
				return false;
			}
		}

		if (request()->isGet()) {
			// 查询供货商
			$provider = (new Provider)->list_all();
			// 查询商品分类
			$cate = (new Cate)->All_list();
			// 查询商品属性
			$attr = (new Attr)->list_all();
			$this->assign([
				"provider"=>$provider,
				"cate"=>$cate,
				"attr"=>$attr,
			]);
			return view("add");				
		}

	}












}