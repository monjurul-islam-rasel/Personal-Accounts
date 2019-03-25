<?php
/**
 * Created by PhpStorm.
 * User: Rasel, SB TechValley ( https://www.sbtechvalley.com )
 * Date: 7/23/2018
 * Time: 11:45 AM
 */

$qry_cat = $this->db->get_where('category', array('parent_id' => 0, 'status'=>1));
//$qry_cat = $this->db->get_where('category', array('parent_id' => 0, 'user_id' => $this->tank_auth->get_user_id()));

$qry_notes_to_edit = $this->db->get_where('notes', array('id' => $this->input->post('id')));
//$qry_notes_to_edit = $this->db->get_where('notes', array('id' => $this->input->post('id'), 'user_id'=>$this->tank_auth->get_user_id()));

if ($qry_notes_to_edit->num_rows() > 0) {

    $qry_notes_to_edit_res = $qry_notes_to_edit->row();

    ?>

    <div class="x_panel panel-danger">

        <div class="x_content">

            <!-- start form for validation -->
            <form id="demo-form" onchange="validate_form()" onkeyup="validate_form()">

                <label for="title">Title * :</label>
                <input type="text" id="title" class="form-control" name="title" placeholder="Enter Title"
                       value="<?php echo $qry_notes_to_edit_res->title; ?>" required/>

                <input type="hidden" id="notes_id" class="form-control" name="notes_id"
                       value="<?php echo $qry_notes_to_edit_res->id; ?>" required/>

                <label for="details">Details :</label>
                <textarea id="details" required="required" class="form-control" name="details"
                          placeholder="Enter Details"><?php echo $qry_notes_to_edit_res->details; ?></textarea>

                <label for="datetime">Date and Time * :</label>
                <input type="text" name="datetime" id="datetime" class="form-control datetime"
                       value="<?php echo $qry_notes_to_edit_res->date.' '.$qry_notes_to_edit_res->time; ?>" >

                <label for="reference" title="Notes by or from whom">Notes Reference :</label>
                <input type="text" id="reference" class="form-control" name="reference" placeholder="Enter Reference"
                       value="<?php echo $qry_notes_to_edit_res->reference; ?>" required/>

                <label for="status" title="Payment Status for this Notes">Transaction Status *:</label>
                <p>
                    <select id="status" name="status" class="form-control">
                        <option value="">Select Note Status</option>
                        <option <?php if($qry_notes_to_edit_res->status==1) echo 'selected'; ?> value="1" title="Task Done for this Note">Task Done</option>
                        <option <?php if($qry_notes_to_edit_res->status==0) echo 'selected'; ?> value="0" title="Task Not Done for this Notes">Task Not Done</option>
                    </select>

                </p>

                <br/>

                <p id="form-error" style="color: red;"></p>

                <button id="update_notes_submit_btn" style="float: right" type="button" class="btn btn-success"
                        onclick="update_notes()">Update Notes
                </button>

            </form>
            <!-- end form for validations -->

        </div>
    </div>

    <?php
} else {
    echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <strong>Something Wrong Happens. </strong> Please Try Again.
        </div> ';
}
?>

<script>

    $('.datetime').datetimepicker({
        format: 'YYYY-MM-DD h:mm A'
    });

    function update_notes() {

        var notes_id = $("#notes_id").val();

        var title = $("#title").val();
        var details = $("#details").val();
        var datetime = $("#datetime").val();
        var reference = $("#reference").val();
        var status = $("#status").val();

        var fv = 1;

        if (title == "") {
            fv = 0;
            $("#title").css("border-color", "red");
        }
        else {
            $("#title").css("border-color", "");
        }

        if (status == "") {
            fv = 0;
            $("#status").css("border-color", "red");
        }
        else {
            $("#status").css("border-color", "");
        }

        if (fv == 1) {

            $.ajax({
                type: "post",
                url: "<?php echo site_url("notes/update_notes")?>",
                data: {
                    notes_id: notes_id,
                    title: title,
                    details: details,
                    datetime: datetime,
                    reference: reference,
                    status: status
                },
                success: function (html) {
                    if (html == 1) {
                        alert('Notes Updated Successfully.');
                        location.reload('<?php echo site_url("notes")?>');
                    }
                    else {
                        alert('Error Occoured. Please Try Again');
                    }
                }
            });
        }
        else {
            $("#form-error").html('<span>Please Fill The Form Correctly.</span>');
        }
    }

    function validate_form() {

        var amount = $("#title").val();
        var status = $("#status").val();

        var fv = 1;

        if (title == "") {
            fv = 0;
            $("#title").css("border-color", "red");
        }
        else {
            $("#title").css("border-color", "");
        }

        if (status == "") {
            fv = 0;
            $("#status").css("border-color", "red");
        }
        else {
            $("#status").css("border-color", "");
        }

        if (fv == 0) {
            $("#form-error").html('<span>Please Fill The Form Correctly.</span>');
            $("#update_notes_submit_btn").prop("disabled", true);


        }
        else {
            $("#form-error").html('');
            $("#update_notes_submit_btn").prop("disabled", false);
        }
    }


</script>



