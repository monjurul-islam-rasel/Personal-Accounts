<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Create User Form</h3>
      </div>
      <div class="panel-body">
        <?php
	if ($use_username) {
		$username = array(
			'name'	=> 'username',
			'id'	=> 'username',
			'value' => set_value('username'),
			'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
			'size'	=> 30,
			'class' => 'form-control',
			'required' => ''
		);
	}
	$email = array(
		'name'	=> 'email',
		'id'	=> 'email',
		'value'	=> set_value('email'),
		'maxlength'	=> 50,
		'size'	=> 30,
		'class' => 'form-control',
		'type'  => 'email',
		'required' => ''
	);
	$phone = array(
		'name'	=> 'phone',
		'id'	=> 'phone',
		'value'	=> set_value('phone'),
		'maxlength'	=> 40,
		'minlength'	=> 10,
		'size'	=> 30,
		'class' => 'form-control',
		'type'  => 'number',
		'required' => ''
	);

	$full_name = array(
		'name'	=> 'full_name',
		'id'	=> 'full_name',
		'value'	=> set_value('full_name'),	
		'size'	=> 50,
		'class' => 'form-control',
		'required' => ''
	);

	$password = array(
		'name'	=> 'password',
		'id'	=> 'password',
		'value' => set_value('password'),
		'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
		'size'	=> 30,
		'class' => 'form-control',
		'required' => ''
	);
	$confirm_password = array(
		'name'	=> 'confirm_password',
		'id'	=> 'confirm_password',
		'value' => set_value('confirm_password'),
		'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
		'size'	=> 30,
		'class' => 'form-control',
		'required' => ''
	);


	$captcha = array(
		'name'	=> 'captcha',
		'id'	=> 'captcha',
		'maxlength'	=> 8,
	);

	$user_type = array(
		'name'	=> 'user_type',
		'id'	=> 'user_type'		
	);

	$js = 'id = "user_type" class = "form-control" required';
	$user_options = array(
					                
	                  '3'    => 'Staff'             
	                );



	?>
        <?php echo form_open($this->uri->uri_string()); ?>
        <table class="table table-condensed">
          <tr  class="warning" style="display:none;">
            <td><?php echo form_label('User Type', $user_type['id']); ?></td>
            <td><?php echo form_dropdown('user_type', $user_options, '', $js); ?></td>
            <td style="color: red;"><?php echo form_error($user_type['name']); ?><?php echo isset($errors[$user_type['name']])?$errors[$user_type['name']]:''; ?></td>
          </tr>
          <tr style="border-top:none;">
            <td><?php echo form_label('Full name', $full_name['id']); ?></td>
            <td><?php echo form_input($full_name); ?></td>
            <td style="color: red;"><?php echo form_error($full_name['name']); ?><?php echo isset($errors[$full_name['name']])?$errors[$full_name['name']]:''; ?></td>
          </tr>
          <?php if ($use_username) { ?>
          <tr>
            <td><?php echo form_label('Username', $username['id']); ?></td>
            <td><?php echo form_input($username); ?></td>
            <td style="color: red;"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td><?php echo form_label('Email Address', $email['id']); ?></td>
            <td><?php echo form_input($email); ?></td>
            <td style="color: red;"><?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?></td>
          </tr>
          <tr>
            <td><?php echo form_label('Phone Number', $phone['id']); ?></td>
            <td><?php echo form_input($phone); ?></td>
            <td style="color: red;"><?php echo form_error($phone['name']); ?><?php echo isset($errors[$phone['name']])?$errors[$phone['name']]:''; ?></td>
          </tr>
          <tr>
            <td><?php echo form_label('Password', $password['id']); ?></td>
            <td><?php echo form_password($password); ?></td>
            <td style="color: red;"><?php echo form_error($password['name']); ?></td>
          </tr>
          <tr>
            <td><?php echo form_label('Confirm Password', $confirm_password['id']); ?></td>
            <td><?php echo form_password($confirm_password); ?></td>
            <td style="color: red;"><?php echo form_error($confirm_password['name']); ?></td>
          </tr>
          <?php if ($captcha_registration) {
			if ($use_recaptcha) { ?>
          <tr>
            <td colspan="2"><div id="recaptcha_image"></div></td>
            <td><a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
              <div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
              <div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div></td>
          </tr>
          <tr>
            <td><div class="recaptcha_only_if_image">Enter the words above</div>
              <div class="recaptcha_only_if_audio">Enter the numbers you hear</div></td>
            <td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
            <td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
            <?php echo $recaptcha_html; ?> </tr>
          <?php } else { ?>
          <tr>
            <td colspan="3"><p>Enter the code exactly as it appears:</p>
              <?php echo $captcha_html; ?></td>
          </tr>
          <tr>
            <td><?php echo form_label('Confirmation Code', $captcha['id']); ?></td>
            <td><?php echo form_input($captcha); ?></td>
            <td style="color: red;"><?php echo form_error($captcha['name']); ?></td>
          </tr>
          <?php }
		} ?>
        </table>
        <?php echo form_submit('register', 'Create User', 'class="btn btn-primary"' ); ?> <?php echo form_close(); ?> </div>
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

