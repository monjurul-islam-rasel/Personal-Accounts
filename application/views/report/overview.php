<?php
   /**
    * Income overview view
    * Created by PhpStorm.
    * User: Rasel, SB TechValley ( https://www.sbtechvalley.com )
    * Date: 7/23/2018
    * Time: 11:45 AM
    */
   ?>

<div class="clearfix"></div>
<?php 
	
	$total_income = 0;
	$income_tbl = '';
	$total_expense = 0;
	$expense_tbl = '';
	$sl = 1;
	foreach ($qry_income->result() as $qry_income_res) 
	{
		$date_ = date_create($qry_income_res->date . ' ' . $qry_income_res->time);
		$info= '<em>Created By - </em> <br />' . $this->m_config->get_user_name_by_id($qry_income_res->created_by)
		. '('.date_format(date_create($qry_income_res->created_dt ), "d-M-Y h:i A").') ';
		if($qry_income_res->updated_by!=NULL)
		{
		$info.= ' <br />							
		<em>Updated By - </em> <br />' . $this->m_config->get_user_name_by_id($qry_income_res->updated_by)
		. '('.date_format(date_create($qry_income_res->timestamp ), "d-M-Y h:i A").') ' ;
		}
		$income_tbl.= '
		<tr id="' . $qry_income_res->id . '">
		   <td>
			  ' . $sl . '.
		   </td>
		   <td>
			  <div class="x_content">
				 <div class="col-md-12 col-xs-12">
					<h2 style="text-transform: capitalize" title="Purpose"> 
					   ' . $qry_income_res->purpose . '
					   <sup data-toggle="tooltip" data-html="true" title="'.$info.'">
					   <i class="fa fa-info-circle"></i>
					   </sup>
					   <span title="Amount" style="float:right;" class="badge badge-success">' . $this->cart->format_number($qry_income_res->amount) . '</span>		  
					</h2>
				 </div>
				 <div class="x_content"  style="background: #fdf9f9;">
					<div class="col-md-7 col-xs-12" >
					   <strong>Detail :</strong> ' . $qry_income_res->details . ' </p>
					   ' . ($qry_income_res->payment_status == 1 ? '<span class="label label-success">Payment Processed</span>'
					   : '<span class="label label-danger">Payment Not Processed</span>') . '
					   <br style="margin-top: 2px; margin-bottom: 2px;" />
					   <span class="label label-info">' . date_format($date_, "D, d-M-Y h:i A") . '</span>
					</div>
					<div class="col-md-5 col-xs-12" >
					   <p><strong>Ref:</strong> ' . $qry_income_res->reference . '</p>
					   <p><strong>Cat:</strong> ' . $this->m_config->get_category_name_by_id($qry_income_res->category) . '</p>
					</div>
				 </div>
			  </div>
		   </td>
		</tr>
		';
		$sl++;
		$total_income += $qry_income_res->amount; // acquire all income
	}
	$sl = 1;
	foreach ($qry_expense->result() as $qry_expense_res) 
	{
		$date_ = date_create($qry_expense_res->date . ' ' . $qry_expense_res->time);
		$info= '<em>Created By - </em> <br />' . $this->m_config->get_user_name_by_id($qry_expense_res->created_by)
		. '('.date_format(date_create($qry_expense_res->created_dt ), "d-M-Y h:i A").') ';
		if($qry_expense_res->updated_by!=NULL)
		{
		$info.= ' <br />							
		<em>Updated By - </em> <br />' . $this->m_config->get_user_name_by_id($qry_expense_res->updated_by)
		. '('.date_format(date_create($qry_expense_res->timestamp ), "d-M-Y h:i A").') ' ;
		}
		$expense_tbl.= '
		<tr id="' . $qry_expense_res->id . '">
		   <td>
			  ' . $sl . '.
		   </td>
		   <td>
			  <div class="x_content">
				 <div class="col-md-12 col-xs-12">
					<h2 style="text-transform: capitalize" title="Purpose"> 
					   ' . $qry_expense_res->purpose . '
					   <sup data-toggle="tooltip" data-html="true" title="'.$info.'">
					   <i class="fa fa-info-circle"></i>
					   </sup>
					   <span title="Amount" style="float:right;" class="badge badge-success">' . $this->cart->format_number($qry_expense_res->amount) . '</span>		  
					</h2>
				 </div>
				 <div class="x_content"  style="background: #fdf9f9;">
					<div class="col-md-7 col-xs-12" >
					   <p> <strong>Detail :</strong> ' . $qry_expense_res->details . ' </p>
					   ' . ($qry_expense_res->payment_status == 1 ? '<span class="label label-success">Payment Processed</span>'
					   : '<span class="label label-danger">Payment Not Processed</span>') . '
					   <br style="margin-top: 2px; margin-bottom: 2px;" />
					   <span class="label label-info">' . date_format($date_, "D, d-M-Y h:i A") . '</span>
					</div>
					<div class="col-md-5 col-xs-12" >
					   <p><strong>Ref:</strong> ' . $qry_expense_res->reference . '</p>
					   <p><strong>Cat:</strong> ' . $this->m_config->get_category_name_by_id($qry_expense_res->category) . '</p>
					</div>
				 </div>
			  </div>
		   </td>
		</tr>
		';
		$sl++;
		$total_expense += $qry_expense_res->amount; // acquire all expense
	}
	
