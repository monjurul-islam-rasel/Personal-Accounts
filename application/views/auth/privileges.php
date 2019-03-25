<?php
/**
 * Created by PhpStorm.
 * User: Rasel
 * Date: 7/23/2018
 * Time: 11:45 AM
 */

$qry_cat = $this->db->get_where('category', array('parent_id' => 0));

?>

<div class="x_panel">

	<div class="x_content">

		<!-- start form for validation -->
		<form id="demo-form" data-parsley-validate>
			
             <label for="name">Modules :</label>
             <br />
            
			<?php 
			
				$qry_modules = $this->db->get_where('modules', array('status'=>1));
				
				foreach($qry_modules->result() as $qry_modules_res)
				{
					echo '<label style="padding:10px;">
							<input type="checkbox" name="'.$qry_modules_res->id.'" id="'.$qry_modules_res->name.'" value="1"> '.$qry_modules_res->name.'
						</label>
						<br />
						
                        ';
				}
			
			?>
            
            <p id="form-error" style="color: red;"></p>

			<button style="float: right;" type="button" class="btn btn-primary" onclick="create_category()">
            	Update Privileges
			</button>

		</form>
		<!-- end form for validations -->

	</div>
</div>
