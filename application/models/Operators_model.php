<?php

class Operators_model extends CI_Model {
    var $primary_key = 'operator_id';
    var $table_name = 'operators';
	
	public function add($data)
    {
        $this->db->insert($this->table_name, $data);
    }
	
	public function edit($data)
    {
		$array_update = array(
			'operator_name' => $data['operator_name'],
			'active' => $data['active']
		);
        
        $this->db->set($array_update);
        $this->db->where($this->primary_key, $data['id']);
		$this->db->where($this->Admins_model->primary_key, $data['auth_id']);
        $this->db->update($this->table_name);   
    }
    
    public function edit_by_param($data)
	{
		return $this->db->get_where($this->table_name, array(
			$this->primary_key => $data['id'],
			$this->Admins_model->primary_key => $data['auth_id']
		) )->row();
	}
	
	public function list_all($param)
    {
        $this->db->select('*');
        $this->db->from($this->table_name);
		$this->db->where('admin_id', $param['admin_id']);
		$this->db->like('operator_name', $param['operator_name']);
		$this->db->like('active', $param['active']);
        $data['total'] = $this->db->count_all_results();
		
		$this->db->select('*');
        $this->db->from($this->table_name);
		$this->db->where('admin_id', $param['admin_id']);
		$this->db->like('operator_name', $param['operator_name']);
		$this->db->like('active', $param['active']);
        $this->db->order_by($param['sort'], $param['order']);
		if (isset($param['limit']))
		{
			$param['offset'] = ( ($param['offset'] >= $data['total'] && $data['total'] > 0) ? ($param['offset'] - $param['limit']) : $param['offset']);
			$this->db->limit($param['limit'], $param['offset']);
		}
        $data['rows'] = $this->db->get()->result();
		
		return $data;
    }
    
    public function operators_for_prices($auth_id)
	{
		$data = $this->Settings_model->setting_value_by_code('label_active');
		$active = $data->setting_value;
		
		$this->db->select('*');
        $this->db->from($this->table_name);
		$this->db->where('admin_id', $auth_id);
		$this->db->like('active', $active);
        $this->db->order_by('operator_name', 'asc');
        $data = $this->db->get()->result();
		return $data;
	}
	
	public function remove($data)
	{
		$this->db->where($this->primary_key, $data['id']);
		$this->db->where($this->Admins_model->primary_key, $data['auth_id']);
		$this->db->delete($this->table_name);
	}
	
}

?>