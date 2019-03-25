<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Reports Controller
 * Creator: SB TechValley ( https://www.sbtechvalley.com )
 * Date: 7/23/2018
 * Time: 11:45 AM
 */
 
class Reports extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('tank_auth');
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
			$data['sub_title'] = 'Income & Expense Reports';
			$data['listing_header'] = 'Report - <strong style="color:#F00;">' . date('F Y') . '</strong>';
			$this->db->like('date', date('Y-m')); // query for currant month income entry records.
			$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income
			$this->db->like('date', date('Y-m')); // query for currant month income entry records.
			$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for expense
			$data['content'] = $this->load->view('report/overview', $data, true);
			$this->load->view('dashboard_default', $data);
		}
	}

	function get_report_custom() // ajax function returns all income based on dates
	{
		if (!$this->tank_auth->is_logged_in())
		{
			$data['error'] = 1;
			echo json_encode($data);
		}
		else
		{
			$data['error'] = 0;
			if ($this->input->post('type') == 'ALL')
			{
				$data['listing_header'] = 'Reports - <strong style="color:#F00;"> ALL Time </strong>';
				$data['qry_income'] = $this->db->get_where('income_list', array());
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for expense
				$data['content'] = $this->load->view('report/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'current_m')
			{
				$data['listing_header'] = 'Reports - <strong style="color:#F00;">' . date_format(date_create($this->input->post('from_dt')) , "F Y") . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year income entry records.
				$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year income entry records.
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for income
				$data['content'] = $this->load->view('report/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'current_y')
			{
				$data['listing_header'] = 'Reports - <strong style="color:#F00;"> Year ' . date_format(date_create($this->input->post('from_dt')) , "Y") . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year income entry records.
				$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year income entry records.
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for income
				$data['content'] = $this->load->view('report/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'previous_m')
			{
				$data['listing_header'] = 'Reports - <strong style="color:#F00;"> ' . date_format(date_create($this->input->post('from_dt')) , "F Y") . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year income entry records.
				$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income

				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year income entry records.
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for income
				$data['content'] = $this->load->view('report/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'previous_y')
			{
				$data['listing_header'] = 'Reports - <strong style="color:#F00;">Year ' . $this->input->post('from_dt') . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year income entry records.
				$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income

				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year income entry records.
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for income
				$data['content'] = $this->load->view('report/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'custom')
			{
				$data['listing_header'] = 'Reports - <strong style="color:#F00;">' . date_format(date_create($this->input->post('from_dt')) , "d M Y") . ' 
                to ' . date_format(date_create($this->input->post('to_dt')) , "d M Y") . '</strong>';
				$this->db->where('date BETWEEN "' . date('Y-m-d', strtotime($this->input->post('from_dt'))) . '" and "' . date('Y-m-d', strtotime($this->input->post('to_dt'))) . '"');
				$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income

				$this->db->where('date BETWEEN "' . date('Y-m-d', strtotime($this->input->post('from_dt'))) . '" and "' . date('Y-m-d', strtotime($this->input->post('to_dt'))) . '"');
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for income
				$data['content'] = $this->load->view('report/overview_custom', $data, true);
			}

			$json_data['listing_header'] = $data['listing_header'];
			$json_data['content'] = $data['content'];
			$json_data['error'] = $data['error'];
			$json_data['from_dt'] = $this->input->post('from_dt');
			$json_data['to_dt'] = $this->input->post('to_dt');
			$json_data['type'] = $this->input->post('type');
			echo json_encode($json_data);
		}
	}

	function print_report_custom() // ajax function returns data for print
	{
		if (!$this->tank_auth->is_logged_in())
		{
			$data['error'] = 1;
			echo json_encode($data);
		}
		else
		{
			$data['title'] = $this->m_config->get_config()->title;
			
			$data['error'] = 0;
			
			if ($this->input->post('type') == 'ALL')
			{
				$data['listing_header'] = 'Reports - <strong style="color:#F00;"> ALL Time </strong>';
				$data['qry_income'] = $this->db->get_where('income_list', array());
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for expense
				$data['content'] = $this->load->view('report/print_overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'current_m')
			{
				$data['listing_header'] = 'Reports - <strong style="color:#F00;">' . date_format(date_create($this->input->post('from_dt')) , "F Y") . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year income entry records.
				$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year income entry records.
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for income
				$data['content'] = $this->load->view('report/print_overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'current_y')
			{
				$data['listing_header'] = 'Reports - <strong style="color:#F00;"> Year ' . date_format(date_create($this->input->post('from_dt')) , "Y") . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year income entry records.
				$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year income entry records.
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for income
				$data['content'] = $this->load->view('report/print_overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'previous_m')
			{
				$data['listing_header'] = 'Reports - <strong style="color:#F00;"> ' . date_format(date_create($this->input->post('from_dt')) , "F Y") . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year income entry records.
				$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income

				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year income entry records.
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for income
				$data['content'] = $this->load->view('report/print_overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'previous_y')
			{
				$data['listing_header'] = 'Reports - <strong style="color:#F00;">Year ' . $this->input->post('from_dt') . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year income entry records.
				$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income

				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year income entry records.
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for income
				$data['content'] = $this->load->view('report/print_overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'custom')
			{
				$data['listing_header'] = 'Reports - <strong style="color:#F00;">' . date_format(date_create($this->input->post('from_dt')) , "d M Y") . ' 
                to ' . date_format(date_create($this->input->post('to_dt')) , "d M Y") . '</strong>';
				$this->db->where('date BETWEEN "' . date('Y-m-d', strtotime($this->input->post('from_dt'))) . '" and "' . date('Y-m-d', strtotime($this->input->post('to_dt'))) . '"');
				$data['qry_income'] = $this->db->get_where('income_list', array()); // qry for income

				$this->db->where('date BETWEEN "' . date('Y-m-d', strtotime($this->input->post('from_dt'))) . '" and "' . date('Y-m-d', strtotime($this->input->post('to_dt'))) . '"');
				$data['qry_expense'] = $this->db->get_where('expense_list', array()); // qry for income
				$data['content'] = $this->load->view('report/print_overview_custom', $data, true);
			}

			$this->load->view('report/print', $data);
		}
	}
}
