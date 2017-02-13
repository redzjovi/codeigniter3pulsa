<?php

class products_model extends CI_Model {
    var $primary_key = 'product_id';
	var $table_name = 'products';
	
	
    public function add($data)
    {
        $data_insert = array(
			'product_code' => $data['product_code'],
			'product_name' => $data['product_name'],
			'buy_product' => $data['buy_product'],
			'produce_product' => $data['produce_product'],
			'sell_product' => $data['sell_product'],
			'stock_product' => $data['stock_product'],
			'product_category' => $data['product_category'],
			'product_description' => $data['product_description'],
			'weight' => $data['weight'],
			'buy_price' => 0,
			'sell_price' => 0,
			'active' => $data['active']
		);
		$this->db->insert($this->table_name, $data_insert);
		$product_id = $this->db->insert_id();
		// debugvar($data_insert);
		// debugvar($data['marketplace_id']);
		// debugvar($data['sell_price']); 
		if ($data['supplier_id'])
		{
			foreach ($data['supplier_id'] as $k => $v)
			{
				$data_insert = array(
					'product_id' => $product_id,
					'user_id' => $v,
					'buy_price' => $data['buy_price'][$k]
				);
				$this->product_users_model->add($data_insert);
			}
		}
		if ($data['marketplace_id'])
		{
			foreach ($data['marketplace_id'] as $k => $v)
			{
				$data_insert = array(
					'product_id' => $product_id,
					'user_id' => $v,
					'sell_price' => $data['sell_price'][$k]
				);
				$this->product_users_model->add($data_insert);
			}
		}
    }
    
	public function edit($data)
    {
		$data_edit = array(
			'product_code' => $data['product_code'],
			'product_name' => $data['product_name'],
			'buy_product' => $data['buy_product'],
			'produce_product' => $data['produce_product'],
			'sell_product' => $data['sell_product'],
			'stock_product' => $data['stock_product'],
			'product_category' => $data['product_category'],
			'product_description' => $data['product_description'],
			'weight' => $data['weight'],
			'buy_price' => 0,
			'sell_price' => 0,
			'active' => $data['active']
		);
        $this->db->set($data_edit);
        $this->db->where($this->primary_key, $data[$this->primary_key]);
        $this->db->update($this->table_name);
		
		debugvar($data['marketplace_id']);
		debugvar($data['sell_price']);
		if ($data['supplier_id'])
		{
			$data_edit_3 = array();
			foreach ($data['supplier_id'] as $k => $v)
			{
				$user_id = $v;
				$data_edit_2 = array(
					'product_id' => $data['product_id'],
					'user_id' => $user_id,
					'buy_price' => $data['buy_price'][$k]
				);
				$this->product_users_model->edit($data_edit_2);
				array_push($data_edit_3, $user_id);
			}
			$this->product_users_model->remove_by_user_id_usertype($data_edit_3, 'supplier');
		}
		if ($data['marketplace_id'])
		{
			$data_edit_4 = array();
			foreach ($data['marketplace_id'] as $k => $v)
			{
				$user_id = $v;
				$data_edit_2 = array(
					'product_id' => $data['product_id'],
					'user_id' => $user_id,
					'sell_price' => $data['sell_price'][$k]
				);
				$this->product_users_model->edit($data_edit_2);
				array_push($data_edit_4, $user_id);
			}
			$this->product_users_model->remove_by_user_id_usertype($data_edit_4, 'marketplace');
		}
    }
	