?>
                  
<div class="x_panel">
  <div class="x_title">
    <h2 id="listing_header">
      <?php if (isset($listing_header)) echo $listing_header; else echo 'All Income - <strong style="color:#F00;"> ' . date('F-Y').'</strong>'; ?>
    </h2>
    <ul class="nav navbar-left panel_toolbox" style="float: left !important;">
      <?php
               $datestring = date('Y-m-d') . ' first day of last month';
               $dt = date_create($datestring);
               ?>
      <li style="width:20px;"> &nbsp;&nbsp;&nbsp; </li>
      <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-danger dropdown-toggle btn-sm" type="button" aria-expanded="false"> Change Date <i class="fa fa-calendar"></i> <span class="caret"></span> </button>
        <ul class="dropdown-menu">
          <li><a href="#"
                     onclick="load_report_custom('<?php echo date('Y-m'); ?>', '<?php echo date('Y-m'); ?>', 'current_m')"> Current Month </a> </li>
          <li><a href="#"
                     onclick="load_report_custom('<?php echo $dt->format('Y-m'); ?>', '<?php echo $dt->format('Y-m'); ?>','previous_m')"> Previous Month</a> </li>
          <li><a href="#"
                     onclick="load_report_custom('<?php echo date('Y'); ?>', '<?php echo date('Y'); ?>', 'current_y')"> Current Year</a> </li>
          <li><a href="#"
                     onclick="load_report_custom('<?php echo date("Y", strtotime("-1 year")); ?>', '<?php echo date("Y", strtotime("-1 year")); ?>', 'previous_y')"> Previous
            Year</a> </li>
          <li><a href="#"
                     onclick="load_report_custom('<?php echo 'ALL'; ?>', '<?php echo 'ALL'; ?>', '<?php echo 'ALL'; ?>')"> List All</a> </li>
          <li><a href="#" onclick="report_list_datepicker()">Custom range</a> </li>
        </ul>
      </div>
    </ul>
    <div class="clearfix"></div>
  </div>
  <div class="x_content" id="record_listings">
     <div  class="col-md-6" style="padding:5px; border:1px solid #64a91f42;">
      <h3><strong style="color:#4caf50;">Income Listings ( আয় তালিকা )</strong></h3>
      
      <div class="col-md-12" style="float: left; text-align: right; padding:10px;">
        <h3> Total Income = <?php echo $this->cart->format_number($total_income); ?> </h3>        
      </div>
      
      <hr />
      <table class="table table-striped table-bordered btn-table">
        <thead>
          <tr>
            <th>SL.</th>
            <th>Purpose ( Amount )<br/>
              Details <br/>
              Category</th>
          </tr>
        </thead>
        <tbody>
           <?php echo $income_tbl; ?>
        </tbody>
      </table>
    </div>
    <div  class="col-md-6" style="padding:5px; border:1px solid #ff572240;">
      <h3><strong style="color:#FF5722;;">Expense Listings ( ব্যয় তালিকা ) </strong></h3>
       <div class="col-md-12" style="float: left; text-align: right; padding:10px;">        
        <h3> Total Expense = <?php echo $this->cart->format_number($total_expense); ?> </h3>
      </div>
      <hr />
      <table class="table table-striped table-bordered btn-table">
        <thead>
          <tr>
            <th>SL.</th>
            <th>Purpose ( Amount )<br/>
              Details <br/>
              Category</th>
          </tr>
        </thead>
        <tbody>
           <?php echo $expense_tbl; ?>
        </tbody>
      </table>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12" style="float: right; text-align: right;" id="print_button">
      <div class="btn btn-primary" onclick="print_window()"> <i class="fa fa-print"></i> Print </div>
    </div>
  </div>
