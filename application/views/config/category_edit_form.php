<?php
/**
 * Created by PhpStorm.
 * User: Rasel, SB TechValley ( https://www.sbtechvalley.com )
 * Date: 7/23/2018
 * Time: 11:45 AM
 */



$qry_cat_to_edit = $this->db->get_where('category', array('id' => $this->input->post('id')));



if ($qry_cat_to_edit->num_rows() > 0) {

    $qry_cat_to_edit_res = $qry_cat_to_edit->row();
	
	if($qry_cat_to_edit_res->cat_type == 1)
	{
		$cat_type = 'Income';
		$bg = '#8eeb8f40';
	}
	else
	{
		$cat_type = 'Expense';
		$bg = '#f0ad4e26';
	}
	
	$qry_cat = $this->db->get_where('category', array('parent_id' => 0, 'cat_type'=> $qry_cat_to_edit_res->cat_type ));

    ?>

    <div class="x_panel">

        <div class="x_content" style="background: <?php echo $bg; ?> ;">
        
        

            <!-- start form for validation -->
            <form id="demo-form" data-parsley-validate>

                <?php

                if ($qry_cat->num_rows() > 0) {


                    if ($this->db->get_where('category', array('parent_id' => $qry_cat_to_edit_res->id))->num_rows() > 0) {
                        echo '<h3>You are editing Parent '.$cat_type.' Category</h3>';
                    } else {
						echo '<h3>You are editing '.$cat_type.' Category</h3>';
                        ?>
                        <label for="parent_id">Parent Category:</label>
                        <select id="parent_id" name="parent_id" class="form-control">
                            <option value="">No Parent</option>
                            <?php

                            foreach ($qry_cat->result() as $qry_cat_res) {
                                if ($qry_cat_res->id == $qry_cat_to_edit_res->parent_id) {
                                    echo '<option selected="selected" value="' . $qry_cat_res->id . '">' . $qry_cat_res->name . '</option>';
                                } elseif ($qry_cat_res->id == $qry_cat_to_edit_res->id) {
                                } else {
                                    echo '<option value="' . $qry_cat_res->id . '">' . $qry_cat_res->name . '</option>';
                                }
                            }

                            ?>

                        </select>

                        <?php
                    }
                }

                ?>

                <br/>
                <label for="name">Category Name * :</label>
                <input type="text" id="name" class="form-control" name="name"
                       value="<?php echo $qry_cat_to_edit_res->name; ?>" required/>

                <input type="hidden" id="cat_id" class="form-control" name="cat_id"
                       value="<?php echo $qry_cat_to_edit_res->id; ?>"/>

                <br/>
                <label for="details">Category Details :</label>
                <textarea id="details" required="required" class="form-control"
                          name="details"><?php echo $qry_cat_to_edit_res->details; ?></textarea>

                <br/>
                <label>Category Status *:</label>
                <p>
                    <select id="status" name="status" class="form-control">
                        <option value="">Select Status</option>
                        <option <?php if ($qry_cat_to_edit_res->status == 1) echo 'selected'; ?> value="1">Active
                        </option>
                        <option <?php if ($qry_cat_to_edit_res->status == 0) echo 'selected'; ?> value="0">Disable
                        </option>
                    </select>

                </p>

                <br/>

                <p id="form-error" style="color: red;"></p>

                <button style="float: right;" type="button" class="btn btn-primary" onclick="update_category()">Update Category</button>

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

    function update_category() {
        var cat_id = $("#cat_id").val();
        var parent_id = $("#parent_id").val();
        var name = $("#name").val();
        var details = $("#details").val();
        var status = $("#status").val();

        if (name != "" && status != "" && cat_id != "") {
            $.ajax({
                type: "post",
                url: "<?php echo site_url("config/update_category")?>",
                data: {cat_id: cat_id, parent_id: parent_id, name: name, details: details, status: status},
                success: function (html) {
                    if (html == 1) {
                        alert('Updated Successfully.');
                        location.reload();
                    }
                    else {
                        alert('Error Occoured. Please Try Again');
                    }
                }
            });
        }
        else {
            $("#form-error").html('<span>Please Enter Category Name and Status Correctly.</span>');
        }
    }
</script>



