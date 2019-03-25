<!DOCTYPE html>
<html lang="en">
<head>
<title>Personal Accounts Documentation ( Income Expense Management System )</title>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="favicon.ico">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
<!-- FontAwesome JS -->
<!-- Global CSS -->
<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
<!-- Plugins CSS -->
<link rel="stylesheet" href="assets/plugins/prism/prism.css">
<link rel="stylesheet" href="assets/plugins/elegant_font/css/style.css">

<!-- Theme CSS -->
<link id="theme-style" rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="body-green">
<div class="page-wrapper"> 
  <!-- ******Header****** -->
  <header id="header" class="header">
    <div class="container">
      <div class="branding">
        <h1 class="logo"> <a href="index.html"> <span aria-hidden="true" class="icon_documents_alt icon"></span> <span class="text-highlight">Personal </span><span class="text-bold">Accounts</span> <br />
          <small>Income Expense Management System - Documentation</small> </a> </h1>
      </div>
      <!--//branding-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Quick Start</li>
      </ol>
    </div>
    <!--//container--> 
  </header>
  <!--//header-->
  <div class="doc-wrapper">
    <div class="container">
      <div id="doc-header" class="doc-header text-center">
        <h1 class="doc-title"><i class="icon fa fa-paper-plane"></i> Quick Start</h1>
        <div class="meta"><i class="far fa-clock"></i> Last updated: September 09th, 2018</div>
      </div>
      <!--//doc-header-->
      <div class="doc-body row">
        <div class="doc-content col-md-9 col-12 order-1">
          <div class="content-inner">
            <section id="requirements-section" class="doc-section">
              <h2 class="section-title">Requirements</h2>
              <div class="section-block">
                <ul class="list">
                  <li>PHP 5.6+</li>
                  <li>MYSQL 5.4+</li>
                  <li>PHP MYSQLi Extension</li>
                  <li>PHP ZIP Extension (Optional but needed for database backup)</li>
                </ul>
              </div>
            </section>
            <!--//doc-section-->
            <section id="installation-section" class="doc-section">
              <h2 class="section-title">Installation</h2>
              <div id="step-1"  class="section-block">
                <h3 class="block-title">Requirements: Apache 2.2+, Mysql 5.4+, PHP 5.6+</h3>
                <br />
                <h6>Follow these steps - </h6>
                <ul class="list">
                  <li>Extract the Downloaded .zip file.</li>
                  <li>Copy/Upload the folder and files to your web server using cPanel or FTP</li>
                  <li>If you are installing in sub folder, please make sure there is no space in folder names</li>
                  <li>Open the <strong>http://yourdomain.com/pathtoupload/install/index.php</strong></li>
                  <br id="step-1_1" />
                  <h5 >Step - 1 : Database Configuration: </h5>
                  <hr />
                  <ul class="list">
                    <li><strong>Enter Database Host</strong> <span style="float:right; color:red;">Ex - localhost</span></li>
                    <li><strong>Enter Database User</strong> <span style="float:right; color:red;">Ex - root</span></li>
                    <li><strong>Enter Database Password</strong> <span style="float:right; color:red;">Ex - *******</span></li>
                     li><strong>Enter Database Name</strong> <span style="float:right; color:red;">Ex - db_name</span></li>
                  <div class="callout-block callout-warning">                     
                      <div class="content">
                        <h4 class="callout-title">If You are using <strong>CPanel</strong>:</h4>
                        <p> Make sure You have created - <strong>Database</strong>, <strong>Database User</strong>
                        <br /><strong> Also given Privileges to DB User for Database</strong></p>
                      </div>
                       <div class="icon-holder"> <i class="fas fa-information"></i> </div>
                    </div>                    
                  </ul>
                 <br id="step-1_2" />
                  <h5 >Step - 2 : Base URL: </h5>
                  <hr />
                  <div class="callout-block callout-info">                     
                    <div class="content">
                      <h4 class="callout-title"><strong>Base URL Generated Automatically</strong>:</h4>
                      <p> Make sure You Base URL is - <strong>Correct</strong> <br />If you are not Sure leave it as it is. </p>
                    </div>
                     <div class="icon-holder"> <i class="fas fa-information"></i> </div>
                  </div> 
                 <li>Click on <strong>Start Installation</strong></li>
                 <li><strong style="color:green;">Success!</strong></li> 
                 <div class="callout-block callout-success">                     
                    <div class="content">
                       <h3>Now Sign In</h3>
                       <h4> Using Given Authentication Credentials.</h4>
                    </div>
                     <div class="icon-holder"> <i class="fas fa-thumbs-up"></i> </div>
                 </div> 
                 <img src="assets/images/pa/login.png" style="width: 100%;">               
              </div>
            </section>
              <!-- Installation steps end-->              
              <section id="config" class="doc-section">
              <h2 class="section-title">System Configuration - <small>How to Change Site Title and Remove Powered By</small></h2>
              <div class="section-block">
                <div class="row">                
                  <div class="col-md-6 col-12"> 
                    <ul class="list">
                      <li>Go to -> <strong>Configuration</strong></li>
                      <li>Change Site Title ( if necessary ) </li>
                      <li>Tick on Check Box to Remove Powered By  - SB TechValley </li>
                      <li>Click on <strong>Update/Save Button</strong></li>
                      <li>For More Help See Video Below -</li>
                     </ul>                     
                  </div>
                  <br />                    
                  <div class="col-md-12 col-12">
                    <h6>How to Change Site Title and Remove Powered By</h6>
                    <!-- 4:3 aspect ratio -->
                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe src="https://www.youtube.com/embed/ZpLJRA6bUvQ" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                  </div>
                </div>
                <!--//row--> 
              </div>
              <!--//section-block-->              
              <div class="section-block" id="change-password">
              	<h3 class="section-title">Changing Password</h3>
                <br />
                <div class="row">
                  <div class="col-md-6 col-12"> 
                    <ul class="list">
                      <li>Click on Your <strong>UserName</strong> (Placed on Top Right Corner)</li>
                      <li>Click Change Password </li>
                      <li>Enter Current Password </li>
                      <li>Enter New Password</li>
                      <li>Enter New Password Again</li>
                      <li>Click on <strong>Change Password</strong> Button</li>
                      <li>For More Help See Video Below -</li>                      
                     </ul>                     
                  </div>
                  <br />                    
                  <div class="col-md-12 col-12">
                    <h6>How to Change Password</h6>
                    <!-- 4:3 aspect ratio -->
                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe src="https://www.youtube.com/embed/DqcV61s-OIs" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                  </div>
                </div>
                <!--//row--> 
              </div>              
             <section id="user-management" class="doc-section">
              <h2 class="section-title">User Management <small>(Only Owner User can Perform User Management)</small></h2>
              <br />
              	<h3 class="block-title">Here you will find Details Tutorial about User Management.</h3>
              <p></p>  
                <div class="section-block" id="view-users">
              	<h3 class="section-title">View All Users</h3>
                <br />
                <div class="row">
                  <div class="col-md-6 col-12"> 
                    <ul class="list">
                      <li>Click on <strong>User Management</strong> </li>
                      <li>View All Users </li>
                      <li>Search Users using Search Box </li>
                     </ul>                     
                  </div>
                   </div>
                <!--//row--> 
              </div>              
              <div class="section-block" id="create-user">
              	<h3 class="section-title">Create New User</h3>
                <br />
                <div class="row">
                  <div class="col-md-6 col-12"> 
                    <ul class="list">
                      <li>Click on <strong>Create New User</strong> </li>
                      <li>Select User Type </li>
                      <li>Enter Full Name </li>
                      <li>Enter User Name </li>
                      <li>Enter Email Address </li>
                      <li>Enter Phone Number</li>
                      <li>Enter User Password </li>
                      <li>Enter Password Again</li>
                      <li>Click on <strong>Create User</strong> Button</li>
                      <li>For More Help See Video Below -</li>                      
                     </ul>                     
                  </div>
                  <br />                  
                  <div class="col-md-12 col-12">
                    <h6>How Create New User</h6>
                    <!-- 4:3 aspect ratio -->
                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe src="https://www.youtube.com/embed/devnV0KRuxQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                  </div>                
                <!--//row--> 
              </div>              
              <div class="section-block" id="update-user-pass">
              	<h3 class="section-title"> <br />Update Users Password</h3>
                <br />
                <div class="row">
                  <div class="col-md-6 col-12"> 
                    <ul class="list">
                      <li>Click on <strong>User Management</strong> </li>
                      <li>Choose User or Search User </li>
                      <li>Click on <strong>Update Password</strong> Button</li>
                      <li>Enter New Password</li>
                      <li>Enter New Password Again</li>
                      <li>Click on <strong>Update Password</strong> Button</li> 
                     </ul>                     
                  </div>                 
                <!--//row--> 
              </div> 
                 <div class="section-block" id="ban-unban">
              	<h3 class="section-title">Ban or Activate Users</h3>
                <br />
                <div class="row">
                  <div class="col-md-6 col-12"> 
                    <ul class="list">
                       <li>Click on <strong>User Management</strong> </li>
                      <li>Choose User or Search User </li>
                      <li>Click on <strong class="btn btn-warning btn-sm">Ban User</strong> to Ban or Deactivate User </li>
                      <li>Click on <strong class="btn btn-light btn-sm" >Activate User</strong> to Activate or Unban User </li>
                     </ul>                     
                  </div>
                   <!--//row--> 
              </div>              
              <div class="section-block" id="prom-demot">
              	<h3 class="section-title">Promote or Demote Users</h3>
                <br />
                <div class="row">
                  <div class="col-md-6 col-12"> 
                    <ul class="list">
                       <li>Click on <strong>User Management</strong> </li>
                      <li>Choose User or Search User </li>
                      <li>Click on <strong  class="btn btn-success btn-sm" >Make Owner</strong> to Up Grade User to Owner </li>
                      <li>Click on <strong class="btn btn-danger btn-sm">Demote to Staff</strong> to Down Grade User to Staff</li>  </ul>                     
                  </div>                 
                <!--//row--> 
              </div>              
              <div class="section-block" id="delete-user">
              	<h3 class="section-title">Delete Users</h3>
                <br />
                <div class="row">
                  <div class="col-md-6 col-12"> 
                    <ul class="list">
                       <li>Click on <strong>User Management</strong> </li>
                      <li>Choose User or Search User </li>
                      <li>Click on <strong class="btn btn-danger btn-sm">Delete User</strong> to Delete User</li>                       
                      <li>To <strong>Delete Owner Account -</strong>                       		
                            <ul>
                            	<li>Demote User to <strong class="btn btn-danger btn-sm">Demote to Staff</strong>. Then - </li>
                                <li>Click on <strong class="btn btn-danger btn-sm">Delete User</strong> to Delete User Account</li>
                            </ul>                        
                      </li> </ul>                     
                  </div>                 
                <!--//row--> 
              </div>              
              <section id="cat-management" class="doc-section">
                  <h2 class="section-title">Category Management</h2>
                  <div class="section-block">
                    <p> Income and Expense Category Management. </p>                    
                    <h3 id="create-cat">Creating Category</h3>
                    <hr />
                    <ul class="list">
                      <li>Click on <strong>Category</strong> from Left Menu </li>
                      <li>Click on  <strong class="btn btn-warning btn-sm">Add Expense Category</strong> button to Add Expense Category or Click on <strong class="btn btn-success btn-sm">Add Income Category</strong> to add Income Category </li>
                      <li>Fill The Form </li>
                      <li>To Create Sub Category Select Parent Category or Leave it as it is.</li>
                      <li>Click on <strong class="btn btn-primary btn-sm">Craete Expense Category</strong> to Create Expense Category</li>
                      <li> or for Income Category Click on <strong class="btn btn-primary btn-sm">Add Income Category</strong> Button </li> 
                      <li> Category Created Successfully</li>                      
                      <li> Repeat this process as much as you need</li>                      
                     </ul>                     
                  </div>                  
                  <h4>Category Caeation Video Tutorial -</h4>                  
                   <div class="embed-responsive embed-responsive-16by9">                   
                      <iframe src="https://www.youtube.com/embed/xEBFU4oBW6s" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                   </div>                   
                   <br /><br />
                    <h3 id="cat-view-edit-update-delete">Category View, Edit, Update and Delete</h3>
                    <hr />                    
                    <h4>Category View, Edit, Update and Delete Video Tutorial -</h4>                  
                   <div class="embed-responsive embed-responsive-16by9">                   
                      <iframe src="https://www.youtube.com/embed/ItNgGBecU-c" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                   </div>   
                 <br /><br />
                    <h3 id="cat-report">Category Wise Report</h3>
                    <hr />                    
                    <h4>Category Wise Income and Expense Reports Video Tutorial -</h4>                  
                   <div class="embed-responsive embed-responsive-16by9">                   
                      <iframe src="https://www.youtube.com/embed/9NfpzyZlKdM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                   </div>                   
                  </div>   
                 </section>              
              <section id="income-management" class="doc-section">
                  <h2 class="section-title">Income Management</h2>
                  <br />
                  <p>How to - View Income, Add Income, Edit Income, Delete Income, Search Income, Print Income</p>
                  <div class="section-block">                  
                    <h3> View, Search and Printing Income Listings  </h3>   
                     <hr />
                      <ul class="list">
                        <li>Click on <strong>Income</strong> from Left Menu. You will See Income Listings of Current Month. </li>
                        <li>Click on <strong class="btn btn-danger btn-sm">Change Date </strong> Button and Choose Desired Income Listing Date Range   </li>
                        <li>You Can Search Income Using Search Box. </li>
                        <li>Click <strong class="btn btn-danger btn-sm">Print</strong> Button To Print Income Listings after search or Choosing Income Date</li>                                                
                       </ul>                    
                      <h3> Adding New Income  </h3>      <hr />
                      <ul class="list">
                        <li>Click on <strong class="btn btn-success btn-sm">Add New Income </strong> Button to Add Income</li>
                        <li>Fill The Form - 
                        	<ul>
                            	<li>Choose Category</li>
                                <li>Enter Amount</li>
                                <li>Enter Purpose</li>
                                <li>Enter Details <small>Not Important</small></li>
                                <li>Select Date and Time</li>
                                <li>Enter Reference <small>Examples - Person Name, Check Book No. etc.. Not Mendatory </small></li>
                                <li>Select Transection Status <small>It will help to track payment processed or not. Example - You may got a Check but Did not Got Cash etc... </small></li>
                            </ul>
                        </li>
                        <li>Press on Submit Button</li>
                        <li>New Income Added Successfully</li>                                                                      
                       </ul>                       
                  </div>                  
                  <br />
                  <h4>Video Tutorial for Income Management</h4>
                   <div class="embed-responsive embed-responsive-16by9">
                      <iframe src="https://www.youtube.com/embed/1lJR3ZprqtU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                   </div>                                  
              </section>              
              <section id="expense-management" class="doc-section">
                  <h2 class="section-title">Expense Management</h2>
                 <br />
                  <p>How to - View Expense, Add Expense, Edit Expense, Delete Expense, Search Expense, Print Expense</p>
                  <div class="section-block">                  
                    <h3> View, Search and Printing Expense Listings  </h3>    
                      <hr />
                      <ul class="list">
                        <li>Click on <strong>Expense</strong> from Left Menu. You will See Expense Listings of Current Month. </li>
                        <li>Click on <strong class="btn btn-danger btn-sm">Change Date </strong> Button and Choose Desired Expense Listing Date Range   </li>
                        <li>You Can Search Expense Using Search Box. </li>
                        <li>Click <strong class="btn btn-danger btn-sm">Print</strong> Button To Print Expense Listings after search or Choosing Expense Date</li>                                                
                       </ul>                    
                      <h3> Adding New Expense  </h3> <hr />
                      <ul class="list">
                        <li>Click on <strong class="btn btn-success btn-sm">Add New Expense </strong> Button to Add Expense</li>
                        <li>Fill The Form - 
                        	<ul>
                            	<li>Choose Category</li>
                                <li>Enter Amount</li>
                                <li>Enter Purpose</li>
                                <li>Enter Details <small>Not Important</small></li>
                                <li>Select Date and Time</li>
                                <li>Enter Reference <small>Examples - Person Name, Check Book No. etc.. Not Mendatory </small></li>
                                <li>Select Transection Status <small>It will help to track payment processed or not. Example - You may got a Check but Did not Got Cash etc... </small></li>
                            </ul>
                        </li>
                        <li>Press on Submit Button</li>
                        <li>New Expense Added Successfully</li>                                                                        
                       </ul>                     
                  </div>                  
                    <h4>Video Tutorial for Expense Management</h4>
                   <div class="embed-responsive embed-responsive-16by9">
                      <iframe src="https://www.youtube.com/embed/Jp-IbeoMNfw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                   </div>                                   
              </section>              
              <section id="report" class="doc-section">
                  <h2 class="section-title">Report</h2>
                  <div class="section-block">
                    <ul class="list">
                        <li>Click on <strong>Reports</strong> from Left Menu. You will See Income and Expense Listings of Current Month. </li>
                        <li>Click on <strong class="btn btn-danger btn-sm">Change Date </strong> Button and Choose Desired Income and Expense Listing Date Range   </li>                       
                        <li>Click <strong class="btn btn-danger btn-sm">Print</strong> Button To Print Income Listings after search or Choosing Income Date</li>                                                
                       </ul>
                  </div>        
              </section>
          </div>
          <!--//content-inner--> 
        </div>
        <!--//doc-content-->
        <div class="doc-sidebar col-md-3 col-12 order-0 d-none d-md-flex">
          <div id="doc-nav" class="doc-nav">
            <nav id="doc-menu" class="nav doc-menu flex-column sticky"> 
            	<a class="nav-link scrollto" href="#requirements-section">Requirements</a> 
                <a class="nav-link scrollto" href="#installation-section">Installation</a>
                  <nav class="doc-sub-menu nav flex-column"> 
                      <a class="nav-link scrollto" href="#step-1">Requirements</a> 
                      <a class="nav-link scrollto" href="#step-1_1">Step One</a>
                      <a class="nav-link scrollto" href="#step-1_2">Step Two</a> 
                  </nav>
                <a class="nav-link scrollto" href="#config">System Configuration</a>
                <a class="nav-link scrollto" href="#change-password">Changing Password</a> 
            	<a class="nav-link scrollto" href="#user-management">User Management</a>
                 <!-- <nav class="doc-sub-menu nav flex-column">
                    <a class="nav-link scrollto" href="#view-users">View Users</a> 
                    <a class="nav-link scrollto" href="#create-user">Create New User</a> 
                    <a class="nav-link scrollto" href="#update-user-pass">Update User Passwords</a> 
                    <a class="nav-link scrollto" href="#ban-unban">Ban or Activate User</a> 
                    <a class="nav-link scrollto" href="#prom-demot">Promote or Demote Users</a> 
                    <a class="nav-link scrollto" href="#delete-user">Delete Users</a> 
                   </nav>    -->          
                   <!--//nav--> 
                <a class="nav-link scrollto" href="#cat-management">Category Management</a>
                 <!-- <nav class="doc-sub-menu nav flex-column">                    <a class="nav-link scrollto" href="#create-cat">Create Category</a> 
                    <a class="nav-link scrollto" href="#cat-view-edit-update-delete">View, edit, update and Delete Category</a>                     
                    <a class="nav-link scrollto" href="#cat-report">Update Category</a> 
                   </nav> -->             
                   <!--//nav-->                    
                 <a class="nav-link scrollto" href="#income-management">Income Management</a>
                 <!-- <nav class="doc-sub-menu nav flex-column">
                    <a class="nav-link scrollto" href="#view-income">View Income</a> 
                    <a class="nav-link scrollto" href="#create-income">Add New Income</a> 
                    <a class="nav-link scrollto" href="#update-income">edit / Update Income</a>                    
                    <a class="nav-link scrollto" href="#delete-income">Delete Income</a>                     
                    <a class="nav-link scrollto" href="#search-income">Search Income</a> 
                    <a class="nav-link scrollto" href="#print-income">Print Incomes</a> 
                   </nav>     -->         
                   <!--//nav-->                   
                 <a class="nav-link scrollto" href="#expense-management">Expense Management</a>
                 <!-- <nav class="doc-sub-menu nav flex-column">
                    <a class="nav-link scrollto" href="#view-expense">View Expense</a> 
                    <a class="nav-link scrollto" href="#create-expense">Add New Expense</a> 
                    <a class="nav-link scrollto" href="#update-expense">edit / Update Expense</a>                    
                    <a class="nav-link scrollto" href="#delete-expense">Delete Expense</a>                     
                    <a class="nav-link scrollto" href="#search-expense">Search Expense</a> 
                    <a class="nav-link scrollto" href="#print-expense">Print Expenses</a> 
                   </nav>    -->          
                   <!--//nav-->                    
                 <a class="nav-link scrollto" href="#reports">Reports</a>
          </div>
        </div>
        <!--//doc-sidebar--> 
      </div>
      <!--//doc-body--> 
    </div>
    <!--//container--> 
  </div>
  <!--//doc-wrapper-->
  
  
</div>
<!--//page-wrapper-->

<footer id="footer" class="footer text-center">
  <div class="container"> 
    <!--/* This template is released under the Creative Commons Attribution 3.0 License. Please keep the attribution link below when using for your own project. Thank you for your support. :) If you'd like to use the template without the attribution, you can buy the commercial license via our website: themes.3rdwavemedia.com */--> 
    <small class="copyright">Powered By <a href="https://www.sbtechvalley.com/" target="_blank">SB TechValley</a> with  <i class="fas fa-heart"></i> </small> </div>
  <!--//container--> 
</footer>
<!--//footer--> 

<!-- Main Javascript --> 
<script type="text/javascript" src="assets/plugins/jquery-3.3.1.min.js"></script> 
<script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="assets/plugins/prism/prism.js"></script> 
<script type="text/javascript" src="assets/plugins/jquery-scrollTo/jquery.scrollTo.min.js"></script> 
<script type="text/javascript" src="assets/plugins/stickyfill/dist/stickyfill.min.js"></script> 
<script type="text/javascript" src="assets/js/main.js"></script>
</body>
</html>
