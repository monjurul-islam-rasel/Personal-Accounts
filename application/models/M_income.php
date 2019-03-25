<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_income extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        if (!$this->tank_auth->is_logged_in()) {
            return null;
        }
	}
	
	
}

/* End of file m_income.php */
/* Location: ./application/models/m_company.php */