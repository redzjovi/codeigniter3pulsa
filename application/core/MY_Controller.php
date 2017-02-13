<?php

class MY_Controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->library(
            array()
        ); // load library
        
        $this->load->model(
            array(
				'Admins_model', 'Auth_model', 'Home_model', 'Operators_model', 'Prices_model',
				'Settings_model', 'Transactions_model'
				
				// 'auth_model', 'customers_model', 'marketplace_model', 'media_model', 'product_categories_model',
				// 'product_users_model', 'products_model', 'purchases_model', 'suppliers_model',
				// 'users_model', 'usertype_model'
			)
        ); // load model
    }
    
    function admin_auth($page, $meta = array(), $data = array()) {
        /* $meta['message'] = isset($data['message']) ? $data['message'] : $this->session->flashdata('message');
        $meta['error'] = isset($data['error']) ? $data['error'] : $this->session->flashdata('error');
        $meta['warning'] = isset($data['warning']) ? $data['warning'] : $this->session->flashdata('warning');
        $meta['info'] = $this->site->getNotifications();
        $meta['events'] = $this->site->getUpcomingEvents();
        $meta['ip_address'] = $this->input->ip_address();
        $meta['Owner'] = $data['Owner'];
        $meta['Admin'] = $data['Admin'];
        $meta['Supplier'] = $data['Supplier'];
        $meta['Customer'] = $data['Customer'];
        $meta['Settings'] = $data['Settings'];
        $meta['dateFormats'] = $data['dateFormats'];
        $meta['assets'] = $data['assets'];
        $meta['GP'] = $data['GP'];
        $meta['qty_alert_num'] = $this->site->get_total_qty_alerts();
        $meta['exp_alert_num'] = $this->site->get_expiring_qty_alerts(); */
        // $meta['language'] = $data['language'] = 'en';
		$this->load->view('admin/header', $meta);
        
        $data_body['page'] = $this->load->view('admin/'.$page, $data, true);        
        $this->load->view('admin/body_auth', $data_body);
        
        $this->load->view('admin/footer');
    }
    
    function admin_page($page, $meta = array(), $data = array()) {
        /* $meta['message'] = isset($data['message']) ? $data['message'] : $this->session->flashdata('message');
        $meta['error'] = isset($data['error']) ? $data['error'] : $this->session->flashdata('error');
        $meta['warning'] = isset($data['warning']) ? $data['warning'] : $this->session->flashdata('warning');
        $meta['info'] = $this->site->getNotifications();
        $meta['events'] = $this->site->getUpcomingEvents();
        $meta['ip_address'] = $this->input->ip_address();
        $meta['Owner'] = $data['Owner'];
        $meta['Admin'] = $data['Admin'];
        $meta['Supplier'] = $data['Supplier'];
        $meta['Customer'] = $data['Customer'];
        $meta['Settings'] = $data['Settings'];
        $meta['dateFormats'] = $data['dateFormats'];
        $meta['assets'] = $data['assets'];
        $meta['GP'] = $data['GP'];
        $meta['qty_alert_num'] = $this->site->get_total_qty_alerts();
        $meta['exp_alert_num'] = $this->site->get_expiring_qty_alerts(); */
        // $meta['language'] = $data['language'] = 'uk';
        $this->load->view('admin/header', $meta);
        
        // $data_menu_nav['settings'] = $this->Settings_model->setting_all();
        $data_body['menu_nav'] = $this->load->view('admin/menu_nav', null, true);
        $data_body['page'] = $this->load->view('admin/'.$page, $data, true);        
        $this->load->view('admin/body', $data_body);
        
        $this->load->view('admin/footer');
    }
    
    function my_table_info($data)
    {
        $start = $data['offset'] + 1;
        $end = $data['offset'] + $data['result_count'];
        $total_rows = $data['total_rows'];
        
        return $table_info = 'Showing '.$start.' to '.$end.' of '.$total_rows. ' entries';
    }
    
    function my_table_length_changing($data)
    {
        $length = array('5', '10', '30');
        //$link['link'] = replace_parse_url($data['base_url'], 'limit', $value);
        //$html .= '<div class="col-md-2">';
        $html = '';
        
        $html .= '<select class="form-control" onChange="window.location.href=\''.$data['base_url'].'\'">';
        
        foreach($length as $value)
        {
            $selected = ($value == $data['limit']) ? 'selected' : ''; 
            $html .=    '<option '.$selected.'>'.$value.'</option>';
        }
        $html .= '</select>';
        //$html .= '</div">';
        
        return $html;
    }
    
    function my_table_pagination($data)
    {
        // 1. configuration
        $config['base_url'] = $data['base_url'];
        
        $config['num_links'] = 4;
        $config['total_rows'] = $data['total_rows'];
        $config['page_query_string'] = true;
        $config['per_page'] = $data['limit'];
        $config['use_page_numbers'] = true;
        
        $config['full_tag_open'] = '<ul class="pagination";">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';        

        // 2. initialize
        $this->pagination->initialize($config);
        
        // 3. create_links
        return $this->pagination->create_links();
    }
    
    function my_table_options()
    {
        $data = array(
            'data-card-view' => 'false',
			'data-key-events' => 'true',
			// 'data-mobile-responsive' => 'true',
            'data-page-list' => '[10, 30, 50, All]',
			// 'data-page-list' => '[2, 4, All]',
			'data-page-size' => '10',
			// 'data-page-size' => '2',
            'data-pagination' => 'true',
            'data-pagination-v-align' => 'both',
            'data-search' => 'true',
			'data-search-time-out' => '1000',
            'data-show-columns' => 'true',
            'data-show-refresh' => 'true',
            'data-show-toggle' => 'true',
            'data-side-pagination' => 'server',
            'data-silent-sort' => 'false',
            'data-show-pagination-switch' => 'true',
            // 'data-strict-search' => 'true',
            'data-toggle' => 'table',
			'showRefresh' => 'true',
			'smartDisplay' => 'true'
        );
        
        $options = ''; foreach ($data as $k => $v)
        {
            $options .= $k.'="'.$v.'" ';
        }
        return $options;
    }
    
    function my_table_params()
    {
        $data = array();
        // $data['filter'] = $this->input->get('filter');
		// $data['limit'] = $this->input->get('limit');
        // $data['offset'] = $this->input->get('offset');
        // $data['order'] = $this->input->get('order');
        // $data['search'] = $this->input->get('search');
        // $data['sort'] = $this->input->get('sort');
        $data = $this->input->get();
        return $data;
    }
    
    function my_table_sorting($fields, $data)
    {
        foreach($fields as $value)
        {
            if ($value == $data['order_by'])
            {
                $data['order_by_type'] = ($data['order_by_type'] == 'asc') ? 'desc' : 'asc'; 
            }
            else
            {
                $data['order_by_type'] = 'asc';
            }
            $data['fields'][$value]['order_by_type'] = $data['order_by_type'];
            $data['fields'][$value]['link'] = replace_parse_url($data['base_url'], 'order_by', $value);
            $data['fields'][$value]['link'] = replace_parse_url($data['fields'][$value]['link'], 'order_by_type', $data['order_by_type']);
        }
        
        return $data;
    }

	public function my_number_format($number)
	{
		return number_format($number);
	}
}

?>