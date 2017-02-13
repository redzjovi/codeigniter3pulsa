<?php

class product_users_model extends CI_Model {
    var $primary_key_1 = 'product_id';
	var $primary_key_2 = 'user_id';
	var $table_name = 'product_users';
	
	public function check_exist($product_id, $user_id)
    {
        $count = $this->db->from($this->table_name)
			->where($this->primary_key_1, $product_id)
			->where($this->primary_key_2, $user_id)
			->count_all_results();
		return ($count > 0) ? true : false;
    }
	
	public function add($data)
    {
		$exist = $this->check_exist($data['product_id'], $data['user_id']);
	
		if ($exist == false)
		{
			$array_insert= array(
				'product_id' => $data['product_id'],
				'user_id' => $data['user_id']
			);
			(isset($data['buy_price'])) ? $array_insert['buy_price'] = $data['buy_price'] : '';
			(isset($data['sell_price'])) ? $array_insert['sell_price'] = $data['sell_price'] : '';
			$this->db->insert($this->table_name, $array_insert);
        }
	}
	
	public function edit($data)
    {
		$exist = $this->check_exist($data['product_id'], $data['user_id']);
	
		if ($exist == false)
		{
			$array_insert = array(
				'product_id' => $data['product_id'],
				'user_id' => $data['user_id']
			);
			(isset($data['buy_price'])) ? $array_insert['buy_price'] = $data['buy_price'] : '';
			(isset($data['sell_price'])) ? $array_insert['sell_price'] = $data['sell_price'] : '';
			$this->db->insert($this->table_name, $array_insert);
        }
		else if ($exist == true)
		{
			$array_update = array(
				'product_id' => $data['product_id'],
				'user_id' => $data['user_id']
			);
			(isset($data['buy_price'])) ? $array_update['buy_price'] = $data['buy_price'] : '';
			(isset($data['sell_price'])) ? $array_update['sell_price'] = $data['sell_price'] : '';
			$this->db->where($this->primary_key_1, $data['product_id']);
			$this->db->where($this->primary_key_2, $data['user_id']);
			$this->db->update($this->table_name, $array_update);
        }
	}
	
	public function product_users_by_product_id($product_id, $usertype_code)
	{
		$this->db->select('pu.*, u.email, ud.name');
		$this->db->from($this->table_name.' as pu');
		$this->db->join($this->users_model->table_name.' as u', 'u.user_id = pu.'.$this->primary_key_2, 'left');
		$this->db->join($this->usertype_model->table_name.' as ut', 'ut.'.$this->usertype_model->primary_key.' = u.usertype_id', 'left');
		$this->db->join('user_detail as ud', 'ud.user_id = pu.'.$this->primary_key_2, 'left');
		$this->db->where('pu.'.$this->primary_key_1, $product_id);
		$this->db->where('ut.usertype_code', $usertype_code);
		($usertype_code == 'marketplace') ? $this->db->order_by('u.email', 'asc') : '';
		($usertype_code == 'supplier') ? $this->db->order_by('ud.name', 'asc') : '';
		
		return $this->db->get()->result();
	}
	
	public function remove($id)
	{
		$this->db->where($this->primary_key_1, $id);
		$this->db->delete($this->table_name);
	}

	public function remove_by_user_id_usertype($user_id = array(), $usertype_code)
	{
		// $this->db->from($this->table_name.' as pu');
		// $this->db->join($this->users_model->table_name.' as u', 'on u.user_id = pu.user_id', 'left');
		// $this->db->join($this->usertype_model->table_name.' as ut', 'on ut.usertype_id = u.usertype_id', 'left');
		// $this->db->where_not_in('pu.user_id', $user_id);
		// $this->db->where('ut.usertype_code', $usertype_code);
		// $this->db->delete($this->table_name.' as pu');
		
		$user_id = ($user_id) ? "'".implode("','", $user_id)."'" : '';
		$this->db->query(
			"delete pu.* from ".$this->table_name." as pu ".
			"left join ".$this->users_model->table_name." as u on u.user_id = pu.".$this->primary_key_2." ".
			"left join ".$this->usertype_model->table_name." as ut on ut.".$this->usertype_model->primary_key." = u.usertype_id ".
				"where pu.".$this->primary_key_2." not in (".$user_id.")".
				"and ut.usertype_code = '".$usertype_code."'");
		// echo $this->db->last_query();
	}
}

?>