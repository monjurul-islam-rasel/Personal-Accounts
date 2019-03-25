<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Update Password Form - <strong><?php echo $action_user->full_name.' ('.$action_user->username.')';?></strong></h3>
      </div>
      <div class="panel-body">
        <?php

$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'class' => 'form-control',
	'required' => ''
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size' 	=> 30,
	'class' => 'form-control',
	'required' => ''
);
?>
        <?php echo form_open($this->uri->uri_string()); ?>
        <table class="">
          <tr>
            <td><?php echo form_label('New Password', $new_password['id']); ?></td>
            <td><?php echo form_password($new_password); ?></td>
            <td style="color: red;"><?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?></td>
          </tr>
          <tr>
            <td><?php echo form_label('Confirm New Password', $confirm_new_password['id']); ?></td>
            <td><?php echo form_password($confirm_new_password); ?></td>
            <td style="color: red;"><?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?></td>
          </tr>
        </table>
        <?php echo form_submit('change', 'Update password', 'class="btn btn-warning"'); ?> <?php echo form_close(); ?>
       
      </div>
    </div>
  </div>
 
   <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
         <div class="x_title">
            <h2>
               All Users
            </h2>
            <div class="clearfix"></div>
         </div>
         <div class="x_content">
            <?php echo $all_users; ?>
         </div>
      </div>
   </div>
    
  
</div>

<style>
td 
{
    padding: 5px;
}
</style>
