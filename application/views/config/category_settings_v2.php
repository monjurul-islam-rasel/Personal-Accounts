<?php
   /**
    * Created by PhpStorm.
    * User: Rasel, SB TechValley ( https://www.sbtechvalley.com )
    * Date: 7/23/2018
    * Time: 11:45 AM
    */
   ?>
<?php
   $isl = 1;
   
   $esl = 1;
   
   $income_cat = '<h1 style="text-align:center;" >Income Categories</h1>';
   
   $expense_cat = ' <div class="clearfix"></div><h1 style="text-align:center;" >Expense Categories</h1>';
   
   foreach ($qry_category->result() as $qry_cat_res) 
   {
   if($qry_cat_res->cat_type==1)
   {
   
   $income_cat.= '
   
   <div class="x_content panel-heading collapsed" style="background: #8eeb8f40;">
   <div class="col-md-8" style="float:left; text-align:left;">
   
   <h4 class="panel-title">' . $isl . '. <strong>' . $qry_cat_res->name . '</strong>
   
   ' . ($qry_cat_res->status == 1 ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Disabled</span>') . '
   
   <h4>' . $qry_cat_res->details . '</h4>
   ';
   
   $income_cat .= '<button class="btn btn-info btn-xs"' . 'onclick="view_cat_wise_inc_exp(' . "'" .  $qry_cat_res->id . "', '" . date('Y-m') . "', '" . date('Y-m') . "', '" . 'current_m' . "'" . ')">' . " View Report </button> ";
   
   $income_cat.= '				
   
   </div>
   
   <div class="col-md-4 col-xs-12" style="float: right!important; text-align:right; ">	
   <button class="btn btn-warning btn-xs" onclick="edit_category(' . $qry_cat_res->id . ')">Edit</button>
   
   <button class="btn btn-Danger btn-xs" onclick="delete_category(' . $qry_cat_res->id . ')">Delete</button>
   </div>
   
   <div class="clearfix"></div>
   
   <a style="background: #ededed; padding-left:10px; padding-right:10px;" class="btn btn-link btn-block"  id="cat_h_' . $qry_cat_res->id . '" data-toggle="collapse" data-parent="#accordion" href="#cat_' . $qry_cat_res->id . ' " aria-expanded="false" aria-controls="cat_' . $qry_cat_res->id . '">
   View Sub Categories  <i class="fa fa-chevron-down"></i>
   </a>
   
   </h4>   
   
   <div id="cat_' . $qry_cat_res->id . '" class="panel-collapse collapse" role="tabpanel"
   aria-labelledby="cat_h' . $qry_cat_res->id . '" aria-expanded="false" style="height: 0px;">
   <div class="panel-body" style="background: white !important;">
   <ul class="list-unstyled msg_list">
   ';
   $qry_sub_cat = $this->db->get_where('category', array('parent_id' => $qry_cat_res->id));
   
   $slc = 1;
   
   foreach ($qry_sub_cat->result() as $qry_sub_cat_res) {
   $income_cat.= '
   <li>
   
   <div class="x_content" style="">
    <div class="col-md-8" style="float:left; text-align:left;">
   ' . $slc . '. <strong>' . $qry_sub_cat_res->name . '</strong>
   ' . ($qry_sub_cat_res->status == 1 ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Disabled</span>') . '   
   
   <h4>' . $qry_sub_cat_res->details . '</h4>   
   
      ';   
      
   $income_cat .= '<button class="btn btn-info btn-xs"' . 'onclick="view_cat_wise_inc_exp(' . "'" .  $qry_sub_cat_res->id . "', '" . date('Y-m') . "', '" . date('Y-m') . "', '" . 'current_m' . "'" . ')">' . " View Report </button> ";  
   
   $income_cat.= '
   
    </div>
    
    <div class="col-md-4 col-xs-12" style="float: right!important; text-align:right; ">																	
   
   	<button class="btn btn-warning btn-xs" onclick="edit_category(' . $qry_sub_cat_res->id . ')">Edit</button>
   	<button class="btn btn-Danger btn-xs" onclick="delete_category(' . $qry_sub_cat_res->id . ')">Delete</button>
    </div>
   </div>
   
   </li>
   ';
   $slc++;
   }
   
   $income_cat.=	'		</ul>
   </div>
   </div>
   </div>';
   
   $isl++;
   }
   else 
   {  
   
   $expense_cat .= '
   
   <div class="x_content panel-heading collapsed" style="background:#f0ad4e26;">
   <div class="col-md-8" style="float:left; text-align:left;">
   
   <h4 class="panel-title">' . $esl . '. <strong>' . $qry_cat_res->name . '</strong>
   
   ' . ($qry_cat_res->status == 1 ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Disabled</span>') . '
   
   <h4>' . $qry_cat_res->details . '</h4>
   ';
   
   $expense_cat .= '<button class="btn btn-info btn-xs"' . 'onclick="view_cat_wise_inc_exp(' . "'" .  $qry_cat_res->id . "', '" . date('Y-m') . "', '" . date('Y-m') . "', '" . 'current_m' . "'" . ')">' . " View Report </button> ";
      
   $expense_cat .= '				
   
   </div>
   
   <div class="col-md-4 col-xs-12" style="float: right!important; text-align:right; ">	
   <button class="btn btn-warning btn-xs" onclick="edit_category(' . $qry_cat_res->id . ')">Edit</button>
   
   <button class="btn btn-Danger btn-xs" onclick="delete_category(' . $qry_cat_res->id . ')">Delete</button>
   </div>
   
   <div class="clearfix"></div>
   
   <a style="background: #ededed; padding-left:10px; padding-right:10px;" class="btn btn-link btn-block"  id="cat_h_' . $qry_cat_res->id . '" data-toggle="collapse" data-parent="#accordion" href="#cat_' . $qry_cat_res->id . ' " aria-expanded="false" aria-controls="cat_' . $qry_cat_res->id . '">
   View Sub Categories  <i class="fa fa-chevron-down"></i>
   </a>
      
   </h4>   
   
   <div id="cat_' . $qry_cat_res->id . '" class="panel-collapse collapse" role="tabpanel"
   aria-labelledby="cat_h' . $qry_cat_res->id . '" aria-expanded="false" style="height: 0px;">
   <div class="panel-body" style="background: white !important;">
   <ul class="list-unstyled msg_list">
   ';
   $qry_sub_cat = $this->db->get_where('category', array('parent_id' => $qry_cat_res->id));
   
   $slc = 1;
   
   foreach ($qry_sub_cat->result() as $qry_sub_cat_res) {
   $expense_cat .= '
   <li>
   
   <div class="x_content" style="">
    <div class="col-md-8" style="float:left; text-align:left;">
   ' . $slc . '. <strong>' . $qry_sub_cat_res->name . '</strong>
   ' . ($qry_sub_cat_res->status == 1 ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Disabled</span>') . '   
   
   <h4>' . $qry_sub_cat_res->details . '</h4>   
   
      ';
   
    $expense_cat .= '<button class="btn btn-info btn-xs"' . 'onclick="view_cat_wise_inc_exp(' . "'" .  $qry_sub_cat_res->id . "', '" . date('Y-m') . "', '" . date('Y-m') . "', '" . 'current_m' . "'" . ')">' . " View Report </button> ";
   
   $expense_cat .= '
   
    </div>
    
    <div class="col-md-4 col-xs-12" style="float: right!important; text-align:right; ">																	
   
   	<button class="btn btn-warning btn-xs" onclick="edit_category(' . $qry_sub_cat_res->id . ')">Edit</button>
   	<button class="btn btn-Danger btn-xs" onclick="delete_category(' . $qry_sub_cat_res->id . ')">Delete</button>
    </div>
   </div>
   
   </li>
   ';
   $slc++;
   }
   
   $expense_cat.=	'		</ul>
   </div>
   </div>
   </div>';
   
   
   $esl++;
   
   }
   }
   ?>
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
   <h2>All Business / Categories </h2>
   <ul class="nav navbar-right panel_toolbox" style="float:right; margin-top:5px;">
      <a href="#" onclick="add_exp_cat_form()" class="btn btn-warning"><i class="fa fa-plus"></i> Add Expense Category </a>
      <a href="#" onclick="add_inc_cat_form()" class="btn btn-success"><i class="fa fa-plus"></i> Add Income Category </a>
   </ul>
   <div class="clearfix"></div>
