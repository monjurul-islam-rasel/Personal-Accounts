<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Auth Authentication Controller
 * Creator: SB TechValley ( https://www.sbtechvalley.com )
 * Date: 7/23/2018
 * Time: 11:45 AM
 */
 
class Auth extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array(
			'form',
			'url'
		));
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->model('m_config');
	}

	function index()
	{
		if ($message = $this->session->flashdata('message'))
		{
			$this->load->view('auth/general_message', array(
				'message' => $message
			));
		}
		else
		{
			redirect('/auth/login/');
		}
	}

	/**
	 * ajax_load_form
	 */
	function ajax_load_form()
	{
		if ($this->input->post('form_name') && $this->input->post('form_name') != "")
		{
			$this->load->view($this->input->post('form_name'));
		}
		else
		{
			$this->load->view('errro 409');
		}
	}

	/**
	 * Login user on the site
	 *
	 * @return void
	 */
	function login()
	{
		if ($this->tank_auth->is_logged_in())
		{ // logged in
			redirect('');
		}
		elseif ($this->tank_auth->is_logged_in(FALSE))
		{ // logged in, not activated
			redirect('/auth/send_again/');
		}
		else
		{
			$data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND $this->config->item('use_username', 'tank_auth'));
			$data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');
			$this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('remember', 'Remember me', 'integer');

			// Get login for counting attempts to login

			if ($this->config->item('login_count_attempts', 'tank_auth') AND ($login = $this->input->post('login')))
			{
				$login = $this->security->xss_clean($login);
			}
			else
			{
				$login = '';
			}

			$data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
			if ($this->tank_auth->is_max_login_attempts_exceeded($login))
			{
				if ($data['use_recaptcha']) $this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				else $this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
			}

			$data['errors'] = array();
			if ($this->form_validation->run())
			{ // validation ok
				if ($this->tank_auth->login($this->form_validation->set_value('login') , $this->form_validation->set_value('password') , $this->form_validation->set_value('remember') , $data['login_by_username'], $data['login_by_email']))
				{ // success
					redirect('');
				}
				else
				{
					$errors = $this->tank_auth->get_error_message();
					if (isset($errors['banned']))
					{ // banned user
						$this->_show_message($this->lang->line('auth_message_banned') . ' ' . $errors['banned']);
					}
					elseif (isset($errors['not_activated']))
					{ // not activated user
						redirect('/auth/send_again/');
					}
					else
					{ // fail
						foreach($errors as $k => $v) $data['errors'][$k] = $this->lang->line($v);
					}
				}
			}

			$data['show_captcha'] = FALSE;
			if ($this->tank_auth->is_max_login_attempts_exceeded($login))
			{
				$data['show_captcha'] = TRUE;
				if ($data['use_recaptcha'])
				{
					$data['recaptcha_html'] = $this->_create_recaptcha();
				}
				else
				{
					$data['captcha_html'] = $this->_create_captcha();
				}
			}
			
			$data['title'] = $this->m_config->get_config()->title;
			$data['remove_powered_by'] = $this->m_config->get_config()->remove_powered_by;

			$this->load->view('auth/login_form_', $data);
		}
	}

	/**
	 * Logout user
	 *
	 * @return void
	 */
	function logout()
	{
		$this->tank_auth->logout();
		$this->_show_message($this->lang->line('auth_message_logged_out'));
	}

	/**
	 * Register user on the site
	 *
	 * @return void
	 */
	function all_users() // all usser table view with detailed link
	{
		if (!$this->tank_auth->is_logged_in())
		{
			redirect('/auth/login/');
		}
		else
		{
			$data['user_id'] = $this->tank_auth->get_user_id();
			$data['username'] = $this->tank_auth->get_username();
			$data['title'] = $this->m_config->get_config()->title;
			$data['sub_title'] = 'All Users';
			$data['qry_users'] = $this->users->get_all_user();
			$data['content'] = $this->load->view('auth/all_users', $data, true);
			$this->load->view('dashboard_default', $data);
		}
	}

	function ban_user() // ban user
	{
		if (!$this->tank_auth->is_logged_in())
		{
			redirect('/auth/login/');
		}
		else
		{
			$user_data = $this->users->get_user_data_by_id($this->tank_auth->get_user_id());
			$data['username'] = $user_data->username;
			$data['user_id'] = $user_data->id;
			if (($user_data->user_type == 1 || $user_data->user_type == 2))
			{
				$dat = array(
					'banned' => 1,
				);
				$this->db->where('id', $this->uri->segment(3, 0));
				$this->db->update('users', $dat);
				$data['content'] = '<div class="alert alert-warning" role="alert">User Banned</div>';
			}
			else
			{
				$data['content'] = '<div class="alert alert-danger" role="alert">You are not Authorised!</div>';
			}

			$data['title'] = $this->m_config->get_config()->title;
			$data['sub_title'] = 'Ban User';
			$data['qry_users'] = $this->users->get_all_user();
			$data['content'].= $this->load->view('auth/all_users', $data, true);
			$this->load->view('dashboard_default', $data);
		}
	}

	function unban_user() // all usser table view with detailed link
	{
		if (!$this->tank_auth->is_logged_in())
		{
			redirect('/auth/login/');
		}
		else
		{
			$user_data = $this->users->get_user_data_by_id($this->tank_auth->get_user_id());
			$data['username'] = $user_data->username;
			$data['user_id'] = $user_data->id;
			if (($user_data->user_type == 1 || $user_data->user_type == 2))
			{
				$dat = array(
					'banned' => 0,
				);
				$this->db->where('id', $this->uri->segment(3, 0));
				$this->db->update('users', $dat);
				$data['content'] = '<div class="alert alert-success" role="alert">User Activated</div>';
			}
			else
			{
				$data['content'] = '<div class="alert alert-danger" role="alert">You are not Authorised!</div>';
			}

			$data['title'] = $this->m_config->get_config()->title;
			$data['sub_title'] = 'Activate User';
			$data['qry_users'] = $this->users->get_all_user();
			$data['content'].= $this->load->view('auth/all_users', $data, true);
			$this->load->view('dashboard_default', $data);
		}
	}
	
	function make_owner() // all usser table view with detailed link
	{
		if (!$this->tank_auth->is_logged_in())
		{
			redirect('/auth/login/');
		}
		else
		{
			$user_data = $this->users->get_user_data_by_id($this->tank_auth->get_user_id());
			$data['username'] = $user_data->username;
			$data['user_id'] = $user_data->id;
			if (( $user_data->user_type == 1 ))
			{
				$dat = array(
					'user_type' => 1,
				);
				$this->db->where('id', $this->uri->segment(3, 0));
				$this->db->update('users', $dat);
				$data['content'] = '<div class="alert alert-success" role="alert">User Promoted to Owner</div>';
			}
			else
			{
				$data['content'] = '<div class="alert alert-danger" role="alert">You are not Authorised!</div>';
			}

			$data['title'] = $this->m_config->get_config()->title;
			$data['sub_title'] = 'Activate User';
			$data['qry_users'] = $this->users->get_all_user();
			$data['content'].= $this->load->view('auth/all_users', $data, true);
			$this->load->view('dashboard_default', $data);
		}
	}
	
	function make_staff() // all usser table view with detailed link
	{
		if (!$this->tank_auth->is_logged_in())
		{
			redirect('/auth/login/');
		}
		else
		{
			$user_data = $this->users->get_user_data_by_id($this->tank_auth->get_user_id());
			$data['username'] = $user_data->username;
			$data['user_id'] = $user_data->id;
			if (( $user_data->user_type == 1 ))
			{
				$dat = array(
					'user_type' => 3,
				);
				$this->db->where('id', $this->uri->segment(3, 0));
				$this->db->update('users', $dat);
				$data['content'] = '<div class="alert alert-success" role="alert">User Demoted to Staff</div>';
			}
			else
			{
				$data['content'] = '<div class="alert alert-danger" role="alert">You are not Authorised!</div>';
			}

			$data['title'] = $this->m_config->get_config()->title;
			$data['sub_title'] = 'Activate User';
			$data['qry_users'] = $this->users->get_all_user();
			$data['content'].= $this->load->view('auth/all_users', $data, true);
			$this->load->view('dashboard_default', $data);
		}
	}
	
	function delete_user() // all usser table view with detailed link
	{
		if (!$this->tank_auth->is_logged_in())
		{
			redirect('/auth/login/');
		}
		else
		{
			$user_data = $this->users->get_user_data_by_id($this->tank_auth->get_user_id());
			$data['username'] = $user_data->username;
			$data['user_id'] = $user_data->id;
			if (( $user_data->user_type == 1 ) && ($this->uri->segment(3, 0) != $data['user_id'] ))
			{				
				if($this->tank_auth->delete_user_by_admin( $this->uri->segment(3, 0) ))
				{
					$data['content'] = '<div class="alert alert-success" role="alert">Staff User Deleted</div>';
				}
				else
				{
					$data['content'] = '<div class="alert alert-danger" role="alert">Failed to Staff User Deleted</div>';
				}	
				
			}
			else
			{
				$data['content'] = '<div class="alert alert-danger" role="alert">You are not Authorised!</div>';
			}

			$data['title'] = $this->m_config->get_config()->title;
			$data['sub_title'] = 'User Deleted';
			$data['qry_users'] = $this->users->get_all_user();
			$data['content'].= $this->load->view('auth/all_users', $data, true);
			$this->load->view('dashboard_default', $data);
		}
	}

	function create_user() // create users for system use by admin or owner
	{
		if ($this->tank_auth->is_logged_in())
		{
			$user_data = $this->users->get_user_data_by_id($this->tank_auth->get_user_id());
			$data['username'] = $user_data->username;
			$data['user_id'] = $user_data->id;
			$data['title'] = $this->m_config->get_config()->title;
			$data['sub_title'] = 'Create New User';
			$data['qry_users'] = $this->users->get_all_user();
			$data['all_users'] = $this->load->view('auth/all_users', $data, true);
			$register_success = 0;
			if (($user_data->user_type == 1))
			{
				$use_username = $this->config->item('use_username', 'tank_auth');
				if ($use_username)
				{
					$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length[' . $this->config->item('username_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('username_max_length', 'tank_auth') . ']|alpha_dash');
				}

				$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
				$this->form_validation->set_rules('user_type', 'User Type', 'required|xss_clean');
				$this->form_validation->set_rules('full_name', 'Full name', 'required|xss_clean');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']|alpha_dash');
				$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');
				$this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean|min_length[' . $this->config->item('phone_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('phone_max_length', 'tank_auth') . ']|alpha_dash');
				$captcha_registration = $this->config->item('captcha_registration', 'tank_auth');
				$use_recaptcha = $this->config->item('use_recaptcha', 'tank_auth');
				if ($captcha_registration)
				{
					if ($use_recaptcha)
					{
						$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
					}
					else
					{
						$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
					}
				}

				$data['errors'] = array();
				$email_activation = $this->config->item('email_activation', 'tank_auth');
				if ($this->form_validation->run())
				{ // validation ok
					if (!is_null($data = $this->tank_auth->create_user_by_admin($use_username ? $this->form_validation->set_value('username') : '', $this->form_validation->set_value('email') , $this->form_validation->set_value('phone') , $this->form_validation->set_value('user_type') , $this->form_validation->set_value('full_name') , $this->form_validation->set_value('password') , $email_activation)))
					{ // success
						$data['site_name'] = $this->config->item('website_name', 'tank_auth');
						$register_success = 1;
						$user_name = $this->form_validation->set_value('full_name') . ' (' . $this->form_validation->set_value('username') . ' )';
					}
					else
					{
						$errors = $this->tank_auth->get_error_message();
						foreach($errors as $k => $v) $data['errors'][$k] = $this->lang->line($v);
					}
				}

				if ($captcha_registration)
				{
					if ($use_recaptcha)
					{
						$data['recaptcha_html'] = $this->_create_recaptcha();
					}
					else
					{
						$data['captcha_html'] = $this->_create_captcha();
					}
				}

				$data['use_username'] = $use_username;
				$data['captcha_registration'] = $captcha_registration;
				$data['use_recaptcha'] = $use_recaptcha;
				if ($register_success == 0)
				{
					$data['content'] = $this->load->view('auth/register_form', $data, true);
				}
				else
				{
					$data['content'] = '<div class="alert alert-success" role="alert"><h3>Well Done. New User <strong>"' . $user_name . '" </strong>Created Successfully.</h3></div>';
					$data['qry_users'] = $this->users->get_all_user();
					$data['content'].= $this->load->view('auth/all_users', $data, true);
				}
			}
			else
			{
				$data['content'] = '<div class="alert alert-danger" role="alert">You Are Not Authorised.</div>';
				$data['qry_users'] = $this->users->get_all_user();
				$data['content'].= $this->load->view('auth/all_users', $data, true);
			}

			$this->load->view('dashboard_default', $data);
		}
	}

	function register()
	{
		redirect('');
		if ($this->tank_auth->is_logged_in())
		{ // logged in
			redirect('');
		}
		elseif ($this->tank_auth->is_logged_in(FALSE))
		{ // logged in, not activated
			redirect('/auth/send_again/');
		}
		elseif (!$this->config->item('allow_registration', 'tank_auth'))
		{ // registration is off
			$this->_show_message($this->lang->line('auth_message_registration_disabled'));
		}
		else
		{
			$use_username = $this->config->item('use_username', 'tank_auth');
			if ($use_username)
			{
				$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length[' . $this->config->item('username_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('username_max_length', 'tank_auth') . ']|alpha_dash');
			}

			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']|alpha_dash');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');
			$captcha_registration = $this->config->item('captcha_registration', 'tank_auth');
			$use_recaptcha = $this->config->item('use_recaptcha', 'tank_auth');
			if ($captcha_registration)
			{
				if ($use_recaptcha)
				{
					$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				}
				else
				{
					$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
				}
			}

			$data['errors'] = array();
			$email_activation = $this->config->item('email_activation', 'tank_auth');
			if ($this->form_validation->run())
			{ // validation ok
				if (!is_null($data = $this->tank_auth->create_user($use_username ? $this->form_validation->set_value('username') : '', $this->form_validation->set_value('email') , $this->form_validation->set_value('password') , $email_activation)))
				{ // success
					$data['site_name'] = $this->config->item('website_name', 'tank_auth');
					if ($email_activation)
					{ // send "activate" email
						$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;
						$this->_send_email('activate', $data['email'], $data);
						unset($data['password']); // Clear password (just for any case)
						$this->_show_message($this->lang->line('auth_message_registration_completed_1'));
					}
					else
					{
						if ($this->config->item('email_account_details', 'tank_auth'))
						{ // send "welcome" email
							$this->_send_email('welcome', $data['email'], $data);
						}

						unset($data['password']); // Clear password (just for any case)
						$this->_show_message($this->lang->line('auth_message_registration_completed_2') . ' ' . anchor('/auth/login/', 'Login'));
					}
				}
				else
				{
					$errors = $this->tank_auth->get_error_message();
					foreach($errors as $k => $v) $data['errors'][$k] = $this->lang->line($v);
				}
			}

			if ($captcha_registration)
			{
				if ($use_recaptcha)
				{
					$data['recaptcha_html'] = $this->_create_recaptcha();
				}
				else
				{
					$data['captcha_html'] = $this->_create_captcha();
				}
			}

			$data['use_username'] = $use_username;
			$data['captcha_registration'] = $captcha_registration;
			$data['use_recaptcha'] = $use_recaptcha;
			$this->load->view('auth/register_form', $data);
		}
	}

	/**
	 * Send activation email again, to the same or new email address
	 *
	 * @return void
	 */
	function send_again()
	{
		if (!$this->tank_auth->is_logged_in(FALSE))
		{ // not logged in or activated
			redirect('/auth/login/');
		}
		else
		{
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
			$data['errors'] = array();
			if ($this->form_validation->run())
			{ // validation ok
				if (!is_null($data = $this->tank_auth->change_email($this->form_validation->set_value('email'))))
				{ // success
					$data['site_name'] = $this->config->item('website_name', 'tank_auth');
					$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;
					$this->_send_email('activate', $data['email'], $data);
					$this->_show_message(sprintf($this->lang->line('auth_message_activation_email_sent') , $data['email']));
				}
				else
				{
					$errors = $this->tank_auth->get_error_message();
					foreach($errors as $k => $v) $data['errors'][$k] = $this->lang->line($v);
				}
			}

			$this->load->view('auth/send_again_form', $data);
		}
	}

	/**
	 * Activate user account.
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function activate()
	{
		$user_id = $this->uri->segment(3);
		$new_email_key = $this->uri->segment(4);

		// Activate user

		if ($this->tank_auth->activate_user($user_id, $new_email_key))
		{ // success
			$this->tank_auth->logout();
			$this->_show_message($this->lang->line('auth_message_activation_completed') . ' ' . anchor('/auth/login/', 'Login'));
		}
		else
		{ // fail
			$this->_show_message($this->lang->line('auth_message_activation_failed'));
		}
	}

	/**
	 * Generate reset code (to change password) and send it to user
	 *
	 * @return void
	 */
	function forgot_password()
	{
		if ($this->tank_auth->is_logged_in())
		{ // logged in
			redirect('');
		}
		elseif ($this->tank_auth->is_logged_in(FALSE))
		{ // logged in, not activated
			redirect('/auth/send_again/');
		}
		else
		{
			$this->form_validation->set_rules('login', 'Email or login', 'trim|required|xss_clean');
			$data['errors'] = array();
			if ($this->form_validation->run())
			{ // validation ok
				if (!is_null($data = $this->tank_auth->forgot_password($this->form_validation->set_value('login'))))
				{
					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					// Send email with password activation link

					$this->_send_email('forgot_password', $data['email'], $data);
					$this->_show_message($this->lang->line('auth_message_new_password_sent'));
				}
				else
				{
					$errors = $this->tank_auth->get_error_message();
					foreach($errors as $k => $v) $data['errors'][$k] = $this->lang->line($v);
				}
			}

			$this->load->view('auth/forgot_password_form', $data);
		}
	}

	/**
	 * Replace user password (forgotten) with a new one (set by user).
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function reset_password()
	{
		regirect('');
		$user_id = $this->uri->segment(3);
		$new_pass_key = $this->uri->segment(4);
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']|alpha_dash');
		$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');
		$data['errors'] = array();
		if ($this->form_validation->run())
		{ // validation ok
			if (!is_null($data = $this->tank_auth->reset_password($user_id, $new_pass_key, $this->form_validation->set_value('new_password'))))
			{ // success
				$data['site_name'] = $this->config->item('website_name', 'tank_auth');

				// Send email with new password

				$this->_send_email('reset_password', $data['email'], $data);
				$this->_show_message($this->lang->line('auth_message_new_password_activated') . ' ' . anchor('/auth/login/', 'Login'));
			}
			else
			{ // fail
				$this->_show_message($this->lang->line('auth_message_new_password_failed'));
			}
		}
		else
		{

			// Try to activate user by password key (if not activated yet)

			if ($this->config->item('email_activation', 'tank_auth'))
			{
				$this->tank_auth->activate_user($user_id, $new_pass_key, FALSE);
			}

			if (!$this->tank_auth->can_reset_password($user_id, $new_pass_key))
			{
				$this->_show_message($this->lang->line('auth_message_new_password_failed'));
			}
		}

		$this->load->view('auth/reset_password_form', $data);
	}

	/**
	 * Change user password
	 *
	 * @return void
	 */
	function update_password()
	{
		if ($this->tank_auth->is_logged_in())
		{
			$user_data = $this->users->get_user_data_by_id($this->tank_auth->get_user_id());
			$data['username'] = $user_data->username;
			$data['user_id'] = $user_data->id;
			$data['title'] = 'Users | Update Password';
			$data['sub_title'] = 'Users | Update Password';
			$data['qry_users'] = $this->users->get_all_user();
			$data['all_users'] = $this->load->view('auth/all_users', $data, true);
			$action_user_data = $this->users->get_user_data_by_id($this->uri->segment(3, 0));
			$data['action_user'] = $action_user_data;
			$update_success = 0;
			if (($user_data->user_type == 1) || ($user_data->user_type == 2))
			{
				$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']|alpha_dash');
				$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');
				$data['errors'] = array();
				if ($this->form_validation->run())
				{ // validation ok
					if ($this->tank_auth->update_password($action_user_data->id, $this->form_validation->set_value('new_password')))
					{ // success
						$update_success = 1;
					}
					else
					{ // fail
						$errors = $this->tank_auth->get_error_message();
						foreach($errors as $k => $v) $data['errors'][$k] = $this->lang->line($v);
					}
				}

				if ($update_success == 0)
				{
					$data['content'] = $this->load->view('auth/update_password_form_admin', $data, true);
				}
				else
				{
					$data['content'] = '<div class="alert alert-success" role="alert"><h3>Well Done! Password for Employee <strong>"' . $action_user_data->full_name . '(' . $action_user_data->username . ')" </strong>Updated Successfully.</h3></div>';
					$data['qry_users'] = $this->users->get_all_user();
					$data['content'].= $this->load->view('auth/all_users', $data, true);
				}

				$this->load->view('dashboard_default', $data);
			}
		}
	}

	function change_password()
	{
		if (!$this->tank_auth->is_logged_in())
		{ // not logged in or not activated
			redirect('/auth/login/');
		}
		else
		{
			$ch = 0;
			$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']|alpha_dash');
			$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');
			$data['errors'] = array();
			if ($this->form_validation->run())
			{ // validation ok
				if ($this->tank_auth->change_password($this->form_validation->set_value('old_password') , $this->form_validation->set_value('new_password')))
				{ // success
				
					
					$ch = 1; 
				}
				else
				{ // fail
					$errors = $this->tank_auth->get_error_message();
					foreach($errors as $k => $v) $data['errors'][$k] = $this->lang->line($v);
				}
			}
			
			if($ch==0)
			{ 	
				$data['content'] = $this->load->view('auth/change_password_form', $data, true);
			}
			else
			{
				$data['content'] = '<div class="alert alert-success alert-dismissible fade in" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
											</button>
											<strong>Password Changed Successfully</strong> 
										  </div>';
					
			}
			
			$data['user_id'] = $this->tank_auth->get_user_id();
			$data['username'] = $this->tank_auth->get_username();
			$data['title'] = 'Change Password';
			$this->load->view('dashboard_default', $data);
		}
	}

	/**
	 * Change user email
	 *
	 * @return void
	 */
	function change_email()
	{
		if (!$this->tank_auth->is_logged_in())
		{ // not logged in or not activated
			redirect('/auth/login/');
		}
		else
		{
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
			$data['errors'] = array();
			if ($this->form_validation->run())
			{ // validation ok
				if (!is_null($data = $this->tank_auth->set_new_email($this->form_validation->set_value('email') , $this->form_validation->set_value('password'))))
				{ // success
					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					// Send email with new email address and its activation link

					$this->_send_email('change_email', $data['new_email'], $data);
					$this->_show_message(sprintf($this->lang->line('auth_message_new_email_sent') , $data['new_email']));
				}
				else
				{
					$errors = $this->tank_auth->get_error_message();
					foreach($errors as $k => $v) $data['errors'][$k] = $this->lang->line($v);
				}
			}

			$this->load->view('auth/change_email_form', $data);
		}
	}

	/**
	 * Replace user email with a new one.
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function reset_email()
	{
		$user_id = $this->uri->segment(3);
		$new_email_key = $this->uri->segment(4);

		// Reset email

		if ($this->tank_auth->activate_new_email($user_id, $new_email_key))
		{ // success
			$this->tank_auth->logout();
			$this->_show_message($this->lang->line('auth_message_new_email_activated') . ' ' . anchor('/auth/login/', 'Login'));
		}
		else
		{ // fail
			$this->_show_message($this->lang->line('auth_message_new_email_failed'));
		}
	}

	/**
	 * Delete user from the site (only when user is logged in)
	 *
	 * @return void
	 */
	function unregister()
	{
		if (!$this->tank_auth->is_logged_in())
		{ // not logged in or not activated
			redirect('/auth/login/');
		}
		else
		{
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$data['errors'] = array();
			if ($this->form_validation->run())
			{ // validation ok
				if ($this->tank_auth->delete_user($this->form_validation->set_value('password')))
				{ // success
					$this->_show_message($this->lang->line('auth_message_unregistered'));
				}
				else
				{ // fail
					$errors = $this->tank_auth->get_error_message();
					foreach($errors as $k => $v) $data['errors'][$k] = $this->lang->line($v);
				}
			}

			$this->load->view('auth/unregister_form', $data);
		}
	}

	/**
	 * Show info message
	 *
	 * @param	string
	 * @return	void
	 */
	function _show_message($message)
	{
		$this->session->set_flashdata('message', $message);
		redirect('/auth/');
	}

	/**
	 * Send email message of given type (activate, forgot_password, etc.)
	 *
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	void
	 */
	function _send_email($type, $email, &$data)
	{
		$this->load->library('email');
		$this->email->from($this->config->item('webmaster_email', 'tank_auth') , $this->config->item('website_name', 'tank_auth'));
		$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth') , $this->config->item('website_name', 'tank_auth'));
		$this->email->to($email);
		$this->email->subject(sprintf($this->lang->line('auth_subject_' . $type) , $this->config->item('website_name', 'tank_auth')));
		$this->email->message($this->load->view('email/' . $type . '-html', $data, TRUE));
		$this->email->set_alt_message($this->load->view('email/' . $type . '-txt', $data, TRUE));
		$this->email->send();
	}

	/**
	 * Create CAPTCHA image to verify user as a human
	 *
	 * @return	string
	 */
	function _create_captcha()
	{
		$this->load->helper('captcha');
		$cap = create_captcha(array(
			'img_path' => './' . $this->config->item('captcha_path', 'tank_auth') ,
			'img_url' => base_url() . $this->config->item('captcha_path', 'tank_auth') ,
			'font_path' => './' . $this->config->item('captcha_fonts_path', 'tank_auth') ,
			'font_size' => $this->config->item('captcha_font_size', 'tank_auth') ,
			'img_width' => $this->config->item('captcha_width', 'tank_auth') ,
			'img_height' => $this->config->item('captcha_height', 'tank_auth') ,
			'show_grid' => $this->config->item('captcha_grid', 'tank_auth') ,
			'expiration' => $this->config->item('captcha_expire', 'tank_auth') ,
		));

		// Save captcha params in session

		$this->session->set_flashdata(array(
			'captcha_word' => $cap['word'],
			'captcha_time' => $cap['time'],
		));
		return $cap['image'];
	}

	/**
	 * Callback function. Check if CAPTCHA test is passed.
	 *
	 * @param	string
	 * @return	bool
	 */
	function _check_captcha($code)
	{
		$time = $this->session->flashdata('captcha_time');
		$word = $this->session->flashdata('captcha_word');
		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);
		if ($now - $time > $this->config->item('captcha_expire', 'tank_auth'))
		{
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
			return FALSE;
		}
		elseif (($this->config->item('captcha_case_sensitive', 'tank_auth') AND $code != $word) OR strtolower($code) != strtolower($word))
		{
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * Create reCAPTCHA JS and non-JS HTML to verify user as a human
	 *
	 * @return	string
	 */
	function _create_recaptcha()
	{
		$this->load->helper('recaptcha');

		// Add custom theme so we can get only image

		$options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

		// Get reCAPTCHA JS and non-JS HTML

		$html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'));
		return $options . $html;
	}

	/**
	 * Callback function. Check if reCAPTCHA test is passed.
	 *
	 * @return	bool
	 */
	function _check_recaptcha()
	{
		$this->load->helper('recaptcha');
		$resp = recaptcha_check_answer($this->config->item('recaptcha_private_key', 'tank_auth') , $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
		if (!$resp->is_valid)
		{
			$this->form_validation->set_message('_check_recaptcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}

		return TRUE;
	}
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */