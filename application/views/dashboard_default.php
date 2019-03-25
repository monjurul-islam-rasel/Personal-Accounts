<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <!-- Meta, title, CSS, favicons, etc. -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="shortcut icon" href="<?php echo base_url(); ?>theme/fav.ico">
      <title><?php echo $title; ?></title>
      <!-- Bootstrap -->
      <link href="<?php echo base_url(); ?>theme/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- Font Awesome -->
      <link href="<?php echo base_url(); ?>theme/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
      <!-- NProgress -->
      <link href="<?php echo base_url(); ?>theme/vendors/nprogress/nprogress.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>theme/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
      <!-- bootstrap-datetimepicker -->
      <link href="<?php echo base_url(); ?>theme/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css"
         rel="stylesheet">
      <!-- Ion.RangeSlider -->
      <link href="<?php echo base_url(); ?>theme/vendors/normalize-css/normalize.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>theme/vendors/ion.rangeSlider/css/ion.rangeSlider.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>theme/vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css"
         rel="stylesheet">
      <!-- Bootstrap Colorpicker -->
      <link
         href="<?php echo base_url(); ?>theme/vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css"
         rel="stylesheet">
      <link href="<?php echo base_url(); ?>theme/vendors/cropper/dist/cropper.min.css" rel="stylesheet">
      <!-- iCheck -->
      <link href="<?php echo base_url(); ?>theme/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
      <!-- Datatables -->
      <link href="<?php echo base_url(); ?>theme/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css"
         rel="stylesheet">
      <link href="<?php echo base_url(); ?>theme/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css"
         rel="stylesheet">
      <link href="<?php echo base_url(); ?>theme/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css"
         rel="stylesheet">
      <link href="<?php echo base_url(); ?>theme/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"
         rel="stylesheet">
      <link href="<?php echo base_url(); ?>theme/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css"
         rel="stylesheet">
      <!-- Custom Theme Style -->
      <link href="<?php echo base_url(); ?>theme/build/css/custom.css" rel="stylesheet">
      <!-- jQuery -->
      <script src="<?php echo base_url(); ?>theme/vendors/jquery/dist/jquery.min.js"></script>
   </head>
   <body class="nav-md" style="font-family: sansation;">
      <div class="container body">
         <div class="main_container">
            <div class="col-md-3 left_col">
               <div class="left_col scroll-view">
                  <div class="navbar nav_title" style="border: 0;"><a href="<?php echo base_url(); ?>" class="site_title"> <img src="<?php echo base_url(); ?>theme/fav.ico" style="width: 30px;"> <span>Accounts</span></a> </div>
                  <div class="clearfix"></div>
                  <!-- menu profile quick info -->
                  <div class="profile clearfix">
                     <div class="profile_info">
                        <span>Welcome,</span>
                        <h2>
                           <?php if (isset($username)) echo $username; ?>
                        </h2>
                     </div>
                     <div class="clearfix"></div>
                  </div>
                  <!-- /menu profile quick info --> 
                  <br/>
                  <!-- sidebar menu -->
                  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                     <div class="menu_section">
                        <h3>General</h3>
                        <ul class="nav side-menu">
                           <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Dashboard </a></li>
                           <li> <a href="<?php echo base_url(); ?>income" style="color:lightgreen;"><i
                              class="fa fa-money"></i>Income </a> </li>
                           <li><a href="<?php echo base_url(); ?>expense" style="color:lightyellow;"><i
                              class="fa fa-money"></i>Expense</a> </li>
                           <li><a href="<?php echo base_url(); ?>notes"><i class="fa fa-sticky-note"></i>Task Notes </a> </li>
                           <li><a href="<?php echo base_url(); ?>config/category"><i class="fa fa-gears"></i> Category </a> </li>
                           <li><a href="<?php echo base_url(); ?>reports/"><i class="fa fa-pie-chart"></i> Reports </a> </li>
                           <?php
                              $user_data = $this->users->get_user_data_by_id($this->tank_auth->get_user_id());
                              		   
                              if ($user_data->user_type == 1) {
                                ?>
                           <li> <a href="<?php echo base_url(); ?>auth/all_users"><i class="fa fa-users"></i> User Management </a> </li>
                           <?php
                              }
                              ?>
                              
                            <li><a href="<?php echo base_url(); ?>config/"><i class="fa fa-info"></i> Configuration </a> </li>
                        </ul>
                     </div>
                  </div>
                  <!-- /sidebar menu --> 
                  <!-- /menu footer buttons -->
                  <div class="sidebar-footer hidden-small"><a data-toggle="tooltip" data-placement="top" title="Logout"
                     href="<?php echo base_url(); ?>auth/logout"> <span
                     class="glyphicon glyphicon-off" aria-hidden="true"></span> </a></div>
                  <!-- /menu footer buttons --> 
               </div>
            </div>
            <!-- top navigation -->
            <div class="top_nav">
               <div class="nav_menu">
                  <nav>
                     <div class="nav toggle" style="width: auto !important; font-size: 26px;"> <a id="menu_toggle"> <i class="fa fa-bars"></i> <?php echo $title;?> </a> </div>
                     <ul class="nav navbar-nav navbar-right" style="width:auto !important;">
                        <li class="">
                           <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                              aria-expanded="false">
                           <?php if (isset($username)) echo $username; ?>
                           <span class=" fa fa-angle-down"></span> </a>
                           <ul class="dropdown-menu dropdown-usermenu pull-right">
                              <li><a href="<?php echo base_url(); ?>auth/change_password">Change Password</a></li>
                              <?php
                                 if	($user_data->user_type == 1) {
                                 ?>
                              <li><a href="<?php echo base_url(); ?>welcome/backup_db">Backup DB</a></li>
                              <?php
                                 }
                                 ?>
                              <li><a href="<?php echo base_url(); ?>auth/logout">Logout</a></li>
                           </ul>
                        </li>
                     </ul>
                  </nav>
               </div>
            </div>
            <!-- /top navigation --> 
            <!-- page content -->
            <div class="right_col" role="main">
               <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                     <div class="x_panel">
                        <div class="x_title">
                           <h2>
                              <?php if (isset($sub_title)) echo $sub_title; else echo 'Personal Accounts - Overview'; ?>
                           </h2>
                           <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                           <div class="panel-body" id="content_area">
                              <div id="search_result"></div>
                              <?php if (isset($content)) echo $content; ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /page content --> 
            <!-- footer content -->
            
            <?php						   	
				if($this->m_config->get_config()->remove_powered_by==0){
					echo '<footer class="navbar-fixed-bottom footer" style=" float:right; text-align:right;">
							<strong> Powered by - <a href="http://coloredges.com" target="_blank">ColorEdges</a></strong></footer>';
				}						   
			?>
                            
           
            <!-- /footer content --> 
         </div>
      </div>
      <!-- Bootstrap --> 
      <script src="<?php echo base_url(); ?>theme/vendors/bootstrap/dist/js/bootstrap.min.js"></script> 
      <!-- FastClick --> 
      <script src="<?php echo base_url(); ?>theme/vendors/fastclick/lib/fastclick.js"></script> 
      <!-- NProgress --> 
      <script src="<?php echo base_url(); ?>theme/vendors/nprogress/nprogress.js"></script> 
      <!-- jQuery Smart Wizard --> 
      <script src="<?php echo base_url(); ?>theme/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script> 
      <!-- bootstrap-daterangepicker --> 
      <script src="<?php echo base_url(); ?>theme/vendors/moment/min/moment.min.js"></script> 
      <script src="<?php echo base_url(); ?>theme/vendors/bootstrap-daterangepicker/daterangepicker.js"></script> 
      <!-- bootstrap-datetimepicker --> 
      <script
         src="<?php echo base_url(); ?>theme/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script> 
      <!-- iCheck --> 
      <script src="<?php echo base_url(); ?>theme/vendors/iCheck/icheck.min.js"></script> 
      <!-- Bootstrap Colorpicker --> 
      <script
         src="<?php echo base_url(); ?>theme/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script> 
      <!-- jquery.inputmask --> 
      <script src="<?php echo base_url(); ?>theme/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script> 
      <!-- jQuery Knob --> 
      <script src="<?php echo base_url(); ?>theme/vendors/jquery-knob/dist/jquery.knob.min.js"></script> 
      <!-- validator --> 
      <script src="<?php echo base_url(); ?>theme/vendors/validator/validator.js"></script> 
      <!-- Datatables --> 
      <script src="<?php echo base_url(); ?>theme/vendors/datatables.net/js/jquery.dataTables.min.js"></script> 
      <script src="<?php echo base_url(); ?>theme/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
      <script src="<?php echo base_url(); ?>theme/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script> 
      <script src="<?php echo base_url(); ?>theme/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script> 
      <script src="<?php echo base_url(); ?>theme/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script> 
      <script src="<?php echo base_url(); ?>theme/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script> 
      <script src="<?php echo base_url(); ?>theme/vendors/datatables.net-buttons/js/buttons.print.min.js"></script> 
      <script
         src="<?php echo base_url(); ?>theme/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script> 
      <script src="<?php echo base_url(); ?>theme/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script> 
      <script src="<?php echo base_url(); ?>theme/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
      <script src="<?php echo base_url(); ?>theme/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script> 
      <script src="<?php echo base_url(); ?>theme/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script> 
      <script src="<?php echo base_url(); ?>theme/vendors/echarts/dist/echarts.min.js"></script> 
      <!-- morris.js --> 
      <script src="<?php echo base_url(); ?>theme/vendors/raphael/raphael.min.js"></script> 
      <script src="<?php echo base_url(); ?>theme/vendors/morris.js/morris.min.js"></script> 
      <script src="<?php echo base_url(); ?>theme/vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script> 
      <!-- Custom Theme Scripts --> 
      <script src="<?php echo base_url(); ?>theme/build/js/custom.js"></script> 
      <!-- Inline --> 
      <script type="text/javascript">
         function search_result() {
         	var search_text = $("#search_text").val();
         
         	$.ajax({
         		type: "post",
         		url: "<?php echo site_url("welcome/ajax_search_general")?>/",
         		data: {search_text: search_text},
         		success: function (html) {
         			$("#search_result").html(html);
         		}
         	});
         }
         
         $('.date').datetimepicker({
         	format: 'YYYY-MM-DD'
         });
         
         $('.datetime').datetimepicker({
         	format: 'YYYY-MM-DD h:mm A'
         });
         
         $(function () {
            $('[data-toggle="tooltip"]').tooltip();
         });
         
      </script> 
      <!-- modal structures --> 
      <!-- Modal small -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
                  <h4 class="modal-title" id="myModalLabel">Modal title</h4>
               </div>
               <div class="modal-body" id="myModalBody"> ... </div>
               <div id="myModalFooter" class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
      <!-- Modal large -->
      <div class="modal fade bs-example-modal-lg" id="myModalLarge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
                  <h4 class="modal-title" id="myModalLargeLabel">Modal title</h4>
               </div>
               <div class="modal-body" id="myModalLargeBody"> ... </div>
               <div id="myModalLargeFooter" class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
      <!-- Modal datepicker-->
      <div class="modal fade" id="ModaldatePicker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
                  <h4 class="modal-title" id="ModaldatePickerLabel">Modal Datepicker</h4>
               </div>
               <div class="modal-body" id=ModaldatePickerBody">
                  <form class="form-horizontal input_mask">
                     <h3>Select Dates</h3>
                     <div class="col-md-5 col-sm-5 col-xs-10 form-group ">
                        <input type="text" class="form-control has-feedback-left" id="date_from"
                           placeholder="Starting date">
                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span> 
                     </div>
                     <div class="col-md-2 col-sm-2 col-xs-2" style="text-align: center;">
                        <button disabled class="btn btn-default"> To</button>
                     </div>
                     <div class="col-md-5 col-sm-5 col-xs-10 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="date_to"
                           placeholder="Ending date">
                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span> 
                     </div>
                     <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-6" style="text-align: right;">
                           <button id="ModaldatePickerSubmitBtn" type="button" class="btn btn-success">Submit</button>
                        </div>
                     </div>
                  </form>
               </div>
               <div id="myModalFooter" class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>