<?php

class Auth_model extends CI_Model {
	
	public function add($params)
	{
		$array_insert = array(
			'email' => $params['email'],
			'password' => $this->hash_password($params['password']),
			'active' => 1
		);
		$this->db->insert($this->Admins_model->table_name, $array_insert);
	}
	
	public function auth_check($email, $password)
    {
		return $this->db->get_where($this->Admins_model->table_name,
            array(
                'email' => $email,
                'password' => $this->hash_password($password)
            )
        )->row();
    }
	
	public function auth_check_without_hash_password($email, $password)
    {
		return $this->db->get_where($this->Admins_model->table_name,
            array(
                'email' => $email,
                'password' => ($password)
            )
        )->row();
    }
	
	public function auth_check_without_password($email)
    {
		return $this->db->get_where($this->Admins_model->table_name,
            array(
                'email' => $email
            )
        )->row();
    }
	
	public function edit_password($params)
	{
		$array_update = array(
			'password' => $this->hash_password($params['new_password'])
		);
		
		$this->db->set($array_update);
        $this->db->where('email', $params['email']);
		$this->db->where('password', $params['old_password']);
		$this->db->update($this->Admins_model->table_name);
	}	
	
	public function hash_password($password = '')
    {
        return hash('md5', $password);
    }
    
}

?>