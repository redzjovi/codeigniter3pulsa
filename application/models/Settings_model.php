<?php

class Settings_model extends CI_Model {
    var $table_name = 'settings';
	var $primary_key = 'setting_id';
    
    public function setting_all()
    {
        $settings = $this->db->get_where($this->table_name, array('active' => 1))->result();
        $new_settings = array(); foreach($settings as $value)
        {
            $new_settings[$value->setting_code] = $value->setting_value;
        }
        return $new_settings;
    }
    
    public function setting_value_by_code($code)
    {
        return $this->db->get_where($this->table_name, array('setting_code' => $code))->row();
    }
    
    public function settings_add($data)
    {
        $this->db->insert($this->table_name, $data);   
    }
    
    public function settings_by_group($group)
	{
		return $this->db->get_where($this->table_name, array('setting_group' => $group))->result();
	}
	
	public function settings_edit($data)
    {
        $array_update = array(
            'setting_value' => $data['setting_value'],
            'setting_description' => $data['setting_description'],
            'active' => $data['active']
        );
        
        $this->db->set($array_update);
        $this->db->where($this->primary_key, $data['setting_id']);
        $this->db->update($this->table_name);   
    }
    
    public function settings_list_all($param)
    {
        $this->db->select('s.*');
        $this->db->from($this->table_name.' as s');
		$this->db->like('s.setting_code', $param['setting_code']);
		$this->db->like('s.setting_value', $param['setting_value']);
		$this->db->like('s.setting_description', $param['setting_description']);
		$this->db->like('s.active', $param['active']);
		$data['total'] = $this->db->count_all_results();
		
		$this->db->select('s.*');
		$this->db->from($this->table_name.' as s');
		$this->db->like('s.setting_code', $param['setting_code']);
		$this->db->like('s.setting_value', $param['setting_value']);
		$this->db->like('s.setting_description', $param['setting_description']);
		$this->db->like('s.active', $param['active']);
		$this->db->order_by($param['sort'], $param['order']);
        if (isset($param['limit']))
		{
			$param['offset'] = ( ($param['offset'] >= $data['total'] && $data['total'] > 0) ? ($param['offset'] - $param['limit']) : $param['offset']);
			$this->db->limit($param['limit'], $param['offset']);
		}
        
        $data['rows'] = $this->db->get()->result();
        return $data;
    }
    
	public function settings_remove($setting_id)
	{
		$this->db->where($this->primary_key, $setting_id);
		$this->db->delete($this->table_name);
	}
} 