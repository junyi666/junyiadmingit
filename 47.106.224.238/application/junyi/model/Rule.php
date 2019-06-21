<?php
namespace app\junyi\model;
use think\Model;
use think\Db;

/**
* 权限管理模型
*/
class Rule extends Model
{
	/**
	 * [$table 定义表名]
	 * @var string
	 */
	protected $table = "junyi_rule";

	public function lst($map=null){

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

	/**
	 * [All_list 获取分类数]
	 * @param  integer $pid [分类的父级id]
	 * @return [array]            [分类数信息]
	 */
	public function All_list($pid=0){
		$map['pid'] = $pid;
		$res = $this->lst($map);
		foreach($res as $key=>$val){
			$res[$key]["child"] = $this->All_list($val["id"]);
		}
		return $res;
	}	

}