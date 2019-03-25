

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
