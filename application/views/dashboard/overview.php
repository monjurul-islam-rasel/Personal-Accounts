<?php
/**
 * Dashboard overview view
 * Created by S. M. Monjurul Islam (Lead Programmer Sb TechValley).
 * User: Rasel, SB TechValley ( https://www.sbtechvalley.com )
 * Date: 7/23/2018
 * Time: 11:45 AM
 */
?>

<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2 id="listing_header">
					Overview - 
					 <strong style="color:#F00;">   <?php if (isset($listing_header)) echo $listing_header; else echo ' ' . date('F Y') . ' '; ?> </strong>
				</h2>
				<ul class="nav navbar-left panel_toolbox" style="float: left !important;">
					<?php
					$datestring = date('Y-m-d') . ' first day of last month';
					$dt = date_create($datestring);
					?>
					<li style="width:20px;">
						&nbsp;&nbsp;&nbsp;
					</li>

					<div class="btn-group">
						<!--<button class="btn btn-primary btn-sm" type="button"  onclick="load_overview_custom('<?php echo date('Y-m'); ?>', '<?php echo date('Y-m'); ?>', 'current_m')">Current Month</button>-->
						<div class="btn-group">
							<button data-toggle="dropdown" class="btn btn-danger dropdown-toggle btn-sm" type="button" aria-expanded="false"> Change Date <i class="fa fa-calendar"></i> <span class="caret"></span> </button>
							<ul class="dropdown-menu">
								<li><a href="#"
									   onclick="load_overview_custom('<?php echo date('Y-m'); ?>', '<?php echo date('Y-m'); ?>', 'current_m')">
										Current Month </a></li>
								<li><a href="#"
									   onclick="load_overview_custom('<?php echo $dt->format('Y-m'); ?>', '<?php echo $dt->format('Y-m'); ?>','previous_m')">
										Previous Month</a>
								</li>
								<li><a href="#"
									   onclick="load_overview_custom('<?php echo date('Y'); ?>', '<?php echo date('Y'); ?>', 'current_y')">
										Current Year</a>
								</li>
								<li><a href="#"
									   onclick="load_overview_custom('<?php echo date("Y", strtotime("-1 year")); ?>', '<?php echo date("Y", strtotime("-1 year")); ?>', 'previous_y')">
										Previous
										Year</a>
								</li>
								<li><a href="#"
									   onclick="load_overview_custom('<?php echo 'ALL'; ?>', '<?php echo 'ALL'; ?>', '<?php echo 'ALL'; ?>')">
										List All</a>
								</li>
								<li><a href="#" onclick="expense_list_datepicker()">Custom range</a>
								</li>
							</ul>
						</div>
					</div>


				</ul>
                
                
                
				<ul class="nav navbar-right panel_toolbox" style="float: right !important; margin-top:5px;">
					<a href="#" onclick="add_new_expense_form()" class="btn btn-warning">
                    	<i class="fa fa-plus"></i>
						Add New Expense </a>
					<a href="#" onclick="add_new_income_form()" class="btn btn-success"><i
							class="fa fa-plus"></i>
						Add New Income </a>
				</ul>
				<div class="clearfix"></div>
			</div>


			<div class="x_content" id="record_listings">

				<!------------------------------------->

				<?php

				$cat_inc_exp_chart = '';
				
				// tot income exp calculation today
				$today_expense = 0;
				$today_income = 0;
				
				foreach ($qry_expense_today->result() as $qry_expense_today_res) {
					$today_expense += $qry_expense_today_res->amount;
				}
				foreach ($qry_income_today->result() as $qry_income_today_res) {
					$today_income += $qry_income_today_res->amount;
				}
				// tot income exp calculation end
				
				// tot income exp calculation
				$total_expense = 0;
				$total_income = 0;
				
				foreach ($qry_expense->result() as $qry_expense_res) {
					$total_expense += $qry_expense_res->amount;
				}
				foreach ($qry_income->result() as $qry_income_res) {
					$total_income += $qry_income_res->amount;
				}
				// tot income exp calculation end

				/*// cat wise calculation
				$cat_array_profit = array(); // array for profit % of category

				$cat_array_inc_exp = array();

				$qry_cat = $this->db->get_where('category', array('status' => 1, 'parent_id' => 0));
				
				foreach ($qry_cat->result() as $qry_cat_res) 
				{
					$exp_cat_tot = 0;
					$inc_cat_tot = 0;
					foreach ($qry_expense->result() as $qry_cat_exp_res) {
						if ($qry_cat_exp_res->category == $qry_cat_res->id) {
							$exp_cat_tot += $qry_cat_exp_res->amount;
						}
					}
					foreach ($qry_income->result() as $qry_cat_inc_res) {
						if ($qry_cat_inc_res->category == $qry_cat_res->id) {
							$inc_cat_tot += $qry_cat_inc_res->amount;
						}
					}

					$exp_cat_child_tot = 0;
					$inc_cat_child_tot = 0;
					$qry_cat_child = $this->db->get_where('category', array('status' => 1, 'parent_id' => $qry_cat_res->id));

					foreach ($qry_cat_child->result() as $qry_cat_child_res) {
						foreach ($qry_expense->result() as $qry_cat_exp_res) {
							if ($qry_cat_exp_res->category == $qry_cat_child_res->id) {
								$exp_cat_child_tot += $qry_cat_exp_res->amount;
							}
						}
						foreach ($qry_income->result() as $qry_cat_inc_res) {
							if ($qry_cat_inc_res->category == $qry_cat_child_res->id) {
								$inc_cat_child_tot += $qry_cat_inc_res->amount;
							}
						}
					}

					$exp_cat_tot += $exp_cat_child_tot;
					$inc_cat_tot += $inc_cat_child_tot;

					$cat_array_inc_exp_temp = '';
					$cat_array_inc_exp_temp = array('exp' => $exp_cat_tot, 'inc' => $inc_cat_tot);
					$cat_array_inc_exp[$qry_cat_res->name] = $cat_array_inc_exp_temp; // array for cat wise inc and exp

					//	 category wise profit percentage from income and expense
					$x = $inc_cat_tot;
					$y = $exp_cat_tot;
					$p = $x - $y;
					if ($p >= 0) {
						if ($x != 0)
							$pp = ($p * 100) / $x;
						else
							$pp = 0;
					} else {
						if ($y != 0)
							$pp = ($p * 100) / $y;
						else
							$pp = 0;
					}
					$cat_array_profit[$qry_cat_res->name] = $pp; // calculate and add to cat wise profit array
//                    category wise profit percentage from income and expense end

					
					$cat_inc_exp_chart .= "{ y: '" . $qry_cat_res->name . "', a: " . $exp_cat_tot . ", b: " . $inc_cat_tot . " },";
					
					
				}*/
				
				?>
                
               
                
               
                <?php 
					
					if($page=='dashboard')
					{
						
					?>
               
                        <!--Today-->                
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2><?php if (isset($listing_header_today)) echo $listing_header_today; else echo '<strong style="color:#F00;"> Today - ' . date(' D d, F Y') . '</strong>'; ?></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
        
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content col-md-12">
                                    <!--echart_pie_today-->
                                    <div id="echart_pie_today" style="height:350px;"></div>
                                    <input type="hidden" value="<?php echo $today_expense; ?>"
                                           id="today_expense">
                                    <input type="hidden" value="<?php echo $today_income; ?>"
                                           id="today_income">
                                    <div class="clearfix"></div>
                                    <h3>
                                        <?php echo '<span class="label label-warning"> Expense : ' . $this->cart->format_number($today_expense) . '</span>'; ?>
                                    </h3>
                                    <h3>
                                        <?php echo '<span class="label label-success"> Income : ' . $this->cart->format_number($today_income) . '</span>'; ?>
                                    </h3>
                                    <h3>
                                        <?php
                                        $today_profit = $today_income - $today_expense;
                                        if ($today_profit < 0)
                                            echo '<span class="label label-info"> Estimated Profit : <strong style="color: red;">'
                                                . $this->cart->format_number($today_profit) . '</strong></span>';
                                        else
                                            echo '<span class="label label-info" > Estimated Profit : <strong style="color: green;">' . $this->cart->format_number($today_profit) . '</strong></span>';
                                        ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                      
                    <?php
					}
					?>  
               
				
                
                <!--Month-->        
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Income Vs Expense (%)
								- <strong style="color:#F00;"><?php if (isset($listing_header)) echo $listing_header; else echo ' <strong>' . date('F Y') . '</strong>'; ?></strong></h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>

								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content col-md-12">
							<!---->
							<div id="echart_pie" style="height:350px;"></div>
							<input type="hidden" value="<?php echo $total_expense; ?>"
								   id="total_expense">
							<input type="hidden" value="<?php echo $total_income; ?>"
								   id="total_income">
							<div class="clearfix"></div>
							<h3>
								<?php echo '<span class="label label-warning"> Expense : ' . $this->cart->format_number($total_expense) . '</span>'; ?>
							</h3>
							<h3>
								<?php echo '<span class="label label-success"> Income : ' . $this->cart->format_number($total_income) . '</span>'; ?>
							</h3>
							<h3>
								<?php
								$profit = $total_income - $total_expense;
								if ($profit < 0)
									echo '<span class="label label-info"> Estimated Profit : <strong style="color: red;">'
										. $this->cart->format_number($profit) . '</strong></span>';
								else
									echo '<span class="label label-info" > Estimated Profit : <strong style="color: green;">' . $this->cart->format_number($profit) . '</strong></span>';
								?>
							</h3>
						</div>
					</div>
				</div>
                
                
				<!--<div class="clearfix"></div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Category wise Expense and Income
								- <strong style="color:#F00;"><?php if (isset($listing_header)) echo $listing_header; else echo date('F Y'); ?></strong>
                            </h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>

								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content col-md-12">
							<div id="cat-expense-income"></div>
						</div>
					</div>
				</div>
                -->
                 <?php
							
				$qry_cat_income = $this->db->get_where('category', array('status' => 1, 'parent_id' => 0, 'cat_type'=>1));
				
				$cat_inc_chart_ ='';
				
				$inc_tot = 0;	
				
				$inc_cat_ = '';
				
				foreach ($qry_cat_income->result() as $qry_cat_res) 
				{
					$inc_cat_tot = 0;	
						
					foreach ($qry_income->result() as $qry_cat_inc_res) 
					{
						if ($qry_cat_inc_res->category == $qry_cat_res->id) 
						{
							$inc_cat_tot += $qry_cat_inc_res->amount;
						}
					}
					
					$inc_cat_child_tot = 0;
					
					$qry_cat_child = $this->db->get_where('category', array('status' => 1, 'parent_id' => $qry_cat_res->id ));

					foreach ($qry_cat_child->result() as $qry_cat_child_res) 
					{
						$inc_sub_cat_tot = 0; 
												
						foreach ($qry_income->result() as $qry_cat_inc_res) 
						{
							if ($qry_cat_inc_res->category == $qry_cat_child_res->id) 
							{
								$inc_cat_child_tot += $qry_cat_inc_res->amount;
								
								$inc_sub_cat_tot += $qry_cat_inc_res->amount;
							}
						}
						
						$cat_inc_chart_ .= "{ income: '" . $qry_cat_child_res->name . "', amount: " . $inc_sub_cat_tot . " },";	
					}
					
					$inc_cat_tot += $inc_cat_child_tot;					
				
					$cat_inc_chart_ .= "{ income: '" . $qry_cat_res->name . "', amount: " . $inc_cat_tot . " },";	
					
					$inc_tot += $inc_cat_tot; 	
					
					$inc_cat_ .= '<span class="label label-success"><strong>'.$qry_cat_res->name.'</strong> : ' . $this->cart->format_number($inc_cat_tot) . '</span> ';				
					
				}
				
				$inc_uncat = 0;
				
				foreach ($qry_income->result() as $qry_cat_inc_res) 
				{
					if( $qry_cat_inc_res->category == 0 || $qry_cat_inc_res->category =="" )
					{
						$inc_uncat += $qry_cat_inc_res->amount;
					}
				}
				
				$inc_cat_ .= '<span class="label label-info">Un-Categorised : ' . $this->cart->format_number($inc_uncat) . '</span> ';
				
				
				
				
				?>
                
                <div class="clearfix"></div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Category wise Income
								- <strong style="color:#F00;"><?php if (isset($listing_header)) echo $listing_header; else echo date('F Y'); ?></strong>
                            </h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>

								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content col-md-12">
							<div id="cat-income" style="min-height:500px; height:auto;"></div>
                            
                            <h4>
                            	<?php echo $inc_cat_;?>
                            </h4>
                            
                             <h3>
								<?php echo '<span class="label label-success">Category Based Total Income : ' . $this->cart->format_number($inc_tot) . '</span>'; ?>
                            </h3>
                            
						</div>
                       
                       
					</div>
				</div>
                
                 <?php
							
				$qry_cat_expense = $this->db->get_where('category', array('status' => 1, 'parent_id' => 0, 'cat_type'=>0));
				
				$cat_exp_chart_ ='';
				
				$exp_tot = 0;
				
				$exp_cat_ = '';
				
				foreach ($qry_cat_expense->result() as $qry_cat_res) 
				{					
					$exp_cat_tot = 0;					
					
					foreach ($qry_expense->result() as $qry_cat_exp_res) 
					{
						if ($qry_cat_exp_res->category == $qry_cat_res->id) 
						{
							$exp_cat_tot += $qry_cat_exp_res->amount;
						}
					}
					
					$exp_cat_child_tot = 0;
					
					$qry_cat_child = $this->db->get_where('category', array('status' => 1, 'parent_id' => $qry_cat_res->id ));

					foreach ($qry_cat_child->result() as $qry_cat_child_res) 
					{
						$exp_sub_cat_tot = 0; 
												
						foreach ($qry_expense->result() as $qry_cat_exp_res) 
						{
							if ($qry_cat_exp_res->category == $qry_cat_child_res->id) 
							{
								$exp_cat_child_tot += $qry_cat_exp_res->amount;
								
								$exp_sub_cat_tot += $qry_cat_exp_res->amount;
							}
						}
						
						$cat_exp_chart_ .= "{ expense: '" . $qry_cat_child_res->name . "', amount: " . $exp_sub_cat_tot . " },";	
					}
					
					$exp_cat_tot += $exp_cat_child_tot;					
				
					$cat_exp_chart_ .= "{ expense: '" . $qry_cat_res->name . "', amount: " . $exp_cat_tot . " },";	
					
					$exp_tot += $exp_cat_tot; 	
					
					$exp_cat_ .= '<span class="label label-warning">' . $qry_cat_res->name . ' : ' . $this->cart->format_number($exp_cat_tot) . '</span> ';	
					
				}
				
				$exp_uncat = 0;
				
				foreach ($qry_expense->result() as $qry_cat_exp_res) 
				{
					if( $qry_cat_exp_res->category == 0 || $qry_cat_exp_res->category =="" )
					{
						$exp_uncat += $qry_cat_exp_res->amount;
					}
				}
				
				$exp_cat_ .= '<span class="label label-info">Un-Categorised : ' . $this->cart->format_number($exp_uncat) . '</span> ';
				
				?>
                
                <div class="clearfix"></div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Category wise Expense
								- <strong style="color:#F00;"><?php if (isset($listing_header)) echo $listing_header; else echo date('F Y'); ?></strong>
                            </h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>

								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content col-md-12">
							<div id="cat-expense" style="min-height:500px; height:auto"></div>
                             <h4>
								<?php echo $exp_cat_; ?>
                            </h4>
                            
                             <h3>
								<?php echo '<span class="label label-warning">Category Based Total Expense : ' . $this->cart->format_number($exp_tot) . '</span>'; ?>
                            </h3>
						</div>
					</div>
				</div>
                
				 <!--Notes-->    
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Notes
								- <strong style="color:#F00;"><?php if (isset($listing_header)) echo $listing_header; else echo date('F Y'); ?></strong>
                            </h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content col-md-12" style="max-height: 500px; overflow: auto;">

							<!-- start accordion -->
							<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">

								<?php

								foreach ($qry_notes->result() as $qry_notes_res) {

									$date_ = date_create($qry_notes_res->date . ' ' . $qry_notes_res->time);

									echo ' 
                                                      <div class="panel">
                                                        <a class="panel-heading" role="tab" id="note_head_' . $qry_notes_res->id . '" data-toggle="collapse"
                                                           data-parent="#accordion" href="#note_' . $qry_notes_res->id . '" aria-expanded="false"
                                                           aria-controls="note_' . $qry_notes_res->id . '" 
                                                           ' . ($qry_notes_res->status == 1 ? 'style="background-color: rgba(38,185,154,.88); color:white;"' : 'style="background-color: rgba(231,76,60,.88); color:white;"') . '>
                                                            <h4 class="panel-title">' . $qry_notes_res->title . ' <small style="float: right;">(' . date_format(date_create($qry_notes_res->created_dt), "d-M-Y h:i A") . ') </small></h4>
                                                        </a>
                                                        <div id="note_' . $qry_notes_res->id . '" class="panel-collapse collapse" role="tabpanel"
                                                             aria-labelledby="note_head_' . $qry_notes_res->id . '">
                                                            <div class="panel-body">
                                                            
                                                            <span class="label label-primary"> ' . $qry_notes_res->title . '</span>
                                                            <hr style="margin-top: 2px; margin-bottom: 2px;" />
                                                            ' . $qry_notes_res->details . ' 
                                                            <hr style="margin-top: 2px; margin-bottom: 2px;" />
                                                            
                                                            ' . ($qry_notes_res->status == 1 ? '<span class="label label-success">Task Done</span>'
											: '<span class="label label-danger">Task Not Done</span>') . '
                                                            
                                                            <br />                                                            
                                                             created: ' . $this->m_config->get_user_name_by_id($qry_notes_res->created_by)
										. '(' . date_format(date_create($qry_notes_res->created_dt), "d-M-Y h:i A") . ') 
                    
                                                            </div>
                                                        </div>
                                                      </div>
                                                  ';
								}

								?>

								</table>

							</div>
							<!-- end of accordion -->

						</div>
					</div>
				</div>


				
			</div>
		</div>

	</div>

	<script>

		function load_overview_custom(from, to, type) 
		{
			redirect_custom_dashboard(from, to, type);
		}

		function redirect_custom_dashboard(from, to, type) 
		{
			var from_dt = from;
			var to_dt = to;

			var url = "<?php echo site_url("welcome/get_overview_custom"); ?>";
			var form = $('<form action="' + url + '" method="post">' +
				'<input type="text" name="from_dt" value="' + from_dt + '" />' +
				'<input type="text" name="to_dt" value="' + to_dt + '" />' +
				'<input type="text" name="type" value="' + type + '" />' +
				'</form>');
			$('body').append(form);
			form.submit();

		}

		function load_overview_custom_with_dates() 
		{
			$('#ModaldatePicker').modal('hide');
			load_overview_custom($("#date_from").val(), $("#date_to").val(), 'custom');
		}

		function expense_list_datepicker()  // custom listoing datepicker loader
		{ 
			$("#ModaldatePickerLabel").html('Choose Custom Date Range');
			$("#ModaldatePickerSubmitBtn").html('Load Expense Listings');
			$('#ModaldatePicker').modal('show');
			$("#ModaldatePickerSubmitBtn").attr("onclick", "load_overview_custom_with_dates()");
		}

		function add_new_expense_form() 
		{
			$("#myModalLabel").html('Add New Expense');
			$("#myModalBody").html('<div class="loader"></div>');
			$('#myModal').modal('show');			
			
			$.ajax({
				type: "post",
				url: "<?php echo site_url("config/ajax_load_form")?>/",
				data: {form_name: 'expense/add_new_expense_form'},
				success: function (html) {
					$("#myModalLabel").html('Add New Expense');
					$("#myModalBody").html(html);
					//$('#myModal').modal('show');
				},
				error: function (error) {
					alert('Someting Wrong Happend. Please Try Again.');
				}
			});
		}

		function add_new_income_form() 
		{			
			$("#myModalLabel").html('Add New Income');
			$("#myModalBody").html('<div class="loader"></div>');
			$('#myModal').modal('show');
			
			$.ajax({
				type: "post",
				url: "<?php echo site_url("config/ajax_load_form")?>/",
				data: {form_name: 'income/add_new_income_form'},
				success: function (html) {
					$("#myModalLabel").html('Add New Income');
					$("#myModalBody").html(html);
					//$('#myModal').modal('show');
				},
				error: function (error) {
					alert('Someting Wrong Happend. Please Try Again.');
				}
			});
		}

		$(document).ready(function () 
		{
			/*Morris.Bar({
				element: 'cat-expense-income',
				data: [
					<?php
					//echo $cat_inc_exp_chart;					
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b'],
				labels: ['Expense', 'Income'],
				barRatio: 0.4,
				barColors: ['#ff9421', '#1f8e15'],
				xLabelAngle: 0,
				resize: true
			});*/
			
			Morris.Bar({
				element: 'cat-income',
				data: [
					<?php
					echo $cat_inc_chart_;					
					?>
				],
				xkey: 'income',
				ykeys: ['amount'],
				labels: ['Amount'],
				barRatio: 0.4,
				barColors: ['#1f8e15'],
				xLabelAngle: 60,
				hideHover: 'auto',
				resize: true,
				
			});
			
			Morris.Bar({
				element: 'cat-expense',
				data: [
					<?php
					echo $cat_exp_chart_;					
					?>
				],
				xkey: 'expense',
				ykeys: ['amount'],
				labels: ['Amount'],
				barRatio: 0.4,
				barColors: ['#ff9421'],
				xLabelAngle: 60,
				hideHover: 'auto',
				resize: true,
				
				
			});
			
			
		});
		
		function sleep(milliseconds) {
		  var start = new Date().getTime();
		  for (var i = 0; i < 1e7; i++) {
			if ((new Date().getTime() - start) > milliseconds){
			  break;
			}
		  }
		}

	</script>
    
    
    