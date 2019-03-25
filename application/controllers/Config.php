<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Config Controller
 * User: SB TechValley ( https://www.sbtechvalley.com )
 * Date: 7/23/2018
 * Time: 11:45 AM
 */
 
class Config extends CI_Controller
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
			if( $this->input->post('site_title') && $this->input->post('site_title')!="" )
			{				
				$this->db->where('id', 1);
				
				if($this->input->post('remove_powered_by'))
				{
					$this->db->update( 'config', array('title'=> $this->input->post('site_title'), 'remove_powered_by'=>1 ));
				}
				else
				{
					$this->db->update('config', array('title'=> $this->input->post('site_title'), 'remove_powered_by'=>0));
				}				
			}
		
			$data['user_id'] = $this->tank_auth->get_user_id();
			$data['username'] = $this->tank_auth->get_username();
			$data['title'] = $this->m_config->get_config()->title;
			$data['remove_powered_by'] = $this->m_config->get_config()->remove_powered_by;
			$data['sub_title'] = 'Configuration - Overview';
			$data['content'] = $this->load->view('config/site_settings', $data, true);
			$this->load->view('dashboard_default', $data);
			
		}
	}

	function category()
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
			$data['sub_title'] = 'Category Management';
			$data['qry_category'] = $this->db->get_where('category', array(
				'parent_id' => 0
			));

			$data['qry_category'] = $this->db->get_where('category', array(
				'parent_id' => 0
			));
			$data['content'] = $this->load->view('config/category_settings_v2', $data, true);
			$this->load->view('dashboard_default', $data);
		}
	}

	function create_category()
	{
		if (!$this->tank_auth->is_logged_in())
		{
			echo 0;
		}
		else
		{
			if ($this->input->post('parent_id') == "")
			{
				$parent_id = 0;
			}
			else
			{
				$parent_id = $this->input->post('parent_id');
			}

			if (($this->input->post('name') && $this->input->post('name') != NULL) && $this->input->post('status') != NULL)
			{
				$data = array(
					'parent_id' => $parent_id,
					'cat_type' => $this->input->post('cat_type') ,
					'name' => $this->input->post('name') ,
					'details' => $this->input->post('details') ,
					'status' => $this->input->post('status') ,
				);
				$this->db->insert('category', $data);
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
	}

	/**
	 *
	 */
	function update_category()
	{
		if (!$this->tank_auth->is_logged_in())
		{
			echo 0;
		}
		else
		{
			if ($this->input->post('cat_id') && $this->input->post('cat_id') != "")
			{
				if ($this->input->post('parent_id') && $this->input->post('parent_id') == "")
				{
					$parent_id = 0;
				}
				else
				{
					$parent_id = $this->input->post('parent_id');
				}

				if (($this->input->post('name') && $this->input->post('name') != NULL) && $this->input->post('status') != NULL)
				{
					$data = array(
						'parent_id' => $parent_id,
						'name' => $this->input->post('name') ,
						'details' => $this->input->post('details') ,
						'status' => $this->input->post('status')
					);
					$this->db->where('id', $this->input->post('cat_id'));
					$this->db->update('category', $data);
					echo 1;
				}
				else
				{
					echo 0;
				}
			}
		}
	}

	function delete_category() // deletes category if has no child or if its child category
	{
		if (!$this->tank_auth->is_logged_in())
		{
			echo 'Reload Page and try Again';
		}
		else
		{
			if (($this->input->post('cat_id') && $this->input->post('cat_id') != NULL))
			{
				$qry_cat = $this->db->get_where('category', array(
					'id' => $this->input->post('cat_id')
				));
				if ($qry_cat->num_rows() > 0)
				{
					$qry_cat_res = $qry_cat->row();
					if ($qry_cat_res->parent_id != 0) // if child category
					{
						$this->db->where('id', $qry_cat_res->id);
						$this->db->delete('category');
						echo 1;
					}
					else // if parent show message
					{
						if ($this->db->get_where('category', array(
							'parent_id' => $qry_cat_res->id
						))->num_rows() > 0) // check for child
						{
							echo 'This Category Cannot be deleted. It has its child category. Pleas Delete Child Category and Try Again.';
						}
						else // no child delete it
						{
							$this->db->where('id', $qry_cat_res->id);
							$this->db->delete('category');
							echo 1;
						}
					}
				}
				else
				{
					echo 'Error Occoured';
				}
			}
			else
			{
				echo 'Error Occoured';
			}
		}
	}

	// report area

	function get_category_wise_report_custom() // ajax function returns category wise income and expense based on dates
	{
		if (!$this->tank_auth->is_logged_in())
		{
			$data['error'] = 1;
			echo json_encode($data);
		}
		elseif ($this->db->get_where('category', array(
			'id' => $this->input->post('cat_id')
		))->num_rows() >= 0)
		{
			$cat_id = $this->input->post('cat_id');
			$qry_cat_res = $this->db->get_where('category', array(
				'id' => $this->input->post('cat_id')
			))->row();
			$data['cat_id'] = $cat_id;
			$data['cat_name'] = '<strong>' . $qry_cat_res->name . '</strong>';
			$data['cat_data'] = $qry_cat_res;
			if ($qry_cat_res->parent_id != 0)
			{
				$cat_parent_res = $this->db->get_where('category', array(
					'id' => $qry_cat_res->parent_id
				))->row();

				$data['cat_name'] = '<strong>' . $qry_cat_res->name . '( <spam>' . $cat_parent_res->name . '</spam> ) </strong>';
			}

			$data['error'] = 0;
			if ($this->input->post('type') == 'ALL')
			{
				$data['listing_header'] = '<strong>' . $data['cat_name'] . '</strong> - <strong style="color:#F00;">ALL Time</strong> ';
				$data['qry_expense'] = $this->db->get_where('expense_list', array(
					'category' => $cat_id
				));
				$data['qry_income'] = $this->db->get_where('income_list', array(
					'category' => $cat_id
				));
				$data['content'] = $this->load->view('expense/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'current_m')
			{
				$data['listing_header'] = '<strong>' . $data['cat_name'] . '</strong> - <strong style="color:#F00;">' . date_format(date_create($this->input->post('from_dt')) , "F - Y") . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year expense entry records.
				$data['qry_expense'] = $this->db->get_where('expense_list', array(
					'category' => $cat_id
				)); // qry for expense
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year expense entry records.
				$data['qry_income'] = $this->db->get_where('income_list', array(
					'category' => $cat_id
				)); // qry for income
				$data['content'] = $this->load->view('expense/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'current_y')
			{
				$data['listing_header'] = '<strong>' . $data['cat_name'] . '</strong> - <strong style="color:#F00;">Year ' . date_format(date_create($this->input->post('from_dt')) , "Y") . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year expense entry records.
				$data['qry_expense'] = $this->db->get_where('expense_list', array(
					'category' => $cat_id
				)); // qry for expense
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year expense entry records.
				$data['qry_income'] = $this->db->get_where('income_list', array(
					'category' => $cat_id
				)); // qry for income
				$data['content'] = $this->load->view('expense/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'previous_m')
			{
				$data['listing_header'] = '<strong>' . $data['cat_name'] . '</strong> - <strong style="color:#F00;">' . date_format(date_create($this->input->post('from_dt')) , "F -Y") . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year expense entry records.
				$data['qry_expense'] = $this->db->get_where('expense_list', array(
					'category' => $cat_id
				)); // qry for expense
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year expense entry records.
				$data['qry_income'] = $this->db->get_where('income_list', array(
					'category' => $cat_id
				)); // qry for income
				$data['content'] = $this->load->view('expense/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'previous_y')
			{
				$data['listing_header'] = '<strong>' . $data['cat_name'] . '</strong> - <strong style="color:#F00;">Year ' . $this->input->post('from_dt') . '</strong>';
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year expense entry records.
				$data['qry_expense'] = $this->db->get_where('expense_list', array(
					'category' => $cat_id
				)); // qry for expense
				$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year expense entry records.
				$data['qry_income'] = $this->db->get_where('income_list', array(
					'category' => $cat_id
				)); // qry for income
				$data['content'] = $this->load->view('expense/overview_custom', $data, true);
			}
			elseif ($this->input->post('type') == 'custom')
			{
				$data['listing_header'] = '<strong>' . $data['cat_name'] . '</strong> - <strong style="color:#F00;">' . date_format(date_create($this->input->post('from_dt')) , "d-M-Y") . ' to ' . date_format(date_create($this->input->post('to_dt')) , "d-M-Y") . '</strong>';
				$this->db->where('date BETWEEN "' . date('Y-m-d', strtotime($this->input->post('from_dt'))) . '" and "' . date('Y-m-d', strtotime($this->input->post('to_dt'))) . '"');
				$data['qry_expense'] = $this->db->get_where('expense_list', array(
					'category' => $cat_id
				)); // qry for expense
				$this->db->where('date BETWEEN "' . date('Y-m-d', strtotime($this->input->post('from_dt'))) . '" and "' . date('Y-m-d', strtotime($this->input->post('to_dt'))) . '"');
				$data['qry_income'] = $this->db->get_where('income_list', array(
					'category' => $cat_id
				)); // qry for income
				$data['content'] = $this->load->view('expense/overview_custom', $data, true);
			}
			else
			{
				$data['listing_header'] = '<strong>' . $data['cat_name'] . '</strong> - (ALL Time) ';
				$data['qry_expense'] = $this->db->get_where('expense_list', array());
				$data['qry_income'] = $this->db->get_where('expense_list', array());
				$data['content'] = $this->load->view('expense/overview_custom', $data, true);
			}

			$data['from_dt'] = $this->input->post('from_dt');
			$data['to_dt'] = $this->input->post('to_dt');
			$data['type'] = $this->input->post('type');
			$this->load->view($this->input->post('form_name') , $data);
		}
		else
		{
			$json_data['listing_header'] = '---';
			$json_data['content'] = '---';
			$json_data['error'] = 'Category Not Found';
			$this->load->view($this->input->post('form_name') , $data);
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
}