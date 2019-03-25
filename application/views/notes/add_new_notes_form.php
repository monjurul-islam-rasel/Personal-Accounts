<?php
/**
 * Created by PhpStorm.
 * User: Rasel
 * Date: 7/23/2018
 * Time: 11:45 AM
 */

$qry_cat = $this->db->get_where('category', array('parent_id' => 0, 'status'=>1));

?>


<div class="x_panel">

    <div class="x_content">

        <!-- start form for validation -->
        <form id="demo-form" onchange="validate_form()" onkeyup="validate_form()">



            <label for="title">Title * :</label>
            <input type="text" id="title" class="form-control" name="title" placeholder="Enter Note Title" required/>


            <label for="details">Details :</label>
            <textarea id="details" required="required" class="form-control" name="details"
                      placeholder="Enter Details"></textarea>

            <label for="datetime">Date and Time * :</label>
            <input type="text" name="datetime" id="datetime" class="form-control datetime" value="<?php echo date('Y-m-d h:i A')?>">

            <label for="reference" title="Notes by or from whom">Notes Reference :</label>
            <input type="text" id="reference" class="form-control" name="reference" placeholder="Enter Reference"
                   required/>

            <label for="status" title="Payment Status for this Notes">Transaction Status *:</label>
            <p>
                <select id="status" name="status" class="form-control">
                    <option value="">Select Note Status</option>
                    <option value="1" title="Task Done for this Note">Task Done</option>
                    <option value="0" title="Task Not Done for this Note">Task Not Done</option>
                </select>

            </p>

            <br/>

            <p id="form-error" style="color: red;"></p>

            <button disabled id="add_notes_submit_btn" style="float: right" type="button" class="btn btn-success"
                    onclick="create_notes()">Add Notes
            </button>

        </form>
        <!-- end form for validations -->

    </div>
</div>

<script>

    $('.datetime').datetimepicker({
        format: 'YYYY-MM-DD h:mm A'
    });

    function create_notes() {

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
                url: "<?php echo site_url("notes/add_notes")?>",
                data: {
                    title: title,
                    details: details,
                    datetime: datetime,
                    reference: reference,
                    status: status
                },
                success: function (html) {
                    if (html == 1) {
                        alert('Notes Added Successfully.');
                        location.reload();
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
            $("#add_notes_submit_btn").prop("disabled", true);


        }
        else {
            $("#form-error").html('');
            $("#add_notes_submit_btn").prop("disabled", false);
        }
    }
</script>



