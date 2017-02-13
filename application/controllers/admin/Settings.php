<?php

class Settings extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('is_login')) // if is not not login
        {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            redirect('admin/auth');
        }
    }
    
    public function index()
    {
        redirect('admin/settings/list_all');
    }
    
    public function add() 
    {
        $meta = array('page_title' => lang('menu_nav_settings_add') );
        $page = $data['page'] = 'settings/add';
        
        $this->form_validation->set_rules('settings_add_setting_code', lang('settings_label_setting_code'), 'required|is_unique[settings.setting_code]');
        if ($this->form_validation->run() == false)
        {
            $this->admin_page($page, $meta, $data);
        }
        else
        {
            $data = array(
                'setting_code' => $this->input->post('settings_add_setting_code'),
                'setting_value' => $this->input->post('settings_add_setting_value'),
                'setting_description' => $this->input->post('settings_add_setting_description'),
                'active' => (int)$this->input->post('settings_add_active'),
            );
            $this->Settings_model->settings_add($data);
            
            $alert_message = lang('settings_label_add_success');
            $this->session->set_flashdata('settings_label_add_success', $alert_message);
            redirect('admin/settings/list_all');
        }        
    }
    
    public function edit($setting_id)
    {
        $meta = array('page_title' => lang('menu_nav_settings_edit') );
        $page = $data['page'] = 'settings/edit';
        
        $this->form_validation->set_rules('settings_edit_setting_code', lang('settings_label_setting_code'), 'required');
        if ($this->form_validation->run() == false)
        {
            $data['settings_edit'] = $this->db->get_where('settings', array('setting_id' => $setting_id) )->row();
            $this->admin_page($page, $meta, $data);
        }
        else
        {
            $data = array(
                'setting_id' => $setting_id,
                'setting_value' => $this->input->post('settings_edit_setting_value'),
                'setting_description' => $this->input->post('settings_edit_setting_description'),
                'active' => (int)$this->input->post('settings_edit_active'),
            );
            $this->Settings_model->settings_edit($data);
            
            $alert_message = lang('settings_label_edit_success');
            $this->session->set_flashdata('settings_label_edit_success', $alert_message);
            redirect('admin/settings/list_all');
        }
    }
    
    public function edit_unique_setting_code($value, $params)
    {
        $this->form_validation->set_message('setting_code',
            'The %s is already being used by setting code.');
    
        list($table, $field, $id) = explode(".", $params, 3);
    
        $query = $this->db->select($field)->from($table)
            ->where($field, $value)->where('setting_id !=', $id)->limit(1)->get();
    
        if ($query->row()) {
            return false;
        } else {
            return true;
        }
    }
    
    public function list_all()
    {
        $meta = array('page_title' => lang('menu_nav_settings_list_all'));
        $page = $data['page'] = 'settings/list_all';
        
        $data['my_table_options'] = $this->my_table_options();
		$data['status_active'] = $this->Settings_model->settings_by_group('status_active');
        
        $this->admin_page($page, $meta, $data);
    }
    
    public function list_all_ajax()
    {
        $settings_list_all = $this->Settings_model->settings_list_all( $this->my_table_params() );
        if ($settings_list_all['rows'])
        {
            $status_active = $this->Settings_model->setting_value_by_code('label_active')->setting_value;
			$status_inactive = $this->Settings_model->setting_value_by_code('label_inactive')->setting_value;
			
			foreach ($settings_list_all['rows'] as $k => $v)
            {
                if ($v->active == $status_active)
				{
					$v->active = '<a class="btn btn-success btn-xs">'.lang('label_active').'</a>';
				}
				else if ($v->active == $status_inactive)
				{
					$v->active = '<a class="btn btn-danger btn-xs">'.lang('label_inactive').'</a>';
				}
				
				$action = 
                    '<a class="btn btn-primary btn-xs" href="'.site_url('admin/settings/edit/'.$v->setting_id).'" role="button">'.lang('label_button_edit').'</a>&nbsp;'.
                    '<a class="btn btn-danger btn-xs" href="'.site_url('admin/settings/remove/'.$v->setting_id).'" onclick="return confirm(\''.lang('message_delete_confirm').'\')" role="button">'.lang('label_button_remove').'</a>';                    
                $settings_list_all['rows'][$k]->action = $action;
            }
        }
        
        echo json_encode($settings_list_all);
    }
	
	public function remove_ajax()
	{
		$id = $this->input->post('primary_key');
		
		if ($id)
		{
			foreach ($id as $k => $v)
			{
				$this->Settings_model->settings_remove($v);
			}
		}
	}
	
	public function remove($setting_id = '')
	{
		$this->Settings_model->settings_remove($setting_id);
		
		$alert_message = lang('settings_label_remove_success');
        $this->session->set_flashdata('settings_label_remove_success', $alert_message);
		redirect('admin/settings/list_all');
	}
}