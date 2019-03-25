<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> Print Income vs Expense :: <?php echo $title; ?> </title>

        <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>theme/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?php echo base_url(); ?>theme/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?php echo base_url(); ?>theme/vendors/nprogress/nprogress.css" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="<?php echo base_url(); ?>theme/build/css/custom.min.css" rel="stylesheet">
        
        <style>
			
			@media print
			{
				#income_lists { page-break-after : always; }
			}
			
         </style>
        
    </head>

    <body>
        <div class="container body">
            <div class="main_container"> 
                
               
                <div id="income_lists">
                
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
                
                    <h3><strong style="color:#4caf50;">Income Listings</strong></h3>
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
                                        <td style="font-size:small;">
                                        ' . $this->m_config->get_category_name_by_id($qry_income_res->category) . '
                                        </td>
                                        <td>
                                        ' . $qry_income_res->reference . '		   
                                        </td>				
                                        <td style="font-size:smaller;">
                                        ' . ($qry_income_res->payment_status == 1 ? 'Payment Processed' : 'Payment Not Processed') . '			   
                                        </td>
                                        
                                  </tr>';
    
                                $sl++;      
                                $total_income += $qry_income_res->amount; 
                            }
    
                          ?>
                            
                            
                        </tbody>
                        <tfoot>
                        	<tr  style="border:none;">
                            	<td colspan="7"  style="border:none;">
                                	<small style="float:left; opacity:.5; padding:5px;"><?php echo $title; ?></small>
                                    
                                </td>
                            </tr>
                        </tfoot>
                    </table>  
                    
                    
                <div class="clearfix"></div>
                
                    <h3>
                        Total Income = <?php echo $this->cart->format_number($total_income); ?>
                        
                         <?php						   	
							if($this->m_config->get_config()->remove_powered_by==0){
								echo '<small style="float:right; padding:3px;">Powered By - www.sbtechvalley.com</small>';
							}						   
						?>
                        
                    </h3>
                    
                    
                    
                </div>  
                
                
                    
                 <div id="expense_lists">   
                    
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

                    
                    <h3><strong style="color:#4caf50;">Expense Listings</strong></h3>
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
                            $total_expense = 0;
                            foreach ($qry_expense->result() as $qry_expense_res) 
                            {
                                echo '<tr>
                    
                                        <td>
                                        ' . $sl . '.			   
                                        </td>				
                                        <td>
                                        ' . $qry_expense_res->purpose . '			   
                                        </td>				
                                        <td>
                                        ' . $qry_expense_res->amount . '			   
                                        </td>				
                                        <td>
                                        ' . $qry_expense_res->details . '		   
                                        </td>
                                        <td style="font-size:small;">
                                        ' . $this->m_config->get_category_name_by_id($qry_expense_res->category) . '
                                        </td>
                                        <td>
                                        ' . $qry_expense_res->reference . '		   
                                        </td>				
                                        <td style="font-size:smaller;">
                                        ' . ($qry_expense_res->payment_status == 1 ? 'Payment Processed' : 'Payment Not Processed') . '			   
                                        </td>
                                        
                                  </tr>';
    
                                $sl++;      
                                $total_expense += $qry_expense_res->amount; 
                            }
    
    
    
                                ?>
                            
                            
                        </tbody>
                        
                        <tfoot>
                        	<tr  style="border:none;">
                            	<td colspan="7" style="border:none;">
                                	<small style="float:left; opacity:.5; padding:5px;"><?php echo $title; ?></small>
                                   
                                </td>
                            </tr>
                        </tfoot>
                        
                    </table>    
                    
                    
                     <div class="clearfix"></div>
    
                    <h3>
                        Total Expense = <?php echo $this->cart->format_number($total_expense); ?>
                        
                        <?php						   	
							if($this->m_config->get_config()->remove_powered_by==0){
								echo '<small style="float:right; padding:3px;">Powered By - www.sbtechvalley.com</small>';
							}						   
						?>
                    </h3>
                    
                     
                    
                </div>
                
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
                window.location.replace("<?php echo site_url("reports"); ?>");
            });
            
            
        
        </script>
        
     
    </body>
</html>