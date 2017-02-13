<?php

class Prices_model extends CI_Model {
    var $primary_key = 'price_id';
    var $table_name = 'prices';
	
	public function add($data)
    {
        $this->db->insert($this->table_name, $data);
    }
	
	public function edit($data)
    {
		$array_update = array(
			'operator_id' => $data['operator_id'],
			'price' => $data['price'],
			'buy_price' => $data['buy_price'],
			'sell_price' => $data['sell_price'],
			'active' => $data['active']
		);
        
        $this->db->set($array_update);
        $this->db->where($this->primary_key, $data['id']);
		$this->db->where($this->Admins_model->primary_key, $data['admin_id']);
        $this->db->update($this->table_name);
    }
    
    public function edit_by_param($data)
	{
		return $this->db->get_where($this->table_name, array(
			$this->primary_key => $data['price_id'],
			$this->Admins_model->primary_key => $data['admin_id']
		) )->row();
	}
	
	public function list_all($param)
    {
        $this->db->select('o.operator_name, p.*');
        $this->db->from($this->table_name.' as p');
		$this->db->join($this->Operators_model->table_name.' as o', 'o.'.$this->Operators_model->primary_key.' = p.operator_id', 'left');
		$this->db->where('p.admin_id', $param['admin_id']);
		$this->db->like('o.operator_name', $param['operator_name']);
		$this->db->like('p.price', $param['price']);
		$this->db->like('p.active', $param['active']);
		$data['total'] = $this->db->count_all_results();
		
		$this->db->select('o.operator_name, p.*');
        $this->db->from($this->table_name.' as p');
		$this->db->join($this->Operators_model->table_name.' as o', 'o.'.$this->Operators_model->primary_key.' = p.operator_id', 'left');
		$this->db->where('p.admin_id', $param['admin_id']);
		$this->db->like('o.operator_name', $param['operator_name']);
		$this->db->like('p.price', $param['price']);
		$this->db->like('p.active', $param['active']);
        $this->db->order_by($param['sort'], $param['order']);
        if (isset($param['limit']))
		{
			$param['offset'] = ( ($param['offset'] >= $data['total'] && $data['total'] > 0) ? ($param['offset'] - $param['limit']) : $param['offset']);
			$this->db->limit($param['limit'], $param['offset']);
		}
        $data['rows'] = $this->db->get()->result();
		
		return $data;
    }
    
    public function prices_by_operator_id($param)
	{
		$data = $this->Settings_model->setting_value_by_code('label_active');
		$active = $data->setting_value;
		
		$this->db->from($this->table_name);
		$this->db->where(array(
			'admin_id' => $param['admin_id'],
			'operator_id' => $param['operator_id'],
			'active' => $active
		));
		$this->db->order_by('price', 'asc');
		$data = $this->db->get()->result();
		return $data;
	}
	
	public function prices_by_price_id($param)
	{
		$data = $this->Settings_model->setting_value_by_code('label_active');
		$active = $data->setting_value;
		
		$this->db->from($this->table_name);
		$this->db->where(array(
			'price_id' => $param['price_id'],
			'admin_id' => $param['admin_id'],
			'active' => $active
		));
		$data = $this->db->get()->row();
		return $data;
	}
	
	public function remove($data)
	{
		$this->db->where($this->primary_key, $data['id']);
		$this->db->where($this->Admins_model->primary_key, $data['admin_id']);
		$this->db->delete($this->table_name);
	}
	
}

?>