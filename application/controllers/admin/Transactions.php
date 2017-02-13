<?php

class Transactions extends MY_Controller {
    
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
        redirect('admin/transactions/list_all');
    }
    
    public function add()
    {
        $meta = array('page_title' => lang('menu_nav_transactions_add') );
        $page = $data['page'] = 'transactions/add';
        
        $this->form_validation->set_rules('transactions_add_transaction_date', lang('transactions_label_transaction_date'), 'required');
		$this->form_validation->set_rules('transactions_add_phone_number', lang('transactions_label_phone_number'), 'required');
		$this->form_validation->set_rules('transactions_add_operator_id', lang('transactions_operator'), 'required');
		$this->form_validation->set_rules('transactions_add_price_id', lang('transactions_label_price'), 'required|numeric');
		$this->form_validation->set_rules('transactions_add_sell_price', lang('transactions_label_sell_price'), 'required|numeric');
        if ($this->form_validation->run() == false)
        {
            $data['format_datetime_js'] = $this->Settings_model->setting_value_by_code('format_datetime_js')->setting_value;
            $data['operators'] = $this->Operators_model->operators_for_prices( $this->session->userdata('auth_id') );
			$data['transaction_status'] = $this->Settings_model->settings_by_group('transaction_status');
			$this->admin_page($page, $meta, $data);
        }
        else
        {
            $data = array(
                'transaction_date' => $this->input->post('transactions_add_transaction_date'),
				'admin_id' => $this->session->userdata('auth_id'),
				'name' => $this->input->post('transactions_add_name'),
				'phone_number' => $this->input->post('transactions_add_phone_number'),
				'operator_id' => $this->input->post('transactions_add_operator_id'),
				'price_id' => (int)$this->input->post('transactions_add_price_id'),
				'sell_price' => (int)$this->input->post('transactions_add_sell_price'),
				'status' => (int)$this->input->post('transactions_add_status')
            );
			$this->Transactions_model->add($data);
            
            $alert_message = lang('transactions_label_add_success');
            $this->session->set_flashdata('transactions_label_add_success', $alert_message);
            redirect('admin/transactions/list_all');
        }        
    }
    
    public function edit($id)
    {
        $meta = array('page_title' => lang('menu_nav_transactions_edit') );
        $page = $data['page'] = 'transactions/edit';
        
        $this->form_validation->set_rules('transactions_edit_transaction_date', lang('transactions_label_transaction_date'), 'required');
		$this->form_validation->set_rules('transactions_edit_phone_number', lang('transactions_label_phone_number'), 'required');
		$this->form_validation->set_rules('transactions_edit_operator_id', lang('transactions_operator'), 'required');
		$this->form_validation->set_rules('transactions_edit_price_id', lang('transactions_label_price'), 'required|numeric');
		$this->form_validation->set_rules('transactions_edit_sell_price', lang('transactions_label_sell_price'), 'required|numeric');
        if ($this->form_validation->run() == false)
        {
            $data['format_datetime_js'] = $this->Settings_model->setting_value_by_code('format_datetime_js')->setting_value;
            $data['operators'] = $this->Operators_model->operators_for_prices( $this->session->userdata('auth_id') );
			$data['transaction_status'] = $this->Settings_model->settings_by_group('transaction_status');
			$data['edit'] = $this->Transactions_model->edit_by_param(array(
				'transaction_id' => $id,
				'admin_id' => $this->session->userdata('auth_id')
			));
			$this->admin_page($page, $meta, $data);
        }
        else
        {
            $data = array(
				'transaction_id' => $id,
                'transaction_date' => $this->input->post('transactions_edit_transaction_date'),
				'admin_id' => $this->session->userdata('auth_id'),
				'name' => $this->input->post('transactions_edit_name'),
				'phone_number' => $this->input->post('transactions_edit_phone_number'),
				'operator_id' => $this->input->post('transactions_edit_operator_id'),
				'price_id' => (int)$this->input->post('transactions_edit_price_id'),
				'sell_price' => (int)$this->input->post('transactions_edit_sell_price'),
				'status' => (int)$this->input->post('transactions_edit_status')
            );
            $this->Transactions_model->edit($data);
            
            $alert_message = lang('transactions_label_edit_success');
            $this->session->set_flashdata('transactions_label_edit_success', $alert_message);
            redirect('admin/transactions/list_all');
        }
    }
    
    public function list_all()
    {
        $meta = array('page_title' => lang('menu_nav_transactions_list_all'));
        $page = $data['page'] = 'transactions/list_all';
		
		$data['format_datetime_js'] = $this->Settings_model->setting_value_by_code('format_datetime_js')->setting_value;
        $data['my_table_options'] = $this->my_table_options();
		$data['transaction_status'] = $this->Settings_model->settings_by_group('transaction_status');
        
        $this->admin_page($page, $meta, $data);
    }
    
    public function list_all_ajax()
    {
        $data = $this->my_table_params();
		$data['admin_id'] = $this->session->userdata('auth_id');
		
		$settings_list_all = $this->Transactions_model->list_all($data);
        if ($settings_list_all['rows'])
        {
            $format_datetime_php = $this->Settings_model->setting_value_by_code('format_datetime_php')->setting_value;
            $status_paid = $this->Settings_model->setting_value_by_code('transactions_label_status_paid')->setting_value;
			$status_unpaid = $this->Settings_model->setting_value_by_code('transactions_label_status_unpaid')->setting_value;
			
			foreach ($settings_list_all['rows'] as $k => $v)
            {
                $settings_list_all['rows'][$k]->transaction_date = date($format_datetime_php, strtotime($v->transaction_date));
				$settings_list_all['rows'][$k]->price = number_format($v->price);
				$settings_list_all['rows'][$k]->buy_price = number_format($v->buy_price);
				$settings_list_all['rows'][$k]->sell_price = number_format($v->sell_price);
				
				if ($v->status == $status_paid)
				{
					$v->status = '<a class="btn btn-success btn-xs">'.lang('transactions_label_status_paid').'</a>';
				}
				else if ($v->status == $status_unpaid)
				{
					$v->status = '<a class="btn btn-danger btn-xs">'.lang('transactions_label_status_unpaid').'</a>';
				}
                
                $action = 
                    '<a class="btn btn-primary btn-xs" href="'.site_url('admin/transactions/edit/'.$v->transaction_id).'" role="button">'.
						'<i class="fa fa-pencil-square-o"> </i>'.
						lang('label_button_edit').'</a>&nbsp;'.
                    '<a class="btn btn-danger btn-xs" href="'.site_url('admin/transactions/remove/'.$v->transaction_id).'" onclick="return confirm(\''.lang('message_delete_confirm').'\')" role="button">'.
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
				$this->Transactions_model->remove($data);
			}
		}
	}
	
	public function remove($id = '')
	{
		$data = array(
			'id' => $id,
			'admin_id' => $this->session->userdata('auth_id')
		);
		$this->Transactions_model->remove($data);
		
		$alert_message = lang('transactions_label_remove_success');
        $this->session->set_flashdata('transactions_label_remove_success', $alert_message);
		redirect('admin/transactions/list_all');
	}
	
}

?>