<?php

class Auth extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function forget_password()
	{
        $meta = array('page_title' => lang('auth_label'));

        $this->form_validation->set_rules('auth_email', 'Email', 'required|valid_email');

        if (!$this->session->userdata('is_login')) // if is not login
        {
            if ($this->form_validation->run() == false) // if validation == false
            {
                $this->admin_auth('auth/forget_password', $meta);
            }
            else // if validation == true
            {
                $auth_email = $this->input->post('auth_email');

                $auth = $this->Auth_model->auth_check_without_password($auth_email);
                if (!isset($auth)) // if auth failed
                {
                    $this->session->set_flashdata('auth_failed', lang('auth_failed_message'));
					redirect('admin/auth/forget_password');
                }
				else if ($auth->active == 0)
				{
					$this->session->set_flashdata('auth_failed', lang('auth_account_is_inactive'));
					redirect('admin/auth/forget_password');
				}
                else // if auth success
                {
                    // $config = Array(
						// 'protocol' => 'smtp',
						// 'smtp_host' => 'srv15.niagahoster.com',
						// 'smtp_port' => 465,
						// 'smtp_user' => 'mailer@pulsa.bignesia.com', // change it to yours
						// 'smtp_pass' => 'mailer123', // change it to yours
						// 'mailtype' => 'html',
						// 'charset' => 'iso-8859-1',
						// 'wordwrap' => TRUE
					// );

					$message = '<a href="'.site_url('admin/auth/reset_password/?email='.$auth->email.'&password='.$auth->password).'">'.lang('auth_reset_password').'</a>';
					// echo $message;

					$config = Array(
						'protocol' => 'smtp',
						'smtp_host' => 'ssl://smtp.googlemail.com',
						'smtp_port' => 465,
						'smtp_user' => 'bignesia@gmail.com', // change it to yours
						'smtp_pass' => 'bignesia123', // change it to yours
						'mailtype' => 'html',
						'charset' => 'iso-8859-1',
						'newline'   => "\r\n",
						'starttls'  => true,
						'wordwrap' => TRUE
					);

					$this->load->library('email', $config);
					$this->email->set_newline("\r\n");
					$this->email->from('bignesia@gmail.com'); // change it to yours
					$this->email->to($auth_email);// change it to yours
					$this->email->subject(lang('auth_forgot_password'));
					$this->email->message($message);
					if ($this->email->send())
					{
						echo 'Email sent.';
					}
					else
					{
						show_error($this->email->print_debugger());
					}
					$this->session->set_flashdata('auth_register_label_success', lang('auth_forgot_password_message_sent'));
					redirect('admin/auth/');
                }
            }
        }
        else // if is login
        {
            if (!$this->session->userdata('requested_page')) // if request page is not set
            {
                redirect('admin/home');
            }
            else // if request page is set
            {
                redirect($this->session->userdata('requested_page'));
            }
        }
    }

	public function index()
    {
        $meta = array('page_title' => lang('auth_label'));

        $this->form_validation->set_rules('auth_email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('auth_password', 'Password', 'required');

        if (!$this->session->userdata('is_login')) // if is not login
        {
            if ($this->form_validation->run() == false) // if validation == false
            {
                $this->admin_auth('auth/auth', $meta);
            }
            else // if validation == true
            {
                $auth_email = $this->input->post('auth_email');
                $auth_password = $this->input->post('auth_password');

                $auth = $this->Auth_model->auth_check($auth_email, $auth_password);
                if (!isset($auth)) // if auth failed
                {
                    $this->session->set_flashdata('auth_failed', lang('auth_failed_message'));
					$this->admin_auth('auth/auth', $meta);
                }
				else if ($auth->active == 0)
				{
					$this->session->set_flashdata('auth_failed', lang('auth_account_is_inactive'));
					$this->admin_auth('auth/auth', $meta);
				}
                else // if auth success
                {
                    $data_session = array(
                        'auth_id' => $auth->admin_id,
                        'email' => $auth->email,
                        'is_login' => true
                    );
                    $this->session->set_userdata($data_session);
                    if (!$this->session->userdata('requested_page')) // if request page is not set
                    {
                        redirect('admin/home');
                    }
                    else // if request page is set
                    {
                        redirect($this->session->userdata('requested_page'));
                    }
                }
            }
        }
        else // if is login
        {
            if (!$this->session->userdata('requested_page')) // if request page is not set
            {
                redirect('admin/home');
            }
            else // if request page is set
            {
                redirect($this->session->userdata('requested_page'));
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata(array('user_id', 'email', 'is_login'));

        redirect(base_url('admin/auth'));
    }

	public function register()
	{
        $meta = array('page_title' => lang('auth_register') );

        $this->form_validation->set_rules('auth_register_email', lang('auth_email'), 'required|valid_email|is_unique['.$this->Admins_model->table_name.'.email]');
		$this->form_validation->set_rules('auth_register_password', lang('auth_password'), 'required');
		$this->form_validation->set_rules('auth_register_agree', lang('auth_register_label_agree').lang('auth_register_label_terms'), 'required');
		if ($this->form_validation->run() == false)
        {
			$this->admin_auth('auth/register', $meta);
        }
        else
        {
            $data = array(
                'email' => $this->input->post('auth_register_email'),
				'password' => $this->input->post('auth_register_password'),
            );
			$this->Admins_model->add($data);

            $alert_message = lang('auth_register_label_success');
            $this->session->set_flashdata('auth_register_label_success', $alert_message);
            redirect('admin/auth');
        }
    }

	public function reset_password()
	{
		$meta = array('page_title' => lang('auth_reset_password'));
		$data['email'] = $email = $this->input->get('email');
		$data['password'] = $password = $this->input->get('password');

		$auth = $this->Auth_model->auth_check_without_hash_password($email, $password);
		if (!isset($auth)) // if auth failed
		{
			$this->session->set_flashdata('auth_failed', lang('auth_failed_message'));
			redirect('admin/auth');
		}
		else if ($auth->active == 0)
		{
			$this->session->set_flashdata('auth_failed', lang('auth_account_is_inactive'));
			redirect('admin/auth');
		}
		else
		{
			$this->form_validation->set_rules('auth_new_password', lang('profile_label_new_password'), 'required');
			$this->form_validation->set_rules('auth_retype_new_password', lang('profile_label_retype_new_password'), 'required|matches[auth_new_password]');

			if ($this->form_validation->run() == false) // if validation == false
            {

				$this->admin_auth('auth/reset_password', $meta, $data);
            }
            else // if validation == true
            {
                $data = array(
					'email' => $this->input->post('auth_email'),
					'old_password' => $this->input->post('auth_password'),
					'new_password' => $this->input->post('auth_new_password')
				);
				$this->Auth_model->edit_password($data);

				$alert_message = lang('auth_reset_password_label_success');
				$this->session->set_flashdata('auth_register_label_success', $alert_message);
				redirect('admin/auth');
            }
		}
	}
}

?>