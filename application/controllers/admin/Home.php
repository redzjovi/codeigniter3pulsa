<?php

class Home extends MY_Controller {

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
        $meta = array('page_title' => lang('menu_nav_dashboard'));

		$data['stats'] = $this->Home_model->get_stats($this->session->userdata('auth_id'));
		$data['transaction_history_chart'] = $this->Home_model->get_transaction_history_chart($this->session->userdata('auth_id'));

        $this->admin_page('home', $meta, $data);
    }

}