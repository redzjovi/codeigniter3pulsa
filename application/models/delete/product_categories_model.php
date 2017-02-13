<?php

class product_categories_model extends CI_Model {
    var $MY_Controller;
    var $table_name = 'product_categories';
	var $primary_key = 'product_category_id';
    
	public function __construct()
    {
        parent::__construct();
        $this->MY_Controller = & get_instance();
    }
    
    public function product_categories_add($data)
    {
        $this->db->insert($this->table_name, $data);   
    }
	
	public function product_categories_edit($data)
    {
        $array_update = array(
            'product_category_name' => $data['product_category_name'],
			'product_category_parent' => $data['product_category_parent'],
            'active' => $data['active']
        );
		
        $this->db->set($array_update);
        $this->db->where($this->primary_key, $data['product_category_id']);
        $this->db->update($this->table_name);   
    }
    
    public function product_categories_for_product()
	{
		return $this->db
			->where(array('active' => 1))
			->order_by('product_category_name asc')
			->get($this->table_name)->result();
	}
	
	public function product_categories_for_product_category_edit($id = '')
	{
		$this->db->where_not_in($this->primary_key, $id);
		$this->db->where('active', 1);
		$this->db->order_by('product_category_name asc');
		return $this->db->get($this->table_name)->result();
	}
	
	public function product_categories_list_all($param)
    {
        $data['total'] = $this->db->count_all($this->table_name);
		$param['offset'] = ( ($param['offset'] == $data['total'] && $data['total'] > 0) ? ($param['offset'] - $param['limit']) : $param['offset']);
		
		$query = 
			'* from (
			select pc.*, pc2.product_category_name as product_category_parent_name
			from '.$this->table_name.' as pc
			left join '.$this->table_name.' as pc2 on pc2.'.$this->primary_key.' = pc.product_category_parent
			) as p';
		$this->db->select($query);
		$filter = json_decode($param['filter']);
		if ($filter)
		{
			foreach ($filter as $k => $v)
			{
				$this->db->like('p.'.$k, $v);
			}
		}
		$this->db->order_by($param['sort'], $param['order']);
        $this->db->limit($param['limit'], $param['offset']);
        
        $data['rows'] = $this->db->get()->result();
		// echo $this->db->last_query();
        return $data;
    }
    
    public function product_categories_list_all22($data)
    {
        // 1. get parameter from get
        $data['limit'] = ($this->input->get('limit', true) == null) ? $data['limit'] : $this->input->get('limit', true);
        $data['offset'] = ($this->input->get('per_page', true) == null) ? 0 : ($this->input->get('per_page', true) - 1) * $data['limit'];
        $data['order_by']= ($this->input->get('order_by', true) == null) ? $data['order_by'] : $this->input->get('order_by', true);
        $data['order_by_type'] = ($this->input->get('order_by_type', true) == null) ? $data['order_by_type'] : $this->input->get('order_by_type', true);
               
        // 2. get all data
        $this->db->select("*");
        $this->db->from("product_categories");
        $this->db->limit($data['limit'], $data['offset']);
        $this->db->order_by($data['order_by'], $data['order_by_type']);
        $data['result'] = $this->db->get()->result();
        $data['result_count'] = count($data['result']);
        
        $this->db->select("*");
        $this->db->from("product_categories");
        $data['total_rows'] = $this->db->count_all_results();        
        
        // 3. url and parameter
        $data['parse_url_query'] =
            '?limit='.$data['limit'].
            '&offset='.$data['offset'].
            '&order_by='.$data['order_by'].
            '&order_by_type='.$data['order_by_type'];
        $data['base_url'] = site_url($data['base_url'].$data['parse_url_query']);
        
        // 4. get all fields to header
        $fields = $this->db->list_fields('product_categories');
        if ($fields)
        {
            $data = $this->MY_Controller->my_table_sorting($fields, $data);
        }
        
        // 5. length changing
        $data['table_length'] = $this->MY_Controller->my_table_length_changing($data);
        
        // 6. pagination
        $data['table_pagination'] = $this->MY_Controller->my_table_pagination($data);
        
        // 7. table info
        $data['table_info'] = $this->MY_Controller->my_table_info($data);        
        
        debugvar($data);
        return $data;   
    }
    
	public function product_categories_remove($product_category_id)
	{
		$this->db->where($this->primary_key, $product_category_id);
		$this->db->delete($this->table_name);
	}
} 