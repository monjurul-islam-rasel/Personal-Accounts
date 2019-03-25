<?php
$datestring = date('Y-m-d') . ' first day of last month';
$dt = date_create($datestring);

$cat_id = $this->input->post('cat_id');

$qry_cat = $this->db->get_where('category', array('id'=>$cat_id));

if($qry_cat->num_rows()>0)
{
	$qry_cat_res = $qry_cat->row();
	
	if($qry_cat_res->cat_type==1)
	{	
		$cat_type = '1';
		$cat = 'Income';
	}
	else
	{
		$cat_type = '0';
		$cat = 'Expense';
	}

	?>

<div class="x_panel">
  <div class="x_title">
    <h2 id="listing_header">
      <?php if (isset($listing_header)) echo $listing_header; else echo 'Category <strong> '.$qry_cat_res->name.' </strong> - ' . date('F-Y'); ?>
      <small><?php echo $cat; ?> Category</small>
    </h2>
    <ul class="nav navbar-right panel_toolbox">
      <li class="dropdown" style="float: right;">
        <ul class="nav navbar-right panel_toolbox" style="float:right; margin-top:5px;">
         
         
            <button data-toggle="dropdown" class="btn btn-danger dropdown-toggle btn-sm" type="button"
									aria-expanded="false"> Change Date <i class="fa fa-calendar"></i> <span
									class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="#" onclick="view_cat_wise_inc_exp('<?php echo $cat_id; ?>', '<?php echo date('Y-m'); ?>',  '<?php echo date('Y-m'); ?>', 'current_m')"> Current Month </a></li>
              <li><a href="#" onclick="view_cat_wise_inc_exp('<?php echo $cat_id; ?>', '<?php echo $dt->format('Y-m'); ?>', '<?php echo $dt->format('Y-m'); ?>','previous_m')"> Previous Month</a> </li>
              <li><a href="#" onclick="view_cat_wise_inc_exp('<?php echo $cat_id; ?>', '<?php echo date('Y'); ?>', '<?php echo date('Y'); ?>', 'current_y')"> Current Year</a> </li>
              <li><a href="#" onclick="view_cat_wise_inc_exp('<?php echo $cat_id; ?>', '<?php echo date("Y", strtotime("-1 year")); ?>', '<?php echo date("Y", strtotime("-1 year")); ?>', 'previous_y')"> Previous
                Year</a> </li>
              <li><a href="#" onclick="view_cat_wise_inc_exp('<?php echo $cat_id; ?>', '<?php echo 'ALL'; ?>', '<?php echo 'ALL'; ?>', '<?php echo 'ALL'; ?>')"> List All</a> </li>
              <li><a href="#" onclick="cat_wise_report_datepicker('<?php echo $cat_id; ?>')">Custom range</a> </li>
            </ul>
          
        </ul>
      </li>
    </ul>
    <div class="clearfix"></div>
  </div>
  <div class="x_content" id="record_listings">
  <div class="clearfix visible-xs-block">
  	<?php if (isset($listing_header)) echo $listing_header; else echo 'Category <strong> '.$qry_cat_res->name.' </strong> - ' . date('F-Y'); ?>
  </div>
    <?php
	
		$expense_details = '<div class="accordion" id="accordion_expense" role="tablist" aria-multiselectable="true">
							  <div class="panel">
								<a class="panel-heading collapsed" role="tab" id="headingOne_expense" data-toggle="collapse" data-parent="#accordion_expense" href="#collapseOne_expense" aria-expanded="false" aria-controls="collapseOne">
								  <h4 class="panel-title">View Details <i class="fa fa-sort-down"></i></h4>
								</a>
								<div id="collapseOne_expense" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_expense" aria-expanded="false" style="height: 0px;">
								  <div class="panel-body">
									<table class="table table-bordered">
									  <thead>
										<tr>
										  <th>#</th>
										  <th>Purpose</th>
										  <th>Amount</th>										  
										</tr>
									  </thead>
									  <tbody>';
									
						  
						  
		$income_details = '<div class="accordion" id="accordion_income" role="tablist" aria-multiselectable="true">
							  <div class="panel">
								<a class="panel-heading collapsed" role="tab" id="headingOne_income" data-toggle="collapse" data-parent="#accordion_income" href="#collapseOne_income" aria-expanded="false" aria-controls="collapseOne">
								  <h4 class="panel-title">View Details <i class="fa fa-sort-down"></i></h4>
								</a>
								<div id="collapseOne_income" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_income" aria-expanded="false" style="height: 0px;">
								  <div class="panel-body">
									<table class="table table-bordered">
									  <thead>
										<tr>
										  <th>#</th>
										  <th>Purpose</th>
										  <th>Amount</th>										  
										</tr>
									  </thead>
									  <tbody>';
									
									
		
		
		if($cat_data->parent_id != 0)
		{
			$exp_cat_tot = 0;
			$inc_cat_tot = 0;
			
			$esl = 1;
			foreach ($qry_expense->result() as $qry_cat_exp_res) {
				
				$exp_cat_tot += $qry_cat_exp_res->amount;
				
				$expense_details .= ' <tr>
										<th>'.$esl.'. </th>
										<th>'.$qry_cat_exp_res->purpose.' <br /> 
											'.date('d M Y', strtotime($qry_cat_exp_res->date)).'
										</th>
										<th>'.$this->cart->format_number($qry_cat_exp_res->amount).'</th>										  
									  </tr>';
				$esl++;
								
			}
			
			$isl = 1;
			foreach ($qry_income->result() as $qry_cat_inc_res) {
				
				$inc_cat_tot += $qry_cat_inc_res->amount;
				
				$income_details .= ' <tr>
										<th>'.$isl.'. </th>
										<th>'.$qry_cat_inc_res->purpose.' <br /> 
											'.date('d M Y', strtotime($qry_cat_inc_res->date)).'
										</th>
										<th>'.$this->cart->format_number($qry_cat_inc_res->amount).'</th>										  
									  </tr>';
				$isl++;
			}
		}
		else
		{			
			$exp_cat_tot = 0;
			$inc_cat_tot = 0;
			
			$esl = 1;
			foreach ($qry_expense->result() as $qry_cat_exp_res) 
			{				
				$exp_cat_tot += $qry_cat_exp_res->amount;
				
				$expense_details .= ' <tr>
										<th>'.$esl.'. </th>
										<th>'.$qry_cat_exp_res->purpose.' <br />
											'.date('d M Y', strtotime($qry_cat_exp_res->date)).'
										</th>
										<th>'.$this->cart->format_number($qry_cat_exp_res->amount).'</th>										  
									  </tr>';
				$esl++;				
			}
			
			$isl = 1;
			foreach ($qry_income->result() as $qry_cat_inc_res) {
				
				$inc_cat_tot += $qry_cat_inc_res->amount;	
				
				$income_details .= ' <tr>
										<th>'.$isl.'. </th>
										<th>'.$qry_cat_inc_res->purpose.' <br />
											'.date('d M Y', strtotime($qry_cat_inc_res->date)).'	
										</th>
										<th>'.$this->cart->format_number($qry_cat_inc_res->amount).'</th>										  
									  </tr>';
				$isl++;			
			}
			
			$qry_child_cat = $this->db->get_where('category', array());
			
			$exp_cat_child_tot = 0;
			$inc_cat_child_tot = 0;
			
			$qry_child_cat = $this->db->get_where('category', array('parent_id' => $cat_id));

			foreach ($qry_child_cat->result() as $qry_child_cat_res) 
			{				
				if($this->input->post('type')=='ALL')
				{
					$data['qry_expense'] = $this->db->get_where('expense_list', array('category'=>$qry_child_cat_res->id));
					$data['qry_income'] = $this->db->get_where('income_list', array('category'=>$qry_child_cat_res->id)); 					
				}				
				elseif($this->input->post('type')=='custom')
				{				 
					$this->db->where('date BETWEEN "'. date('Y-m-d', strtotime($this->input->post('from_dt'))). '" and "'. date('Y-m-d', strtotime($this->input->post('to_dt'))).'"');
					$data['qry_expense'] = $this->db->get_where('expense_list', array('category'=>$qry_child_cat_res->id)); // qry for expense
					
					$this->db->where('date BETWEEN "'. date('Y-m-d', strtotime($this->input->post('from_dt'))). '" and "'. date('Y-m-d', strtotime($this->input->post('to_dt'))).'"');
					$data['qry_income'] = $this->db->get_where('income_list', array('category'=>$qry_child_cat_res->id)); // qry for income					
				}
				else
				{
					$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year expense entry records.
					$data['qry_expense'] = $this->db->get_where('expense_list', array('category'=>$qry_child_cat_res->id)); // qry for expense
					
					$this->db->like('date', $this->input->post('from_dt')); // query for date based month or year expense entry records.
					$data['qry_income'] = $this->db->get_where('income_list', array('category'=>$qry_child_cat_res->id)); // qry for income	
				}
				
				
				$expense_details .= '
									<tr style="background-color:#dbf1f1; margin-top: 3px;">
										<th colspan="3" style="text-align:center;">'.$qry_child_cat_res->name.'</th>	
									</tr>';
										
				$income_details .= '<tr style="background-color:#dbf1f1;">
										<th colspan="3"  style="text-align:center;">'.$qry_child_cat_res->name.'</th>	
									</tr>';
				
				$ecsl = 1;	
				foreach ($data['qry_expense']->result() as $qry_child_cat_exp_res) 
				{					
					$exp_cat_child_tot += $qry_child_cat_exp_res->amount;
					
					$expense_details .= '
										 <tr>
											<th>'.$ecsl.'. </th>
											<th>'.$qry_child_cat_exp_res->purpose.' <br />
												'.date('d M Y', strtotime($qry_child_cat_exp_res->date)).'	
											</th>
											<th>'.$this->cart->format_number($qry_child_cat_exp_res->amount).'</th>										  
										  </tr>';
					$ecsl++;	
										
				}
				
				$icsl = 1;
				foreach ($data['qry_income']->result() as $qry_child_cat_inc_res) 
				{										
					$inc_cat_child_tot += $qry_child_cat_inc_res->amount;	
					
					$income_details .= '
										<tr>
										  <th>'.$icsl.'. </th>
										  <th>'.$qry_child_cat_inc_res->purpose.' <br /> 
										  	  '.date('d M Y', strtotime($qry_child_cat_inc_res->date)).'											  
										  </th>
										  <th>'.$this->cart->format_number($qry_child_cat_inc_res->amount).'</th>										  
										</tr>';
					$icsl++;					
				}
				
				$expense_details .= '
									<tr>
										<th colspan="3" style="text-align:center; color:#ded0d0; padding:0;"><i class="fa fa-ellipsis-h"></i></th>	
									</tr>';
									
				$income_details .= '
									<tr>
										<th colspan="3" style="text-align:center; color:#ded0d0; padding:0;"><i class="fa fa-ellipsis-h"></i></th>	
									</tr>';
				
			}

			$exp_cat_tot += $exp_cat_child_tot;
			$inc_cat_tot += $inc_cat_child_tot;

		}
		
	$income_details .= '				</tbody>
									</table>
								  </div>
								</div>
							  </div>
							 </div>';
							 
	$expense_details .= '				</tbody>
									</table>
								  </div>
								</div>
							  </div>
							 </div>';						 
    

	?>
    <div class="row tile_count">
    
    <?php
		
		if($cat_type==1)
		{
			?>
            <div class="col-xs-12 tile_stats_count" style="text-align:center; color:#5cb85c;"> 
                <h3  style="color:#5cb85c;"><i class="fa fa-money"></i> Total Income </h4>
                <div class="count"><?php echo $this->cart->format_number($inc_cat_tot); ?></div>
                <?php echo $income_details; ?> 
              </div>
            <?php
		}
		else
		{
			?>
            <div class="col-xs-12 tile_stats_count" style="text-align:center; color:#5cb85c;"> 
                <h3  style="color:#5cb85c;"><i class="fa fa-money"></i> Total Expense </h4>
                <div class="count"><?php echo $this->cart->format_number($exp_cat_tot); ?></div>
                <?php echo $expense_details; ?> 
              </div>
            <?php
		}
		
	?>
    
   
  </div>
</div>
<?php
}
else
{
	echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Holy guacamole!</strong> Best check yo self, you\'re not looking too good.
                  </div>';

}

?>
