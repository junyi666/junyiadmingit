<?php
	namespace app\junyi\model;

	use think\Db;
	use think\Model;

	/**
	 *  会员页
	 */
	class Member extends Model
	{

		//查询分页
		public function lst(){
			return db('junyi_user')->paginate(2);
		}


		/**
		 * [add 添加]
		 * @param [type] $data [description]
		 */
		public function add($data){

			if(!db('junyi_user')->where('phone',$data['phone'])->find()){

				$data['pass'] = md5($data['pass']);
				return db('junyi_user')->insert($data);
			}
			return false;
		}


		/**
		 * [lst_d 查询单条数据]
		 * @param  [type] $id [description]
		 * @return [type]     [description]
		 */
		public function lst_d($id){
			return db('junyi_user')->where('id',$id)->find();
		}


		/**
		 * [upd 修改]
		 * @param  [type] $id   [description]
		 * @param  [type] $data [description]
		 * @return [type]       [description]
		 */
		public function upd($id,$data){
			return db('junyi_user')->where('id',$id)->update($data);
		}


		/**
		 * [del 删除]
		 * @param  [type] $id [description]
		 * @return [type]     [description]
		 */
		public function del($id){
			return db('junyi_user')->where('id',$id)->delete();
		}
	}