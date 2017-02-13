<?php

class Prices extends MY_Controller {
    
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
        redirect('admin/prices/list_all');
    }
    
    public function add()
    {
        $meta = array('page_title' => lang('menu_nav_prices_add') );
        $page = $data['page'] = 'prices/add';
        
        $this->form_validation->set_rules('prices_add_price', lang('prices_label_price'), 'required|numeric');
		$this->form_validation->set_rules('prices_add_buy_price', lang('prices_label_buy_price'), 'required|numeric');
		$this->form_validation->set_rules('prices_add_sell_price', lang('prices_label_sell_price'), 'required|numeric');
        if ($this->form_validation->run() == false)
        {
            $data['operators'] = $this->Operators_model->operators_for_prices( $this->session->userdata('auth_id') );
			$this->admin_page($page, $meta, $data);
        }
        else
        {
            $data = array(
                'admin_id' => $this->session->userdata('auth_id'),
				'operator_id' => $this->input->post('prices_add_operator_id'),
				'price' => (int)$this->input->post('prices_add_price'),
				'buy_price' => (int)$this->input->post('prices_add_buy_price'),
				'sell_price' => (int)$this->input->post('prices_add_sell_price'),
				'active' => (int)$this->input->post('prices_add_active')
            );
			$this->Prices_model->add($data);
            
            $alert_message = lang('prices_label_add_success');
            $this->session->set_flashdata('prices_label_add_success', $alert_message);
            redirect('admin/prices/list_all');
        }        
    }
    
    public function edit($id)
    {
        $meta = array('page_title' => lang('menu_nav_prices_edit') );
        $page = $data['page'] = 'prices/edit';
        
        $this->form_validation->set_rules('prices_edit_price', lang('prices_label_price'), 'required|numeric');
		$this->form_validation->set_rules('prices_edit_buy_price', lang('prices_label_buy_price'), 'required|numeric');
		$this->form_validation->set_rules('prices_edit_sell_price', lang('prices_label_sell_price'), 'required|numeric');
        if ($this->form_validation->run() == false)
        {
            $data['operators'] = $this->Operators_model->operators_for_prices( $this->session->userdata('auth_id') );
			$data['edit'] = $this->Prices_model->edit_by_param(array(
				'price_id' => $id,
				'admin_id' => $this->session->userdata('auth_id')
			));
            $this->admin_page($page, $meta, $data);
        }
        else
        {
            $data = array(
				'id' => $id,
                'admin_id' => $this->session->userdata('auth_id'),
				'operator_id' => $this->input->post('prices_edit_operator_id'),
				'price' => (int)$this->input->post('prices_edit_price'),
				'buy_price' => (int)$this->input->post('prices_edit_buy_price'),
				'sell_price' => (int)$this->input->post('prices_edit_sell_price'),
				'active' => (int)$this->input->post('prices_edit_active')
            );
            $this->Prices_model->edit($data);
            
            $alert_message = lang('prices_label_edit_success');
            $this->session->set_flashdata('prices_label_edit_success', $alert_message);
            redirect('admin/prices/list_all');
        }
    }
    
    public function list_all()
    {
        $meta = array('page_title' => lang('menu_nav_prices_list_all'));
        $page = $data['page'] = 'prices/list_all';
		
		$data['status_active'] = $this->Settings_model->settings_by_group('status_active');
        $data['my_table_options'] = $this->my_table_options();
        
        $this->admin_page($page, $meta, $data);
    }
    
    public function list_all_ajax()
    {
        $data = $this->my_table_params();
		$data['admin_id'] = $this->session->userdata('auth_id');
		
		$settings_list_all = $this->Prices_model->list_all($data);
        if ($settings_list_all['rows'])
        {
            $status_active = $this->Settings_model->setting_value_by_code('label_active')->setting_value;
			$status_inactive = $this->Settings_model->setting_value_by_code('label_inactive')->setting_value;
            
            foreach ($settings_list_all['rows'] as $k => $v)
            {
                $settings_list_all['rows'][$k]->price = number_format($v->price);
				$settings_list_all['rows'][$k]->buy_price = number_format($v->buy_price);
				$settings_list_all['rows'][$k]->sell_price = number_format($v->sell_price);
				
                if ($v->active == $status_active)
				{
					$v->active = '<a class="btn btn-success btn-xs">'.lang('label_active').'</a>';
				}
				else if ($v->active == $status_inactive)
				{
					$v->active = '<a class="btn btn-danger btn-xs">'.lang('label_inactive').'</a>';
				}
                
                $action = 
                    '<a class="btn btn-primary btn-xs" href="'.site_url('admin/prices/edit/'.$v->price_id).'" role="button">'.
						'<i class="fa fa-pencil-square-o"> </i>'.
						lang('label_button_edit').'</a>&nbsp;'.
                    '<a class="btn btn-danger btn-xs" href="'.site_url('admin/prices/remove/'.$v->price_id).'" onclick="return confirm(\''.lang('message_delete_confirm').'\')" role="button">'.
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
					'admin_id' => $this->session->userdata('auth_id')
				);
				$this->Prices_model->remove($data);
			}
		}
	}
	
	public function prices_by_operator_id()
	{
		$param = array(
			'admin_id' => $this->session->userdata('auth_id'),
			'operator_id' => $this->input->post('id')
		);
		$data['rows'] = $this->Prices_model->prices_by_operator_id($param);
		echo json_encode($data);
	}
	
	public function prices_by_price_id()
	{
		$param = array(
			'admin_id' => $this->session->userdata('auth_id'),
			'price_id' => $this->input->post('id')
		);
		$data['rows'] = $this->Prices_model->prices_by_price_id($param);
		echo json_encode($data);
	}
	
	public function remove($id = '')
	{
		$data = array(
			'id' => $id,
			'admin_id' => $this->session->userdata('auth_id')
		);
		$this->Prices_model->remove($data);
		
		$alert_message = lang('prices_label_remove_success');
        $this->session->set_flashdata('prices_label_remove_success', $alert_message);
		redirect('admin/prices/list_all');
	}
	
}

?>