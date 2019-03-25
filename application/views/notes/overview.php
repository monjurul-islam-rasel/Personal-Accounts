<?php
/**
 * Notes overview view
 * Created by PhpStorm.
 * User: Rasel, SB TechValley ( https://www.sbtechvalley.com )
 * Date: 7/23/2018
 * Time: 11:45 AM
 */
?>

<div class="clearfix"></div>
<?php
$total_notes = 0;
?>
<div class="row" id="do_not_print" >

    <div class="x_panel" >
        <div class="x_title">
            <h2 id="listing_header">
<?php if (isset($listing_header)) echo $listing_header;
else echo 'All Notes -' . date('F-Y'); ?>
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
                               onclick="load_notes_custom('<?php echo date('Y-m'); ?>', '<?php echo date('Y-m'); ?>', 'current_m')"> Current Month </a></li>
                        <li><a href="#"
                               onclick="load_notes_custom('<?php echo $dt->format('Y-m'); ?>', '<?php echo $dt->format('Y-m'); ?>', 'previous_m')"> Previous Month</a> </li>
                        <li><a href="#"
                               onclick="load_notes_custom('<?php echo date('Y'); ?>', '<?php echo date('Y'); ?>', 'current_y')"> Current Year</a> </li>
                        <li><a href="#"
                               onclick="load_notes_custom('<?php echo date("Y", strtotime("-1 year")); ?>', '<?php echo date("Y", strtotime("-1 year")); ?>', 'previous_y')"> Previous
                                Year</a> </li>
                        <li><a href="#"
                               onclick="load_notes_custom('<?php echo 'ALL'; ?>', '<?php echo 'ALL'; ?>', '<?php echo 'ALL'; ?>')"> List All</a> </li>
                        <li><a href="#" onclick="notes_list_datepicker()">Custom range</a> </li>
                    </ul>
                </div>
            </ul>
            <ul class="nav navbar-right panel_toolbox" style="float: right !important; margin-top:5px;">
                <a href="#" onclick="add_new_notes_form()" class="btn btn-primary btn-sm"><i
                        class="fa fa-plus"></i> Add New Notes </a>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content" id="record_listings">
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
                
                var url = "<?php echo site_url("notes/print_notes_custom"); ?>";
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


    function print_content()
    {
        $("#do_not_print").css("display", "none");

        $("#do_print").css("display", "block");

        window.print();

        $("#do_not_print").css("display", "block");

        $("#do_print").css("display", "none");

    }


    function load_notes_custom(from, to, type) {
        var from_dt = from;

        var to_dt = to;

        $("#myModalLabel").html('Loading Please Wait');
        $("#myModalBody").html('<div class="loader"></div>');
        $('#myModal').modal('show');

        $.ajax({
            type: "post",
            url: "<?php echo site_url("notes/get_notes_custom") ?>/",
            data: {from_dt: from_dt, to_dt: to_dt, type: type},
            dataType: "json",
            success: function (resp) {

                $('#myModal').modal('hide');

                if (resp["error"] == 0) {
                    $("#record_listings").html(resp["content"]);

                    $("#listing_header").html(resp["listing_header"]);

                    $("#from_dt").val(resp["from_dt"]);
                        
                        $("#to_dt").val(resp["to_dt"]);
                        
                        $("#type").val(resp["type"]);


                } else {
                    alert('Please Reload Page and Try Again');
                }

            },
            error: function (error) {
                $('#myModal').modal('hide');
                alert('Someting Wrong Happend. Please Try Again.');
            }
        });

    }

    function load_notes_custom_with_dates() {
        $('#ModaldatePicker').modal('hide');
        load_notes_custom($("#date_from").val(), $("#date_to").val(), 'custom');
    }

    function notes_list_datepicker() { // custom listoing datepicker loader
        $("#ModaldatePickerLabel").html('Choose Custom Date Range');
        $("#ModaldatePickerSubmitBtn").html('Load Notes Listings');

        $('#ModaldatePicker').modal('show');

        $("#ModaldatePickerSubmitBtn").attr("onclick", "load_notes_custom_with_dates()");

    }


    function add_new_notes_form() {

        $("#myModalLabel").html('Loading Please Wait');
        $("#myModalBody").html('<div class="loader"></div>');
        $('#myModal').modal('show');

        $.ajax({
            type: "post",
            url: "<?php echo site_url("config/ajax_load_form") ?>/",
            data: {form_name: 'notes/add_new_notes_form'},
            success: function (html) {
                $("#myModalLabel").html('Add New Notes');
                $("#myModalBody").html(html);
                //$('#myModal').modal('show');
            },
            error: function (error) {
                alert('Someting Wrong Happend. Please Try Again.');
            }
        });
    }

    function edit_notes(id) {

        $("#myModalLabel").html('Loading Please Wait');
        $("#myModalBody").html('<div class="loader"></div>');
        $('#myModal').modal('show');

        $.ajax({
            type: "post",
            url: "<?php echo site_url("config/ajax_load_form") ?>/",
            data: {form_name: 'notes/notes_edit_form', id: id},
            success: function (html) {
                $("#myModalLabel").html('Edit/Update Notes');
                $("#myModalBody").html(html);
                //$('#myModal').modal('show');
            },
            error: function (error) {
                alert('Someting Wrong Happend. Please Try Again.');
            }
        });
    }

    function delete_notes(notes_id) {

        var r = confirm("Are You Sure? It can't be undone!!");
        if (r == true) {

            $.ajax({
                type: "post",
                url: "<?php echo site_url("notes/delete_notes") ?>",
                data: {notes_id: notes_id},
                success: function (html) {
                    if (html == 1) {
                        alert('Deleted Successfully');

                        location.reload('<?php echo site_url("notes") ?>');
                    } else {
                        alert(html);
                    }
                }
            });

        }
    }
$('#datatable-keytable').DataTable({
        keys: true
    });

</script> 