	public function list_all($param)
    {
        $data['total'] = $this->db->count_all($this->table_name);
		$param['offset'] = ( ($param['offset'] == $data['total'] && $data['total'] > 0) ? ($param['offset'] - $param['limit']) : $param['offset']);
		
		$marketplace = $this->marketplace_model->list_all_for_product();
		$suppliers = $this->suppliers_model->list_all_for_product();
		
		// $this->db->select('p.*, pc.product_category_name');
        $this->db->select('p.*, GROUP_CONCAT(pc.product_category_name) as product_category_name');
		if ($marketplace)
		{
			foreach ($marketplace as $k => $v)
			{
				$this->db->select('(select sell_price from product_users where product_id = p.product_id and user_id = '.$v->user_id.') as sell_price_'.$v->user_id);
			}
		}
		if ($suppliers)
		{
			foreach ($suppliers as $k => $v)
			{
				$this->db->select('(select buy_price from product_users where product_id = p.product_id and user_id = '.$v->user_id.') as buy_price_'.$v->user_id);
			}
		}
		
		$this->db->from($this->table_name.' as p');
		$this->db->join($this->product_categories_model->table_name.' as pc', 'FIND_IN_SET(pc.product_category_id, p.product_category) > 0', 'left');
		$filter = json_decode($param['filter']);
		if ($filter)
		{
			foreach ($filter as $k => $v)
			{
				$this->db->like('p.'.$k, $v);
			}
		}
		$this->input->get('buy_product') ? $this->db->where('buy_product', $this->input->get('buy_product')) : '';
		$this->input->get('produce_product') ? $this->db->where('produce_product', $this->input->get('produce_product')) : '';
		$this->input->get('sell_product') ? $this->db->where('sell_product', $this->input->get('sell_product')) : '';
		$this->input->get('stock_product') ? $this->db->where('stock_product', $this->input->get('stock_product')) : '';
		$product_category = $this->input->get('product_category');
		$product_category ? $this->db->where('FIND_IN_SET('.$product_category.', product_category)') : '';
		$this->db->group_by($this->primary_key);
		$this->db->order_by($param['sort'], $param['order']);
        $this->db->limit($param['limit'], $param['offset']);
        
        $data['rows'] = $this->db->get()->result();
		// echo $this->db->last_query();
		return $data;
    }
	
	public function list_all_by_user_id($param)
    {
        $this->db->where('user_id', $param['user_id']);
		$this->db->from($this->product_users_model->table_name);
		$data['total'] = $this->db->count_all_results();
		$param['offset'] = ( ($param['offset'] == $data['total'] && $data['total'] > 0) ? ($param['offset'] - $param['limit']) : $param['offset']);
		
		
		$this->db->select('p.product_id, p.product_code, p.product_name, p.product_description, p.weight');
		$this->db->select('GROUP_CONCAT(pc.product_category_name) as product_category_name, pu.*');
		$this->db->from($this->product_users_model->table_name.' as pu');
		$this->db->join($this->table_name.' as p', 'p.'.$this->primary_key.' = pu.'.$this->product_users_model->primary_key_1, 'left');
		$this->db->join($this->product_categories_model->table_name.' as pc', 'FIND_IN_SET(pc.product_category_id, p.product_category) > 0', 'left');
		$this->db->where('pu.user_id', $param['user_id']);
		$filter = json_decode($param['filter']);
		if ($filter)
		{
			foreach ($filter as $k => $v)
			{
				if ($k == 'buy_price')
				{
					$this->db->like('pu.'.$k, $v);
				}
				else
				{
					$this->db->like($k, $v);
				}
			}
		}
		// $product_category = $this->input->get('product_category');
		// $product_category ? $this->db->where('FIND_IN_SET('.$product_category.', product_category)') : '';
		$this->db->group_by('pu.'.$this->primary_key);
		$this->db->order_by($param['sort'], $param['order']);
        $this->db->limit($param['limit'], $param['offset']);
        
        $data['rows'] = $this->db->get()->result();
		// echo $this->db->last_query();
		return $data;
    }
	
	public function row($id)
	{
		$this->db->select('*');
        $this->db->from($this->table_name);
		$this->db->where($this->primary_key, $id);
		
		return $this->db->get()->row();
	}
	
	public function remove($id)
	{
		$this->product_users_model->remove($id);
		
		$this->db->where($this->primary_key, $id);
		$this->db->delete($this->table_name);
	}
}