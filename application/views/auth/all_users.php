<div class="clearfix"></div>
<div class="x_panel">
   <div class="x_title">
      <a class="btn btn-primary" href="<?php echo base_url(); ?>auth/create_user">Create New Users </a>
      <div class="clearfix"></div>
   </div>
   <div class="x_content">
      <div class="panel-body">
         <table id="btn-table" class="table table-striped table-bordered" >
            <thead>
               <tr>
                  <th>SL.</th>
                  <th>Full Name <br />
                     Username
                  </th>
                  <th>Type</th>
                  <th>Phone <br />
                     Email
                  </th>
                  <th>Status</th>
                  <th>...</th>
               </tr>
            </thead>
            <tbody>
               <?php 
                  $i=1;
                  
                  foreach($qry_users->result() as $qry_users_res)
                  {
					  
                   	if($qry_users_res->user_type==1)
                   	{
                   
						echo ' <tr style="background: #ff00000f;">';
						  echo ' <td>'.$i.'.</td>';
					  
						  echo ' <td><span class="text-uppercase">'.$qry_users_res->full_name.'</span> <br /> @ '.$qry_users_res->username.'</td>';
						  echo ' <td> <span class="label label-success"> Owner </span> </td>';
						  
						  echo ' <td>'.$qry_users_res->phone.'  <br /> '.$qry_users_res->email.'</td>';
						 
						  echo ' <td>'.($qry_users_res->banned == 0 ? '<span class="label label-success">Active</span> ' : '<span class="label label-danger">Banned</span> ').' <br /> <a style="margin-top:5px;" href="'.base_url().'auth/update_password/'.$qry_users_res->id.'" class="btn btn-default btn-sm">Update Password </a></td>';
						  
						echo '<td>';
						
						if($this->tank_auth->get_user_id() != $qry_users_res->id)
						{
							  if($qry_users_res->banned == 0)
							  {
								  echo '                
										  <a style="margin-top:5px;" href="'.base_url().'auth/ban_user/'.$qry_users_res->id.'" class="btn btn-warning btn-sm">Ban User
											  </a>';
							  }
							  else 
							  {
								  echo '                
										  <a style="margin-top:5px;" href="'.base_url().'auth/unban_user/'.$qry_users_res->id.'" class="btn btn-default btn-sm">Activate User
											  </a> ';
							  }
							  
							   echo '  <a style="margin-top:5px;" href="'.base_url().'auth/make_staff/'.$qry_users_res->id.'" class="btn btn-danger btn-sm">Demote to Staff</a> '; 
						}
						
						
						
						 
						
						echo '	</td>
								  </tr>';
						
						$i++;
					   }
					   
					   if($qry_users_res->user_type != 1)
					   {
					   
						echo ' <tr>';
						  echo ' <td>'.$i.'.</td>';
					  
						  echo ' <td><span class="text-uppercase">'.$qry_users_res->full_name.'</span> <br /> @ '.$qry_users_res->username.'</td>';
					  
						  echo ' <td>'.($qry_users_res->user_type == 2 ? 'Admin' : '<span class="label label-info">Staff</span>').'</td>';
						  
						  echo ' <td>'.$qry_users_res->phone.'  <br /> '.$qry_users_res->email.'</td>'; 
						 
						  echo ' <td>'.($qry_users_res->banned == 0 ? '<span class="label label-success">Active</span> ' : '<span class="label label-danger">Banned</span> ').' <br /> <a style="margin-top:5px;" href="'.base_url().'auth/update_password/'.$qry_users_res->id.'" class="btn btn-default btn-sm">Update Password </a></td>';
						  
						  echo '<td>';
					  
						  if($qry_users_res->banned == 0)
						  {
							  echo '                
									  <a style="margin-top:5px;" href="'.base_url().'auth/ban_user/'.$qry_users_res->id.'" class="btn btn-warning btn-sm">Ban User
										  </a>';
						  }
						  else 
						  {
							  echo '                
									  <a style="margin-top:5px;" href="'.base_url().'auth/unban_user/'.$qry_users_res->id.'" class="btn btn-default btn-sm">Activate User
										  </a>';
						  }
						  
						  echo '  <a style="margin-top:5px;" href="'.base_url().'auth/make_owner/'.$qry_users_res->id.'" class="btn btn-success btn-sm">Make Owner</a> '; 
						  echo ' <br /> <a style="margin-top:5px;" href="'.base_url().'auth/delete_user/'.$qry_users_res->id.'" class="btn btn-danger btn-xs">Delete User</a> '; 
						
						echo '	</td>
								  </tr>';
						
						$i++;
                   	}
                  }
                  ?>
            </tbody>
         </table>
      </div>
   </div>
</div>