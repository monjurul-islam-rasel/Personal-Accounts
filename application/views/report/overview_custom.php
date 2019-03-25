<?php
/**
 * Income overview view
 * Created by PhpStorm.
 * User: Rasel, SB TechValley ( https://www.sbtechvalley.com )
 * Date: 7/23/2018
 * Time: 11:45 AM
 */

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


<script>


	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});

    var table = $('.btn-table').DataTable({
          searching: false
       });
   

</script>







