<?php

class Profile extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('is_login')) // if is not not login
        {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            redirect('admin/auth');
        }
    }
    
    public function edit($id)
    {
        $meta = array('page_title' => lang('menu_nav_profile_edit') );
        $page = $data['page'] = 'profile/edit';
        
        $this->form_validation->set_rules('profile_edit_old_password', lang('profile_label_old_password'), 'required|callback_old_password_check');
		$this->form_validation->set_rules('profile_edit_new_password', lang('profile_label_new_password'), 'required');
		$this->form_validation->set_rules('profile_edit_retype_new_password', lang('profile_label_retype_new_password'), 'required|matches[profile_edit_new_password]');
		if ($this->form_validation->run() == false)
        {
            $data['edit'] = $this->Admins_model->edit_by_param( $this->session->userdata('auth_id') );
			$this->admin_page($page, $meta, $data);
        }
        else
        {
            $data = array(
				'admin_id' => $this->session->userdata('auth_id'),
				'old_password' => $this->input->post('profile_edit_old_password'),
				'new_password' => $this->input->post('profile_edit_new_password')
            );
            $this->Admins_model->edit($data);
            
            $alert_message = lang('profile_label_edit_success');
            $this->session->set_flashdata('profile_label_edit_success', $alert_message);
            redirect('admin/home');
        }
    }
	
	public function old_password_check($old_password)
	{
		$admin_id = $this->session->userdata('auth_id');
		
		$data = $this->Admins_model->old_password_check($admin_id, $old_password);
		if ($data)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('old_password_check', lang('profile_label_wrong_old_password') );
			return false;
		}
	}
	
}

?>