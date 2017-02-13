<?php

class marketplace_model extends CI_Model {
    
	public function add($data)
    {
        $data['password'] = 'marketplace';
		$user_id = $this->users_model->add($data, 'marketplace');
	}
	
	public function edit($data)
    {
		$this->users_model->edit_user($data);
    }
    
    public function list_all($param)
    {
        $usertype_id = $this->usertype_model->get_id_by_code('marketplace');
		
		$data['total'] = $this->db->from($this->users_model->table_name)->where($this->usertype_model->primary_key, $usertype_id)->count_all_results();
		$param['offset'] = ( ($param['offset'] == $data['total'] && $data['total'] > 0) ? ($param['offset'] - $param['limit']) : $param['offset']);
		
		$this->db->select('*');
        $this->db->from($this->users_model->table_name);
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
    
    public function list_all_for_product()
    {
        $usertype_id = $this->usertype_model->get_id_by_code('marketplace');
		
		$data = $this->db->select('u.user_id, u.email as name')
			->from($this->users_model->table_name.' as u')
			->where($this->usertype_model->primary_key, $usertype_id)
			->where('active', 1)
			->order_by('name', 'asc')
			->get()->result();
		
		return $data;
    }
	
	public function remove($id)
	{
		$usertype_id = $this->usertype_model->get_id_by_code('marketplace');
		
		$this->db->where($this->users_model->primary_key, $id);
		$this->db->where($this->usertype_model->primary_key, $usertype_id);
		$this->db->delete($this->users_model->table_name);
		
		$this->users_model->remove($id);
	}
	
	public function row($id)
	{
		$this->db->select('u.*');
        $this->db->from($this->users_model->table_name.' as u');
		$this->db->join($this->usertype_model->table_name.' as ut', 'ut.'.$this->usertype_model->primary_key.' = u.'.$this->usertype_model->primary_key);
		$this->db->where('u.'.$this->users_model->primary_key, $id);
		$this->db->where('ut.usertype_code', 'marketplace');
		return $this->db->get()->row();
	}
}

?>