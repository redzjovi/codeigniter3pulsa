<?php

class usertype_model extends CI_Model {
    var $table_name = 'usertype';
	var $primary_key = 'usertype_id';
	
	public function get_id_by_code($usertype = 'customer')
    {
        $query = $this->db->select($this->primary_key)->get_where($this->table_name, array('usertype_code' => $usertype))->row();
		return $query->usertype_id;
    }
}

?>