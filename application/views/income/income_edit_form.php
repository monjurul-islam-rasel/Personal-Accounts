<?php
/**
 * Created by PhpStorm.
 * User: Rasel, SB TechValley ( https://www.sbtechvalley.com )
 * Date: 7/23/2018
 * Time: 11:45 AM
 */

$qry_cat = $this->db->get_where('category', array('parent_id' => 0, 'status'=>1, 'cat_type'=> 1));
//$qry_cat = $this->db->get_where('category', array('parent_id' => 0, 'user_id' => $this->tank_auth->get_user_id()));

$qry_income_to_edit = $this->db->get_where('income_list', array('id' => $this->input->post('id')));
//$qry_income_to_edit = $this->db->get_where('income_list', array('id' => $this->input->post('id'), 'user_id'=>$this->tank_auth->get_user_id()));

if ($qry_income_to_edit->num_rows() > 0) {

    $qry_income_to_edit_res = $qry_income_to_edit->row();

    ?>

    <div class="x_panel panel-danger">

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

                            if($qry_cat_res->id== $qry_income_to_edit_res->category)
                            {
                                echo '<option selected value="' . $qry_cat_res->id . '">' . $qry_cat_res->name . ' </option>';
                            }
                            else {
                                echo '<option value="' . $qry_cat_res->id . '">' . $qry_cat_res->name . ' </option>';
                            }

                            $qry_child_cat = $this->db->get_where('category', array('parent_id' => $qry_cat_res->id, 'status'=>1));
                            //$qry_child_cat = $this->db->get_where('category', array('parent_id' => $qry_cat_res->id, 'user_id' => $this->tank_auth->get_user_id()));

                            if ($qry_child_cat->num_rows() > 0) {
                                foreach ($qry_child_cat->result() as $qry_child_cat_res) {
                                    if($qry_child_cat_res->id== $qry_income_to_edit_res->category)
                                    {
                                        echo '<option selected value="' . $qry_child_cat_res->id . '"> ' . $qry_child_cat_res->name . ' <small>(' . $qry_cat_res->name . ')</small></option>';

                                    }
                                    else {
                                        echo '<option value="' . $qry_child_cat_res->id . '"> ' . $qry_child_cat_res->name . ' <small>(' . $qry_cat_res->name . ')</small></option>';
                                    }
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
                <input type="number" id="amount" class="form-control" name="amount" placeholder="Enter Amount"
                       value="<?php echo $qry_income_to_edit_res->amount; ?>" required/>
                <input type="hidden" id="income_id" class="form-control" name="income_id"
                       value="<?php echo $qry_income_to_edit_res->id; ?>" required/>
                <!--   €€€ or $$$ or ৳৳৳ or-->

                <label for="purpose">Purpose * :</label>
                <input type="text" id="purpose" class="form-control" name="purpose" placeholder="Enter Purpose"
                       value="<?php echo $qry_income_to_edit_res->purpose; ?>" required/>


                <label for="details">Details :</label>
                <textarea id="details" required="required" class="form-control" name="details"
                          placeholder="Enter Details"><?php echo $qry_income_to_edit_res->details; ?></textarea>

                <label for="datetime">Date and Time * :</label>
                <input type="text" name="datetime" id="datetime" class="form-control datetime"
                       value="<?php echo $qry_income_to_edit_res->date.' '.$qry_income_to_edit_res->time; ?>" >

                <label for="reference" title="Income by or from whom">Income Reference :</label>
                <input type="text" id="reference" class="form-control" name="reference" placeholder="Enter Reference"
                       value="<?php echo $qry_income_to_edit_res->reference; ?>" required/>

                <label for="payment_status" title="Payment Status for this Income">Transaction Status *:</label>
                <p>
                    <select id="payment_status" name="payment_status" class="form-control">
                        <option value="">Select Transaction Status</option>
                        <option <?php if($qry_income_to_edit_res->payment_status==1) echo 'selected'; ?> value="1" title="Payment Processed for this Income">Payment Processed</option>
                        <option <?php if($qry_income_to_edit_res->payment_status==0) echo 'selected'; ?> value="0" title="Payment Not Processed for this Income">Payment Not Processed</option>
                    </select>

                </p>

                <br/>

                <p id="form-error" style="color: red;"></p>

                <button id="update_income_submit_btn" style="float: right" type="button" class="btn btn-success"
                        onclick="update_income()">Update Income
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

    function update_income() {

        var income_id = $("#income_id").val();

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
                url: "<?php echo site_url("income/update_income")?>",
                data: {
                    income_id: income_id,
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
                        alert('Income Updated Successfully.');
                        location.reload('<?php echo site_url("income")?>');
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
            $("#update_income_submit_btn").prop("disabled", true);


        }
        else {
            $("#form-error").html('');
            $("#update_income_submit_btn").prop("disabled", false);
        }
    }


</script>



