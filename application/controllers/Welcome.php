<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Welcome Controller
 * Creator: SB TechValley ( https://www.sbtechvalley.com )
 * Date: 7/23/2018
 * Time: 11:45 AM
 */
 
class Welcome extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('tank_auth');
		$this->load->model('m_config');
	}

	function index()
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
			$data['page'] = 'dashboard';
			$data['sub_title'] = 'Dashboard - Income / Expense';
			$this->db->like('date', date('Y-m-d')); // query for currant month expense entry records today.
			$data['qry_expense_today'] = $this->db->get_where('expense_list', array()); // qry for expense
			$this->db->like('date', date('Y-m-d')); // query for currant month income entry records today.
			$data['qry_income_today'] = $this->db->get_where('income_list', array()); // qry for income
			$this->db->like('date', date('Y-m')); // query for currant month expense entry records.
			$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for expense
			$this->db->like('date', date('Y-m')); // query for currant month income entry records.
			$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income
			$this->db->like('date', date('Y-m')); // query for currant month expense entry records.
			$this->db->order_by('id', 'desc');
			$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for expense
			$data['content'] = $this->load->view('dashboard/overview', $data, true);;
			$this->load->view('dashboard_default', $data);
		}
	}

	function get_overview_custom() // ajax function returns all notes based on dates
	{
		if (!$this->tank_auth->is_logged_in())
		{
			$data['error'] = 1;
			echo json_encode($data);
		}
		else
		{
			$data['user_id'] = $this->tank_auth->get_user_id();
			$data['username'] = $this->tank_auth->get_username();
			$data['title'] = $this->m_config->get_config()->title;
			$data['page'] = 'custom';
			$data['sub_title'] = 'Dashboard - Income / Expense';
			$data['error'] = 0;
			$this->db->like('date', date('Y-m-d')); // query for currant month expense entry records today.
			$data['qry_expense_today'] = $this->db->get_where('expense_list', array()); // qry for expense
			$this->db->like('date', date('Y-m-d')); // query for currant month income entry records today.
			$data['qry_income_today'] = $this->db->get_where('income_list', array()); // qry for income
			if ($this->input->post('type') == 'ALL')
			{
				$data['listing_header'] = ' ALL Time';
				$data['qry_notes'] = $this->db->get_where('notes', array());
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for expense
				$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income
				$data['content'] = $this->load->view('dashboard/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'current_m')
			{
				$data['listing_header'] = date_format(date_create($this->input->post('from_dt')) , "F Y");

				// notes

				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes

				// expense

				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for expense

				// income

				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income
				$data['content'] = $this->load->view('dashboard/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'current_y')
			{
				$data['listing_header'] = 'Year ' . date_format(date_create($this->input->post('from_dt')) , "Y");
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes

				// expense

				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for expense

				// income

				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income
				$data['content'] = $this->load->view('dashboard/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'previous_m')
			{
				$data['listing_header'] = date_format(date_create($this->input->post('from_dt')) , "F Y");
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes

				// expense

				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for expense

				// income

				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income
				$data['content'] = $this->load->view('dashboard/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'previous_y')
			{
				echo $this->input->post('from_dt');
				$data['listing_header'] = 'Year ' . $this->input->post('from_dt');
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes

				// expense

				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for expense

				// income

				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income
				$data['content'] = $this->load->view('dashboard/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'custom')
			{
				$data['listing_header'] = date_format(date_create($this->input->post('from_dt')) , "d M Y") . ' 
                to ' . date_format(date_create($this->input->post('to_dt')) , "d M Y");
				$this->db->where('date BETWEEN "' . date('Y-m-d', strtotime($this->input->post('from_dt'))) . '" and "' . date('Y-m-d', strtotime($this->input->post('to_dt'))) . '"');
				$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes

				// expense

				$this->db->where('date BETWEEN "' . date('Y-m-d', strtotime($this->input->post('from_dt'))) . '" and "' . date('Y-m-d', strtotime($this->input->post('to_dt'))) . '"');
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for expense

				// income

				$this->db->where('date BETWEEN "' . date('Y-m-d', strtotime($this->input->post('from_dt'))) . '" and "' . date('Y-m-d', strtotime($this->input->post('to_dt'))) . '"');
				$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income
				$data['content'] = $this->load->view('dashboard/overview_custom', $data, true);
			}

			$json_data['listing_header'] = $data['listing_header'];
			$json_data['content'] = $data['content'];
			$json_data['error'] = $data['error'];

			// echo json_encode($json_data);

			$data['content'] = $this->load->view('dashboard/overview', $data, true);;
			$this->load->view('dashboard_default', $data);
		}
	}

	function error404()
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
			$data['sub_title'] = 'Nothing Found';
			$data['content'] = $this->load->view('error404', $data, true);
			$this->load->view('dashboard_default', $data);
		}
	}

	function backup_db()
	{
		if (!$this->tank_auth->is_logged_in())
		{
			redirect('/auth/login/');
		}
		else
		{
			$data['user_id'] = $this->tank_auth->get_user_id();
			$data['username'] = $this->tank_auth->get_username();
			if ($this->tank_auth->get_user_id() == 1 || $this->tank_auth->get_user_id() == 2 || $this->tank_auth->get_user_id() == 3)
			{
				$this->load->dbutil();
				$prefs = array(
					'format' => 'zip',
					'filename' => 'pa_db_backup.sql'
				);
				$backup = $this->dbutil->backup($prefs);
				$db_name = 'Accounts db backup-on-' . date("Y-m-d-H-i-s") . '.zip';
				$this->load->helper('download');
				force_download($db_name, $backup);
				redirect();
				$this->load->view('dashboard', $data);
			}
			else
			{
				echo "<script type='text/javascript'>alert('You are not authorised.');</script>";
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */