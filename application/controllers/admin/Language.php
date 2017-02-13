<?php

class Language extends MY_Controller {
	
    public function __construct()
	{
        parent::__construct();
        $this->load->helper('url');
    }

    function switch_language($language)
	{
		$language = ($language) ? $language : $this->config->item('language');
		$this->session->set_userdata('site_language', $language);
        redirect('admin/home');
    }
	
}