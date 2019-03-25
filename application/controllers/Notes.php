<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Notes Controller
 * Creator: SB TechValley ( https://www.sbtechvalley.com )
 * Date: 7/23/2018
 * Time: 11:45 AM
 */
 
class Notes extends CI_Controller
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
			$data['sub_title'] = 'Notes Management';
			$data['listing_header'] = 'All Notes - <strong style="color:#F00;"> ' . date('F Y') . '</strong>';

			$this->db->like('date', date('Y-m')); // query for currant month notes entry records.
			$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes

			$data['print_content'] = $this->load->view('notes/print', $data, true);
			$data['content'] = $this->load->view('notes/overview', $data, true);
			$this->load->view('dashboard_default', $data);
		}
	}

	function get_notes_custom() // ajax function returns all notes based on dates
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
				$data['listing_header'] = 'All Notes - <strong style="color:#F00;"> ALL Time</strong>';
				$data['qry_notes'] = $this->db->get_where('notes', array());
				$data['content'] = $this->load->view('notes/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'current_m')
			{
				$data['listing_header'] = 'All Notes - <strong style="color:#F00;"> ' . date_format(date_create($this->input->post('from_dt')) , "F Y") . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes
				$data['content'] = $this->load->view('notes/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'current_y')
			{
				$data['listing_header'] = 'All Notes - <strong style="color:#F00;">Year ' . date_format(date_create($this->input->post('from_dt')) , "Y") . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes
				$data['content'] = $this->load->view('notes/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'previous_m')
			{
				$data['listing_header'] = 'All Notes - <strong style="color:#F00;"> ' . date_format(date_create($this->input->post('from_dt')) , "F Y") . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes
				$data['content'] = $this->load->view('notes/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'previous_y')
			{
				$data['listing_header'] = 'All Notes - <strong style="color:#F00;">Year ' . $this->input->post('from_dt') . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes
				$data['content'] = $this->load->view('notes/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'custom')
			{
				$data['listing_header'] = 'All Notes - <strong style="color:#F00;"> ' . date_format(date_create($this->input->post('from_dt')) , "d M Y") . ' 
                to ' . date_format(date_create($this->input->post('to_dt')) , "d M Y") . '</strong>';
				$this->db->where('date BETWEEN "' . date('Y-m-d', strtotime($this->input->post('from_dt'))) . '" and "' . date('Y-m-d', strtotime($this->input->post('to_dt'))) . '"');
				$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes
				$data['content'] = $this->load->view('notes/overview_custom', $data, true);
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

	function add_notes() // function for adding notes
	{
		if (!$this->tank_auth->is_logged_in())
		{
			echo 0;
		}
		else
		{
			if (($this->input->post('title') && $this->input->post('title') != NULL) && ($this->input->post('status') != NULL))
			{
				$date_time = explode(' ', $this->input->post('datetime'));
				$time = date('H:i:s', strtotime($this->input->post('datetime')));
				$data = array(
					'title' => $this->input->post('title') ,
					'details' => $this->input->post('details') ,
					'date' => $date_time[0],
					'time' => $time,
					'reference' => $this->input->post('reference') ,
					'status' => $this->input->post('status') ,
					'created_by' => $this->tank_auth->get_user_id() ,
					'created_dt' => date('Y-m-d') ,
				);
				$this->db->insert('notes', $data);
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
	}

	function update_notes() // update fonction for updating notes
	{
		if (!$this->tank_auth->is_logged_in())
		{
			echo 0;
		}
		else
		{
			if (($this->input->post('title') && $this->input->post('title') != NULL) && ($this->input->post('status') != NULL))
			{
				$date_time = explode(' ', $this->input->post('datetime'));
				$time = date('H:i:s', strtotime($this->input->post('datetime')));
				$data = array(
					'title' => $this->input->post('title') ,
					'details' => $this->input->post('details') ,
					'date' => $date_time[0],
					'time' => $time,
					'reference' => $this->input->post('reference') ,
					'status' => $this->input->post('status') ,
					'updated_by' => $this->tank_auth->get_user_id() ,
				);
				$this->db->where('id', $this->input->post('notes_id'));
				$this->db->update('notes', $data);
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
	}

	function delete_notes() // function for deleting notes
	{
		if (!$this->tank_auth->is_logged_in())
		{
			echo 'Reload Page and try Again';
		}
		else
		{
			if (($this->input->post('notes_id') && $this->input->post('notes_id') != NULL))
			{
				$this->db->where('id', $this->input->post('notes_id'));
				$this->db->delete('notes');
				echo 1;
			}
			else
			{
				echo 'Error Occoured';
			}
		}
	}

	function print_notes_custom() // ajax function returns all notes based on dates for print
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
				$data['listing_header'] = 'All Notes - <strong style="color:#F00;"> ALL Time </strong>';
				$data['qry_notes'] = $this->db->get_where('notes', array());

				$data['content'] = $this->load->view('notes/print_overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'current_m')
			{
				$data['listing_header'] = 'All Notes - <strong style="color:#F00;">' . date_format(date_create($this->input->post('from_dt')) , "F Y") . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes
				$data['content'] = $this->load->view('notes/print_overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'current_y')
			{
				$data['listing_header'] = 'All Notes - <strong style="color:#F00;"> Year ' . date_format(date_create($this->input->post('from_dt')) , "Y") . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes

				$data['content'] = $this->load->view('notes/print_overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'previous_m')
			{
				$data['listing_header'] = 'All Notes - <strong style="color:#F00;"> ' . date_format(date_create($this->input->post('from_dt')) , "F Y") . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes

				$data['content'] = $this->load->view('notes/print_overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'previous_y')
			{
				$data['listing_header'] = 'All Notes - <strong style="color:#F00;">Year ' . $this->input->post('from_dt') . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes
				$data['content'] = $this->load->view('notes/print_overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'custom')
			{
				$data['listing_header'] = 'All Notes - <strong style="color:#F00;">' . date_format(date_create($this->input->post('from_dt')) , "d M Y") . ' 
                to ' . date_format(date_create($this->input->post('to_dt')) , "d M Y") . '</strong>';
				$this->db->where('date BETWEEN "' . date('Y-m-d', strtotime($this->input->post('from_dt'))) . '" and "' . date('Y-m-d', strtotime($this->input->post('to_dt'))) . '"');
				$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes
				$data['content'] = $this->load->view('notes/print_overview_custom', $data, true);
			}
			else
			{
				$data['listing_header'] = 'All Notes - <strong style="color:#F00;">' . date_format(date_create($this->input->post('from_dt')) , "F Y") . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year notes entry records.
				$data['qry_notes'] = $this->db->get_where('notes', array()); // qry for notes
				$data['content'] = $this->load->view('notes/print_overview_custom', $data, true);
			}

			$this->load->view('notes/print', $data);
		}
	}
}
