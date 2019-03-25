<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> Personal Accounts - <?php echo $listing_header; ?> </title>

        <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>theme/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?php echo base_url(); ?>theme/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?php echo base_url(); ?>theme/vendors/nprogress/nprogress.css" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="<?php echo base_url(); ?>theme/build/css/custom.min.css" rel="stylesheet">
        
    </head>

    <body>
        <div class="container body">
            <div class="main_container"> 
                
                <div class="page-title">  
                    
                    <div class="title_left">
                        <h2 id="menu_toggle"> <i class="fa fa-bars"></i> 
                            Personal Accounts                            
                        </h2>
                    </div>

                    <div class="title_right">
                      <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <h3> <strong><?php echo $listing_header; ?></strong></h3>
                      </div>
                    </div>
                </div>
                
                <table class="table table-striped">
                   
                    <thead>
                        <tr>
                            <th>SL.</th>
                            <th>Title</th>                           
                            <th>Details</th>                            
                            <th>Reference</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                       
                        <?php 
                            
                        $sl = 1;
                       
					   
                        foreach ($qry_notes->result() as $qry_notes_res) 
                        {
                            echo '<tr>
				
                                    <td>
                                    ' . $sl . '.			   
                                    </td>				
                                    <td>
                                    ' . $qry_notes_res->title . '			   
                                    </td>				
                                    				
                                    <td>
                                    ' . $qry_notes_res->details . '		   
                                    </td>
                                    
                                    <td>
                                    ' . $qry_notes_res->reference . '		   
                                    </td>				
                                    <td>
                                    ' . ($qry_notes_res->status == 1 ? 'Task Done' : 'Task Not Done') . '			   
                                    </td>
                                    
                              </tr>';

                            $sl++;      
                           
                        }



                            ?>
                        
                        
                    </tbody>
                </table>    
                
                
                 <div class="clearfix"></div>

                
                
                
            </div>
        </div>

        
        <script src="<?php echo base_url(); ?>theme/vendors/jquery/dist/jquery.min.js"></script>
        
        <script src="<?php echo base_url(); ?>theme/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        
        <script src="<?php echo base_url(); ?>theme/vendors/fastclick/lib/fastclick.js"></script>
       
        <script src="<?php echo base_url(); ?>theme/vendors/nprogress/nprogress.js"></script>
        
        <script src=".<?php echo base_url(); ?>theme/build/js/custom.min.js"></script>
        
        
        <script>
        
             $(function () {
				 
                window.print();
				
				/*var from_dt = '<?php echo $this->input->post('from_dt');?>';
                var to_dt   = '<?php echo $this->input->post('to_dt');?>';
                var type    = '<?php echo $this->input->post('type');?>';
                
                var url = "<?php echo site_url("notes/get_notes_custom"); ?>";
				var form = $('<form action="' + url + '" method="post">' +
					'<input type="hidden" name="from_dt" value="' + from_dt + '" />' +
					'<input type="hidden" name="to_dt" value="' + to_dt + '" />' +
					'<input type="hidden" name="type" value="' + type + '" />' +
					'</form>');
				$('body').append(form);
				form.submit();*/
				
				                
                window.location.replace("<?php echo site_url("notes"); ?>");
            });
            
            
        
        </script>
        
     
    </body>
</html>