<?php

class Admins_model extends CI_Model {
	var $primary_key = 'admin_id';
	var $table_name = 'admins';

	public function edit($param)
	{
		$password = $this->Auth_model->hash_password($param['new_password']);
		
		$array_update = array(
			'password' => $password
		);
		
		$this->db->set($array_update);
        $this->db->where($this->primary_key, $param['admin_id']);
		$this->db->update($this->table_name);
	}
	
	public function edit_by_param($id)
	{
		return $this->db->get_where($this->table_name, array($this->primary_key => $id))->row();
	}
	
	public function old_password_check($admin_id, $password)
	{
		$password = $this->Auth_model->hash_password($password);
		$data = $this->db->get_where($this->table_name, array($this->primary_key => $admin_id, 'password' => $password))->row();
		return $data;
	}
	
}

?>