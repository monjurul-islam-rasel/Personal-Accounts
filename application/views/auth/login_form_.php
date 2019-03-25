<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <!-- Meta, title, CSS, favicons, etc. -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="shortcut icon" href="<?php echo base_url(); ?>theme/fav.ico">
      <title>Authentication :: <?php echo $title; ?></title>
      <!-- Bootstrap -->
      <link href="<?php echo base_url(); ?>theme/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- Font Awesome -->
      <link href="<?php echo base_url(); ?>theme/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
      <!-- NProgress -->
      <link href="<?php echo base_url(); ?>theme/vendors/nprogress/nprogress.css" rel="stylesheet">
      <!-- Animate.css -->
      <link href="<?php echo base_url(); ?>theme/vendors/animate.css/animate.min.css" rel="stylesheet">
      <!-- Custom Theme Style -->
      <link href="<?php echo base_url(); ?>theme/build/css/custom.min.css" rel="stylesheet">
   </head>
   <body class="login">
      <div>
         <div class="login_wrapper">
            <div class="animate form login_form" align="center">
               <img src="<?php echo base_url(); ?>theme/logo.png" style="height: 100px; padding: 20xp;">
               <div class="clearfix"></div>
               <h1 style=" font-family: sansation; font-weight: bolder; text-align: center; padding-top: 20px; color: skyblue;"> <?php echo $title; ?></h1>
               <section class="login_content">
                  <form class="form-horizontal" method="post" >
                     <h1>Login Form</h1>
                     <div>
                        <input type="text" class="form-control" placeholder="Username" required name="login" value="demo" />
                     </div>
                     <div>
                        <input type="password" class="form-control" placeholder="Password" required name="password" value="demo1234" />
                     </div>
                     <div>
                        <label style="float: left;">
                        <input type="checkbox" name="remember" id="remember" value="1">
                        Remember Me </label>
                     </div>
                     <div class="clearfix"></div>
                     <div>
                        <button type="submit" class="btn btn-primary " style="float: right;">Sign in</button>
                     </div>
                     <div class="clearfix"></div>
                     <div class="separator">
                        <div class="clearfix"></div>
                        <br />
                        <div>
                           <h1>Income & Expense Management</h1>
                           
                           <?php						   	
							if($remove_powered_by==0){
								echo '<h5><small>Powered By-</small> <a href="http://coloredges.com/" target="_blank"><strong>ColorEdges</strong></a></h5>';
							}						   
						   ?>
                           
                        </div>
                     </div>
                  </form>
               </section>
            </div>
         </div>
      </div>
   </body>
</html>