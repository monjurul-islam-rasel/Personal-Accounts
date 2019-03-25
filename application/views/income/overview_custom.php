<?php
/**
 * Income overview view
 * Created by PhpStorm.
 * User: Rasel, SB TechValley ( https://www.sbtechvalley.com )
 * Date: 7/23/2018
 * Time: 11:45 AM
 */

$total_income = 0;

?>


<table id="btn-table" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>SL.</th>
        <th>Purpose ( Amount )<br/>Details <br/>Category</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>

    <?php $sl = 1;

    foreach ($qry_income->result() as $qry_income_res) {

        $date_ = date_create($qry_income_res->date . ' ' . $qry_income_res->time);
		
		$info= '<em>Created By - </em> <br />' . $this->m_config->get_user_name_by_id($qry_income_res->created_by)
				. '('.date_format(date_create($qry_income_res->created_dt ), "d-M-Y h:i A").') ';
		
		if($qry_income_res->updated_by!=NULL)
		{
			$info.= ' <br />							
					<em>Updated By - </em> <br />' . $this->m_config->get_user_name_by_id($qry_income_res->updated_by)
					. '('.date_format(date_create($qry_income_res->timestamp ), "d-M-Y h:i A").') ' ;
		}

        echo '
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
							  <p> <strong>Detail :</strong> ' . $qry_income_res->details . ' </p>
						  </div>
						  <div class="col-md-5 col-xs-12" >
							  <p><strong>Ref:</strong> ' . $qry_income_res->reference . '</p>
							  <p><strong>Cat:</strong> ' . $this->m_config->get_category_name_by_id($qry_income_res->category) . '</p>
						  </div>
					  </div>
				  </div>					
				</td> 
			   
				<td>
					
				<div class="col-md-12 col-xs-12">
				
				' . ($qry_income_res->payment_status == 1 ? '<span class="label label-success">Payment Processed</span>'
						: '<span class="label label-danger">Payment Not Processed</span>') . '
					 <br style="margin-top: 2px; margin-bottom: 2px;" />
					<span class="label label-info">' . date_format($date_, "D, d-M-Y h:i A") . '</span>
					
					<br style="margin-top: 2px; margin-bottom: 2px;" />
					<button class="btn btn-warning btn-xs" onclick="edit_income(' . $qry_income_res->id . ')">Edit</button>
					<button class="btn btn-Danger btn-xs" onclick="delete_income(' . $qry_income_res->id . ')">Delete</button>			
					
					
				</div>		
							   
					
				</td>
				
			   
			  </tr>
			';
        $sl++;

        $total_income += $qry_income_res->amount; // acquire all income
    }

    ?>

    </tbody>
</table>

<hr/>
             
                <div class="col-md-12" style="float: right; text-align: right;" id="print_button">                    
                    <div button class="btn btn-primary" onclick="print_window()">
                        <i class="fa fa-print"></i> Print
                    </div>
                </div>
                
                  <div class="clearfix"></div>

                <h3>
                    Total Income = <?php echo $this->cart->format_number($total_income); ?>
                </h3>


<script>

	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});

    var table = $('#btn-table').DataTable();
    var buttons = new $.fn.dataTable.Buttons(table, {
        buttons: [
            {
                extend: "copy",
                className: "btn-sm"
            },
            {
                extend: "csv",
                className: "btn-sm"
            },
            {
                extend: "excel",
                className: "btn-sm"
            },
            {
                extend: "pdfHtml5",
                className: "btn-sm"
            },
            {
                extend: "print",
                className: "btn-sm"
            }
        ]
    }).container().appendTo($('#btn-table-buttons'));

</script>