</div>
<div class="x_content">
   <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
      <?php
         echo $income_cat.'<br /><br />';
         
         echo $expense_cat;
         
         ?>
   </div>
</div>
<script>
   //-------------------------------------- cat inc exp function
   
   function add_inc_cat_form()
      {
          $("#myModalLabel").html('Add New Income Category');
          $("#myModalBody").html('<div class="loader"></div>');
          $('#myModal').modal('show');
   
          $.ajax({
              type: "post",
              url: "<?php echo site_url("config/ajax_load_form") ?>/",
              data: {form_name: 'config/inc_category_add_form'},
              success: function (html) {
                  $("#myModalLabel").html('New Income Category');
                  $("#myModalBody").html(html);
                  //$('#myModal').modal('show');
              },
              error: function (error) {
                  alert('Someting Wrong Happend. Please Try Again.');
              }
          });
      }
   
   function add_exp_cat_form()
      {
          $("#myModalLabel").html('Add New Expense Category');
          $("#myModalBody").html('<div class="loader"></div>');
          $('#myModal').modal('show');
   
          $.ajax({
              type: "post",
              url: "<?php echo site_url("config/ajax_load_form") ?>/",
              data: {form_name: 'config/exp_category_add_form'},
              success: function (html) {
                  $("#myModalLabel").html('New Expense Category');
                  $("#myModalBody").html(html);
                  //$('#myModal').modal('show');
              },
              error: function (error) {
                  alert('Someting Wrong Happend. Please Try Again.');
              }
          });
      }
   
   
   
   
   
   //--------------------------------------
   
   
   function add_new_cat_form()
      {
          $("#myModalLabel").html('Add New Category');
          $("#myModalBody").html('<div class="loader"></div>');
          $('#myModal').modal('show');
   
          $.ajax({
              type: "post",
              url: "<?php echo site_url("config/ajax_load_form") ?>/",
              data: {form_name: 'config/category_add_form'},
              success: function (html) {
                  $("#myModalLabel").html('New Category');
                  $("#myModalBody").html(html);
                  //$('#myModal').modal('show');
              },
              error: function (error) {
                  alert('Someting Wrong Happend. Please Try Again.');
              }
          });
      }
   
      function edit_category(id)
      {
          $("#myModalLabel").html('Edit Category');
          $("#myModalBody").html('<div class="loader"></div>');
          $('#myModal').modal('show');
   
          $.ajax({
              type: "post",
              url: "<?php echo site_url("config/ajax_load_form") ?>/",
              data: {form_name: 'config/category_edit_form', id: id},
              success: function (html) {
                  $("#myModalLabel").html('Edit Category');
                  $("#myModalBody").html(html);
                  $('#myModal').modal('show');
              },
              error: function (error) {
                  alert('Someting Wrong Happend. Please Try Again.');
              }
          });
      }
   
      function delete_category(cat_id) {
   
          var r = confirm("Are You Sure? It can't be undone!!");
          if (r == true) {
   
              $.ajax({
                  type: "post",
                  url: "<?php echo site_url("config/delete_category") ?>",
                  data: {cat_id: cat_id},
                  success: function (html) {
                      if (html == 1) {
                          alert('Deleted Successfully');
                          location.reload();
                      } else {
                          alert(html);
                      }
                  }
              });
          }
      }
   
      $(document).ready(function () {
          $('#datatable').DataTable({
              "order": [[0, "asc"]]
          });
      });
   
      function view_cat_wise_inc_exp(cat_id, from_dt, to_dt, type)
      {
          $('#myModal').modal('hide');
   
          $("#myModalLargeLabel").html('Category Wise Income/Expense Report');
          $("#myModalLargeBody").html('<div class="loader"></div>');
          $('#myModalLarge').modal('show');
   
          $.ajax({
              type: "post",
              url: "<?php echo site_url("config/get_category_wise_report_custom") ?>/",
              data: {form_name: 'config/category_wise_report', cat_id: cat_id, from_dt: from_dt, to_dt: to_dt, type: type},
              success: function (html) {
                  $("#myModalLargeLabel").html('Category Wise Income/Expense Report');
                  $("#myModalLargeBody").html(html);
                  //$('#myModalLarge').modal('show');
              },
              error: function (error) {
                  alert('Someting Wrong Happend. Please Try Again.');
              }
          });
      }
   
      function load_cat_wise_report_datepicker(cat_id) {
          $('#ModaldatePicker').modal('hide');
          view_cat_wise_inc_exp(cat_id, $("#date_from").val(), $("#date_to").val(), 'custom');
      }
   
      function cat_wise_report_datepicker(cat_id)  // custom listoing datepicker loader
      {
          $("#ModaldatePickerLabel").html('Choose Custom Date Range');
          $("#ModaldatePickerSubmitBtn").html('Load Report');
   
          $('#ModaldatePicker').modal('show');
   
          $("#ModaldatePickerSubmitBtn").attr("onclick", "load_cat_wise_report_datepicker(" + cat_id + ")");
   
      }
   
</script>