<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>  Print Income :: <?php echo $title; ?> </title>

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
                            <?php echo $title; ?>                          
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
                            <th>Purpose</th>
                            <th>Amount</th>
                            <th>Details</th>
                            <th>Category</th>
                            <th>Reference</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                       
                        <?php 
                            
                        $sl = 1;
                        $total_income = 0;
                        foreach ($qry_income->result() as $qry_income_res) 
                        {
                            echo '<tr>
				
                                    <td>
                                    ' . $sl . '.			   
                                    </td>				
                                    <td>
                                    ' . $qry_income_res->purpose . '			   
                                    </td>				
                                    <td>
                                    ' . $qry_income_res->amount . '			   
                                    </td>				
                                    <td>
                                    ' . $qry_income_res->details . '		   
                                    </td>
                                    <td>
                                    ' . $this->m_config->get_category_name_by_id($qry_income_res->category) . '
                                    </td>
                                    <td>
                                    ' . $qry_income_res->reference . '		   
                                    </td>				
                                    <td>
                                    ' . ($qry_income_res->payment_status == 1 ? 'Payment Processed' : 'Payment Not Processed') . '			   
                                    </td>
                                    
                              </tr>';

                            $sl++;      
                            $total_income += $qry_income_res->amount; 
                        }



                            ?>
                        
                        
                    </tbody>
                </table>    
                
                
                 <div class="clearfix"></div>

                <h3>
                    Total Income = <?php echo $this->cart->format_number($total_income); ?>
                </h3>
                
                
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
                window.location.replace("<?php echo site_url("income"); ?>");
            });
            
            
        
        </script>
        
     
    </body>
</html>