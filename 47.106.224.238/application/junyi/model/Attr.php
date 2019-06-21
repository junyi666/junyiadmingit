<?php
namespace app\junyi\model;
use think\Model;
use think\Db;

/**
* 商品属性模型
*/
class Attr extends Model
{

	/**
	 * [$table 定义表名]
	 * @var string
	 */
	protected $table = "junyi_attr";

	public function lst($map=null){

		$res = db($this->table)->where($map)->order('id desc')->paginate(30);

		return $res;
	}

	/**
	 * [list_all 查询所有]
	 * @param  [type] $map [description]
	 * @return [type]      [description]
	 */
	public function list_all($map=null){

		$res = db($this->table)->where($map)->order('id desc')->select();

		return $res;
	}

	
	/**
	 * [add 添加]
	 * @param  [type] $data [添加的参数]
	 * @return [type]       [description]
	 */
	public function add($data){

		$res = db($this->table)->insert($data);

		return $res;
	}

	/**
	 * [upd 修改]
	 * @param  [type] $id [修改的ID]
	 * @param  [type] $data    [修改的参数值]
	 * @return [type]          [description]
	 */
	public function upd($id,$data){
		$res = db($this->table)->where('id',$id)->update($data);

		return $res;
	}

	/**
	 * [del 删除]
	 * @param  [type] $id [删除的ID值]
	 * @return [type]          [description]
	 */
	public function del($id){
		$res = db($this->table)->delete($id);

		return $res;
	}

	/**
	 * [one 查询单条数据]
	 * @param  [type] $map [定义查询条件]
	 * @return [type]      [description]
	 */
	public function one($map=null){

		$res = db($this->table)->where($map)->find();

		return $res;
	}




}