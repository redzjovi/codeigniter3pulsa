<?php

class customers_model extends CI_Model {
    var $MY_Controller;
	var $primary_key = 'user_id';
    var $table_name = 'user_detail';
	
	public function add($data)
    {
        $data['password'] = 'customer';
		$user_id = $this->users_model->add($data, 'customer');
		
		$array_insert = array(
			'user_id' => $user_id,
			'name' => $data['name'],
			'address' => $data['address'],
			'sub_district' => $data['sub_district'],
			'regency' => $data['regency'],
			'province' => $data['province'],
			'post_code' => $data['post_code'],
			'phone' => $data['phone']
		);
		
		$this->db->insert($this->table_name, $array_insert);
    }
	
	public function edit($data)
    {
		$this->users_model->edit_user($data);
		
		$array_update = array(
			'name' => $data['name'],
			'address' => $data['address'],
			'sub_district' => $data['sub_district'],
			'regency' => $data['regency'],
			'province' => $data['province'],
			'post_code' => $data['post_code'],
			'phone' => $data['phone']
		);
        
        $this->db->set($array_update);
        $this->db->where($this->primary_key, $data[$this->primary_key]);
        $this->db->update($this->table_name);   
    }
    
    public function list_all($param)
    {
        $usertype_id = $this->usertype_model->get_id_by_code('customer');
		
		$data['total'] = $this->db->from($this->users_model->table_name)->where($this->usertype_model->primary_key, $usertype_id)->count_all_results();
		$param['offset'] = ( ($param['offset'] == $data['total'] && $data['total'] > 0) ? ($param['offset'] - $param['limit']) : $param['offset']);
		
		$this->db->select('*');
        $this->db->from($this->users_model->table_name.' as u');
		$this->db->join($this->table_name.' as ud', 'ud.'.$this->users_model->primary_key.' = u.'.$this->users_model->primary_key);
        $this->db->where($this->usertype_model->primary_key, $usertype_id);
		$filter = json_decode($param['filter']);
		if ($filter)
		{
			foreach ($filter as $k => $v)
			{
				$this->db->like($k, $v);
			}
		}
        $this->db->order_by($param['sort'], $param['order']);
        $this->db->limit($param['limit'], $param['offset']);
        
        $data['rows'] = $this->db->get()->result();
		// echo $this->db->last_query();
		return $data;
    }
    
    public function remove($id)
	{
		$this->db->where($this->primary_key, $id);
		$this->db->delete($this->table_name);
		
		$this->users_model->remove($id);
	}
	
	public function row($id)
	{
		$this->db->select('*');
        $this->db->from($this->users_model->table_name.' as u');
		$this->db->join($this->table_name.' as ud', 'ud.'.$this->users_model->primary_key.' = u.'.$this->primary_key);
		$this->db->join($this->usertype_model->table_name.' as ut', 'ut.'.$this->usertype_model->primary_key.' = u.'.$this->usertype_model->primary_key);
		$this->db->where('u.'.$this->users_model->primary_key, $id);
		$this->db->where('ut.usertype_code', 'customer');
		
		return $this->db->get()->row();
	}
}

?>