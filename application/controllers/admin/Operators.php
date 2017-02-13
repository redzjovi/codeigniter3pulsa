<?php

class Operators extends MY_Controller {
    
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
        redirect('admin/operators/list_all');
    }
    
    public function add()
    {
        $meta = array('page_title' => lang('menu_nav_operators_add') );
        $page = $data['page'] = 'operators/add';
        
        $this->form_validation->set_rules('operators_add_operator_name', lang('operators_label_operator_name'), 'required');
        if ($this->form_validation->run() == false)
        {
            $this->admin_page($page, $meta, $data);
        }
        else
        {
            $data = array(
                'admin_id' => $this->session->userdata('auth_id'),
				'operator_name' => $this->input->post('operators_add_operator_name'),
                'active' => (int)$this->input->post('operators_add_active')
            );
			$this->Operators_model->add($data);
            
            $alert_message = lang('operators_label_add_success');
            $this->session->set_flashdata('operators_label_add_success', $alert_message);
            redirect('admin/operators/list_all');
        }        
    }
    
    public function edit($id)
    {
        $meta = array('page_title' => lang('menu_nav_operators_edit') );
        $page = $data['page'] = 'operators/edit';
        
        $this->form_validation->set_rules('operators_edit_operator_name', lang('operators_label_operator_name'), 'required');
        if ($this->form_validation->run() == false)
        {
            $data['edit'] = $this->Operators_model->edit_by_param(array(
				'id' => $id,
				'auth_id' => $this->session->userdata('auth_id')
			));
            $this->admin_page($page, $meta, $data);
        }
        else
        {
            $data = array(
                'id' => $id,
				'auth_id' => $this->session->userdata('auth_id'),
                'operator_name' => $this->input->post('operators_edit_operator_name'),
                'active' => (int)$this->input->post('operators_edit_active'),
            );
            $this->Operators_model->edit($data);
            
            $alert_message = lang('operators_label_edit_success');
            $this->session->set_flashdata('operators_label_edit_success', $alert_message);
            redirect('admin/operators/list_all');
        }
    }
    
    public function list_all()
    {
        $meta = array('page_title' => lang('menu_nav_operators_list_all'));
        $page = $data['page'] = 'operators/list_all';
		
		$data['status_active'] = $this->Settings_model->settings_by_group('status_active');
        $data['my_table_options'] = $this->my_table_options();
        
        $this->admin_page($page, $meta, $data);
    }
    
    public function list_all_ajax()
    {
        $data = $this->my_table_params();
		$data['admin_id'] = $this->session->userdata('auth_id');
		
		$settings_list_all = $this->Operators_model->list_all($data);
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
                    '<a class="btn btn-primary btn-xs" href="'.site_url('admin/operators/edit/'.$v->operator_id).'" role="button">'.
						'<i class="fa fa-pencil-square-o"> </i>'.
						lang('label_button_edit').'</a>&nbsp;'.
                    '<a class="btn btn-danger btn-xs" href="'.site_url('admin/operators/remove/'.$v->operator_id).'" onclick="return confirm(\''.lang('message_delete_confirm').'\')" role="button">'.
						'<i class="glyphicon glyphicon-trash"> </i>'.
						lang('label_button_remove').'</a>';
                $settings_list_all['rows'][$k]->action = $action;
            }
        }
        
        echo json_encode($settings_list_all);
    }
	
	public function list_all_ajax_remove()
	{
		$id = $this->input->post('id');
		
		if ($id)
		{
			foreach ($id as $k => $v)
			{
				$data = array(
					'id' => $v,
					'auth_id' => $this->session->userdata('auth_id')
				);
				$this->Operators_model->remove($data);
			}
		}
	}
	
	public function remove($id = '')
	{
		$data = array(
			'id' => $id,
			'auth_id' => $this->session->userdata('auth_id')
		);
		$this->Operators_model->remove($data);
		
		$alert_message = lang('operators_label_remove_success');
        $this->session->set_flashdata('operators_label_remove_success', $alert_message);
		redirect('admin/operators/list_all');
	}
	
}

?>