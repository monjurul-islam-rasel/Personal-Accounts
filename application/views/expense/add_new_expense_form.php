<?php
/**
 * Created by PhpStorm.
 * User: Rasel
 * Date: 7/23/2018
 * Time: 11:45 AM
 */

$qry_cat = $this->db->get_where('category', array('parent_id' => 0, 'status'=>1, 'cat_type'=> 0));

?>


<div class="x_panel">

    <div class="x_content">

        <!-- start form for validation -->
        <form id="demo-form" onchange="validate_form()" onkeyup="validate_form()">

            <?php

            if ($qry_cat->num_rows() > 0) {
                ?>

                <label for="category" title="Select Category or Sub Category">Select Category:</label>
                <select id="category" name="category" class="form-control select2_group"
                        title="Select Category or Sub Category">
                    <option value="">Select Category</option>
                    <?php

                    foreach ($qry_cat->result() as $qry_cat_res) {

                        echo ' <optgroup label="' . $qry_cat_res->name . '">';
                        echo '<option value="' . $qry_cat_res->id . '">' . $qry_cat_res->name . ' </option>';

                        $qry_child_cat = $this->db->get_where('category', array('parent_id' => $qry_cat_res->id, 'status'=>1));

                        if ($qry_child_cat->num_rows() > 0) {
                            foreach ($qry_child_cat->result() as $qry_child_cat_res) {
                                echo '<option value="' . $qry_child_cat_res->id . '"> ' . $qry_child_cat_res->name . ' <small>(' . $qry_cat_res->name . ')</small></option>';
                            }
                        }

                        echo '</optgroup>';

                    }

                    ?>
                </select>

                <?php
            }

            ?>

            <label for="amount">Amount * :</label>
            <input type="number" id="amount" class="form-control" name="amount" placeholder="Enter Amount" required/>
            <!--   €€€ or $$$ or ৳৳৳ or-->

            <label for="purpose">Purpose * :</label>
            <input type="text" id="purpose" class="form-control" name="purpose" placeholder="Enter Purpose" required/>


            <label for="details">Details :</label>
            <textarea id="details" required="required" class="form-control" name="details"
                      placeholder="Enter Details"></textarea>

            <label for="datetime">Date and Time * :</label>
            <input type="text" name="datetime" id="datetime" class="form-control datetime" value="<?php echo date('Y-m-d h:i A')?>">

            <label for="reference" title="Expense by or from whom">Expense Reference :</label>
            <input type="text" id="reference" class="form-control" name="reference" placeholder="Enter Reference"
                   required/>

            <label for="payment_status" title="Payment Status for this Expense">Transaction Status *:</label>
            <p>
                <select id="payment_status" name="payment_status" class="form-control">
                    <option value="">Select Transaction Status</option>
                    <option value="1" title="Payment Processed for this Expense">Payment Processed</option>
                    <option value="0" title="Payment Not Processed for this Expense">Payment Not Processed</option>
                </select>

            </p>

            <br/>

            <p id="form-error" style="color: red;"></p>

            <button disabled id="add_expense_submit_btn" style="float: right" type="button" class="btn btn-success"
                    onclick="create_expense()">Add Expense
            </button>

        </form>
        <!-- end form for validations -->

    </div>
</div>

<script>

    $('.datetime').datetimepicker({
        format: 'YYYY-MM-DD h:mm A'
    });

    function create_expense() {
        var category = $("#category").val();
        var amount = $("#amount").val();
        var purpose = $("#purpose").val();
        var details = $("#details").val();
        var datetime = $("#datetime").val();
        var reference = $("#reference").val();
        var payment_status = $("#payment_status").val();

        var fv = 1;

        if (amount == "") {
            fv = 0;
            $("#amount").css("border-color", "red");
        }
        else {
            $("#amount").css("border-color", "");
        }

        if (purpose == "") {
            fv = 0;
            $("#purpose").css("border-color", "red");
        }
        else {
            $("#purpose").css("border-color", "");
        }

        if (payment_status == "") {
            fv = 0;
            $("#payment_status").css("border-color", "red");
        }
        else {
            $("#payment_status").css("border-color", "");
        }

        if (fv == 1) {

            $.ajax({
                type: "post",
                url: "<?php echo site_url("expense/add_expense")?>",
                data: {
                    category: category,
                    amount: amount,
                    purpose: purpose,
                    details: details,
                    datetime: datetime,
                    reference: reference,
                    payment_status: payment_status
                },
                success: function (html) {
                    if (html == 1) {
                        alert('Expense Added Successfully.');
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

        var amount = $("#amount").val();
        var purpose = $("#purpose").val();
        var payment_status = $("#payment_status").val();

        var fv = 1;

        if (amount == "") {
            fv = 0;
            $("#amount").css("border-color", "red");
        }
        else {
            $("#amount").css("border-color", "");
        }

        if (purpose == "") {
            fv = 0;
            $("#purpose").css("border-color", "red");
        }
        else {
            $("#purpose").css("border-color", "");
        }

        if (payment_status == "") {
            fv = 0;
            $("#payment_status").css("border-color", "red");
        }
        else {
            $("#payment_status").css("border-color", "");
        }

        if (fv == 0) {
            $("#form-error").html('<span>Please Fill The Form Correctly.</span>');
            $("#add_expense_submit_btn").prop("disabled", true);


        }
        else {
            $("#form-error").html('');
            $("#add_expense_submit_btn").prop("disabled", false);
        }
    }
</script>



