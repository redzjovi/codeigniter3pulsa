<?php

class purchases_model extends CI_Model {
    var $primary_key = 'purchase_id';
	var $table_name = 'purchase_order';
	
	public function add($data)
    {
        $date = DateTime::createFromFormat('d/m/Y H:i:s', $data['purchase_date']);
		var_dump($date);
		$purchase_date = $date->date;
		
		$array_insert = array(
			'purchase_number' => $data['purchase_number'],
			'purchase_date' => $purchase_date,
			'purchase_status' => $data['purchase_status'],
			'supplier_id' => $data['supplier_id'],
			'reference_number' => $data['reference_number'],
			'note' => $data['note']
		);
		$this->db->insert($this->table_name, $array_insert); // insert
		$purchase_id = $this->db->insert_id();
		
		$array_document = array();
		$document = $data['document'];
		if ($document) // upload file
		{
			$config['allowed_types'] = '*';
			$config['upload_path'] = 'uploads/purchases/'.$purchase_id.'/';
			$this->upload->initialize($config);
			
			if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);
			
			foreach ($document['name'] as $k => $v)
			{
				$_FILES['upload']['name'] = $document['name'][$k];
				$_FILES['upload']['type'] = $document['type'][$k];
				$_FILES['upload']['tmp_name'] = $document['tmp_name'][$k];
				$_FILES['upload']['error'] = $document['error'][$k];
				$_FILES['upload']['size'] = $document['size'][$k];			 
				
				if ($this->upload->do_upload('upload'))
				{
					$data['uploads'][$k] = $this->upload->data();
					array_push($array_document, $_FILES['upload']['name']);
				}
				else
				{
					$data['upload_errors'][$k] = $this->upload->display_errors();
				}
			}
		}
		
		if ($array_document) // update document
		{
			$document = implode('|', $array_document);
			$array_update = array('document' => $document);
			$this->db->set($array_update);
			$this->db->where($this->primary_key, $purchase_id);
			$this->db->update($this->table_name);
		}
	}
	
	public function last_purchase_id()
	{
		$this->db->select_max($this->primary_key);
		$data = $this->db->get($this->table_name)->row();
		return $data->purchase_id + 1;
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