</div>
<input type="hidden" id="from_dt" value="<?php echo date('Y-m'); ?>">
<input type="hidden" id="to_dt" value="<?php echo date('Y-m'); ?>">
<input type="hidden" id="type" value="current_m">
<script>             
   function print_window(  )
   {
	  
       var from_dt = $("#from_dt").val();
       var to_dt   = $("#to_dt").val();
       var type    = $("#type").val();
       
       var url = "<?php echo site_url("reports/print_report_custom"); ?>";
	   var form = $('<form action="' + url + '" method="post">' +
	   '<input type="text" name="from_dt" value="' + from_dt + '" />' +
	   '<input type="text" name="to_dt" value="' + to_dt + '" />' +
	   '<input type="text" name="type" value="' + type + '" />' +
	   '</form>');
	   $('body').append(form);
	   form.submit();
      
   }
   
</script> 
<script>
   function load_report_custom(from, to, type) {
       
       var from_dt = from;
       var to_dt = to;
       
   	   $("#record_listings").html('<div class="loader"></div>');   
   
       $.ajax({
           type: "post",
           url: "<?php echo site_url("reports/get_report_custom")?>/",
           data: {from_dt: from_dt, to_dt: to_dt, type: type},
           dataType: "json",
           success: function (resp) {
               if (resp["error"] == 0) {
                   $("#record_listings").html(resp["content"]);
                   $("#listing_header").html(resp["listing_header"]);
                   
                   $("#from_dt").val(resp["from_dt"]);
                   
                   $("#to_dt").val(resp["to_dt"]);
                   
                   $("#type").val(resp["type"]);
               }
               else {
                   alert('Please Reload Page and Try Again');
               }
           },
           error: function (error) {		
   
               alert('Someting Wrong Happend. Please Try Again.');
           }
       });
   
   }
   
   function load_report_custom_with_dates() {
       $('#ModaldatePicker').modal('hide');
       load_report_custom($("#date_from").val(), $("#date_to").val(), 'custom');
   }
   
   function report_list_datepicker() { // custom listoing datepicker loader
       $("#ModaldatePickerLabel").html('Choose Custom Date Range');
       $("#ModaldatePickerSubmitBtn").html('Load Income Listings');
   
       $('#ModaldatePicker').modal('show');
   
       $("#ModaldatePickerSubmitBtn").attr("onclick", "load_report_custom_with_dates()");
   
   }
   
 
   $(document).ready(function () {
       $('.btn-table').DataTable({
          searching: false
       });
   });
   
   
</script>
<style>



</style>
