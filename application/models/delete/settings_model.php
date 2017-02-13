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
        $data['total'] = $this->db->count_all($this->table_name);
		$param['offset'] = ( ($param['offset'] == $data['total'] && $data['total'] > 0) ? ($param['offset'] - $param['limit']) : $param['offset']);
		
		$this->db->select('*');
        $this->db->from($this->table_name);
        $this->db->like('setting_code', $param['search']);
        $this->db->or_like('setting_value', $param['search']);
        $this->db->or_like('setting_description', $param['search']);
        $this->db->order_by($param['sort'], $param['order']);
        $this->db->limit($param['limit'], $param['offset']);
        
        $data['rows'] = $this->db->get()->result();
        return $data;
    }
    
	public function settings_remove($setting_id)
	{
		$this->db->where($this->primary_key, $setting_id);
		$this->db->delete($this->table_name);
	}
} 