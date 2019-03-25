<form class="form-horizontal form-label-left input_mask" method="post" action="" style="min-height:400px;">
 
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Site Title</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" id="site_title" name="site_title" class="form-control" value="<?php echo $title; ?>" placeholder="Enter Site Title">
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"> </label>
    <div class="col-md-9 col-sm-9 col-xs-12">
       <div class="checkbox">
         <label>
           <input type="checkbox" id="remove_powered_by" name="remove_powered_by" <?php if($remove_powered_by==1) echo 'checked'; ?>> Remove Powered by - ColorEdges
         </label>
       </div>
    </div>
  </div>
  
 

  <div class="ln_solid"></div>
  <div class="form-group">
    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">      
      <button type="submit" class="btn btn-success">Update / Save</button>
    </div>
  </div>
</form>
