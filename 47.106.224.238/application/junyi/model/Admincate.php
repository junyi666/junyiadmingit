<?php
namespace app\junyi\model;
use think\Model;
use think\Db;

/**
* 权限分类模型
*/
class Admincate extends Model
{
	public function lst($map=null){

		$res = db('junyi_admincate')->where($map)->order('id desc')->select();

		return $res;
	}
	/**
	 * [add 添加]
	 * @param  [type] $data [添加的参数]
	 * @return [type]       [description]
	 */
	public function add($data){

		$res = db('junyi_admincate')->insert($data);

		return $res;
	}

	/**
	 * [upd 修改]
	 * @param  [type] $id [修改的ID]
	 * @param  [type] $data    [修改的参数值]
	 * @return [type]          [description]
	 */
	public function upd($id,$data){
		$res = db('junyi_admincate')->where('id',$id)->update($data);

		return $res;
	}

	/**
	 * [del 删除]
	 * @param  [type] $id [删除的ID值]
	 * @return [type]          [description]
	 */
	public function del($id){
		$res = db('junyi_admincate')->delete($id);

		return $res;
	}

	/**
	 * [one 查询单条数据]
	 * @param  [type] $map [定义查询条件]
	 * @return [type]      [description]
	 */
	public function one($map=null){

		$res = db('junyi_admincate')->where($map)->find();

		return $res;
	}

}