<?php
/**
 * Notes overview view
 * Created by PhpStorm.
 * User: Rasel, SB TechValley ( https://www.sbtechvalley.com )
 * Date: 7/23/2018
 * Time: 11:45 AM
 */
$total_notes = 0;
?>

<table id="btn-table" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>SL.</th>
            <th>Title <br/>
                Details </th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
<?php
$sl = 1;
foreach ($qry_notes->result() as $qry_notes_res) {

    $date_ = date_create($qry_notes_res->date . ' ' . $qry_notes_res->time);

    $info = '<em>Created By - </em> <br />' . $this->m_config->get_user_name_by_id($qry_notes_res->created_by)
            . '(' . date_format(date_create($qry_notes_res->created_dt), "d-M-Y h:i A") . ') ';

    if ($qry_notes_res->updated_by != NULL) {
        $info .= ' <br />							
						<em>Updated By - </em> <br />' . $this->m_config->get_user_name_by_id($qry_notes_res->updated_by)
                . '(' . date_format(date_create($qry_notes_res->timestamp), "d-M-Y h:i A") . ') ';
    }



    echo '
			 <tr id="' . $qry_notes_res->id . '">
				
				<td>
				' . $sl . '.
			   
				</td>
				
	 			<td>  							
				  <div class="x_content">
					  <div class="col-md-12 col-xs-12">
						  <h2 style="text-transform: capitalize" title="Task Title"> 
							  ' . $qry_notes_res->title . '
							  <sup data-toggle="tooltip" data-html="true" title="' . $info . '">
								  <i class="fa fa-info-circle"></i>
								</sup> 
							  
						  </h2>
					  </div>
					  
					  <div class="x_content"  style="background: #fdf9f9;">
						  <div class="col-md-7 col-xs-12" >
							  <p> <strong>Detail :</strong> ' . $qry_notes_res->details . ' </p>
						  </div>
						  <div class="col-md-5 col-xs-12" >
							  <p><strong>Ref:</strong> ' . $qry_notes_res->reference . '</p>
							  
						  </div>
					  </div>
				  </div>					
				</td> 
			   
				<td>
					
				<div class="col-md-12 col-xs-12">
				
				' . ($qry_notes_res->status == 1 ? '<span class="label label-success">Task Done</span>' : '<span class="label label-danger">Task Not Done</span>') . '
					 <br style="margin-top: 2px; margin-bottom: 2px;" />
					<span class="label label-info">' . date_format($date_, "D, d-M-Y h:i A") . '</span>
					
					<br style="margin-top: 2px; margin-bottom: 2px;" />
					<button class="btn btn-warning btn-xs" onclick="edit_notes(' . $qry_notes_res->id . ')">Edit</button>
					<button class="btn btn-Danger btn-xs" onclick="delete_notes(' . $qry_notes_res->id . ')">Delete</button>				
					
				</div>
				
				</td>
				
			  </tr>
			';

    $sl++;
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