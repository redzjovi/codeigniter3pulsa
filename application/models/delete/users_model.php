<?php

class users_model extends CI_Model {
    var $table_name = 'users';
	var $primary_key = 'user_id';
	
	public function add($data, $usertype = 'customer')
    {
        $usertype_id = $this->usertype_model->get_id_by_code($usertype);
		
		$data_insert = array(
			'usertype_id' => $usertype_id,
			'email' => $data['email'],
			'password' => $this->Auth_model->hash_password($data['password']),
			'active' => $data['active']
		);
		$this->db->insert($this->table_name, $data_insert);
		
		return $this->db->insert_id();
    }
	
	public function edit_user($data)
    {
        $array_update = array(
            'email' => $data['email'],
            'active' => $data['active']
        );
        
        $this->db->set($array_update);
        $this->db->where($this->primary_key, $data[$this->primary_key]);
        $this->db->update($this->table_name);   
    }
	
	public function remove($id)
	{
		$this->db->where($this->primary_key, $id);
		$this->db->delete($this->table_name);
	}
} 