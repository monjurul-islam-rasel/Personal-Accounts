<?php
/**
 * Created by PhpStorm.
 * User: Rasel
 * Date: 7/23/2018
 * Time: 11:45 AM
 */

$qry_cat = $this->db->get_where('category', array('parent_id' => 0, 'cat_type'=>0 ));

?>

<div class="x_panel">

	<div class="x_content">

		<!-- start form for validation -->
		<form id="demo-form" data-parsley-validate>

			<?php

			if ($qry_cat->num_rows() > 0) {
				?>

				<label for="parent_id">Parent Category:</label>
				<select id="parent_id" name="parent_id" class="form-control">
					<option value="">No Parent</option>
					<?php

					foreach ($qry_cat->result() as $qry_res) {
						echo '<option value="' . $qry_res->id . '">' . $qry_res->name . '</option>';
					}

					?>

				</select>

				<?php
			}

			?>

			<br/>
			<label for="name">Name * :</label>
			<input type="text" id="name" class="form-control" name="name" required/>

			<br/>
			<label for="details">Details :</label>
			<textarea id="details" required="required" class="form-control" name="details" ></textarea>

			<br/>
			<label>Status *:</label>
			<p>
				<select id="status" name="status" class="form-control">
					<option value="">Select Status</option>
					<option value="1">Active</option>
					<option value="0">Disable</option>
				</select>

			</p>

			<br/>

			<p id="form-error" style="color: red;"></p>

			<button style="float: right;" type="button" class="btn btn-primary" onclick="create_exp_category()">
            Create Expense Category
			</button>

		</form>
		<!-- end form for validations -->

	</div>
</div>

<script >

	function create_exp_category() 
	{
		var cat_type = '0';
		var parent_id = $("#parent_id").val();
		var name = $("#name").val();
		var details = $("#details").val();
		var status = $("#status").val();

		if (name != "" && status != "") {
			$.ajax({
				type: "post",
				url: "<?php echo site_url("config/create_category")?>",
				data: { cat_type: cat_type, parent_id: parent_id, name: name, details: details, status: status},
				success: function (html) {
					if (html == 1) {
						alert('New Expense Category Created Successfully.');
						location.reload();
					}
					else {
						alert('Error Occurred. Please Try Again');
					}
				}
			});
		}
		else {
			$("#form-error").html('<span>Please Enter Category Name and Status Correctly.</span>');
		}
	}
</script>



