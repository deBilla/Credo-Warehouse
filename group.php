<?php
  $page_title = 'All Group';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
  $all_groups = find_all('user_groups');
   $password = find_by_id('data_protect','2');
?>
<?php include_once('layouts/header.php'); ?>
<link rel="stylesheet" href="libs/bootstrap/css/dataTables.bootstrap.css">
<link rel="stylesheet" href="libs/bootstrap/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="libs/bootstrap/css/buttons.dataTables.min.css">
<script type="text/javascript" src="libs/bootstrap/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="libs/1.js"></script>
<script type="text/javascript" src="libs/bootstrap/js/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="libs/bootstrap/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="libs/bootstrap/js/pdfmake.min.js"></script>
<script type="text/javascript" src="libs/bootstrap/js/vfs_fonts.js"></script>
<script type="text/javascript" src="libs/bootstrap/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="libs/bootstrap/js/sweetalert.min.js"></script>
<style type="text/css">
    .insideTable {
      width: 100%;
    }
</style>
<script>
    $( document ).ready(function() {
      
      $('#userRequestList').dataTable({
        "columnDefs": [
          {
            "targets": [ 0 ],
            "visible": true,
            "searchable": true
          },
          {
            "targets": [ 2 ],
            "visible": true,
            "searchable": true
          }
        ]
      });
      
      $('#assign_button').click(function() {
        var password = document.getElementById("user_password").value;
        var bool = document.getElementById("user_p").value;
          if (password == <?php echo $password['password'];?>){
              window.location = "edit_group.php?id=" +bool;
          } else {
              swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#myModal').modal('hide');
      });

      $('#delete_button').click(function() {
        var password = document.getElementById("delete_password").value;
        var bool = document.getElementById("user_d").value;
          if (password == <?php echo $password['password'];?>){
              delete_bill(bool, "user_groups");
          } else {
              swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#deleteModal').modal('hide');
      });

    });

     function delete_bill(bool,table){
      $.ajax({//create an ajax request to customer_find.php
        type: "GET",
        data: {id: bool, table: table},
        url: "delete_script.php",             
        dataType: "html",   //expect html to be returned                
        success: function(value){ 
          var data = value.split(",");  
          x = Number(data[0]);
          if(x==1){
            swal("Success!", "Deleted successfully", "success");
            location.reload();
          }else{
            swal("Failed!", "Failed to Delete"+data[0], "danger");
          }     
        }
      });
    }

    function edit_val(id_get){
      $('#myModal').modal('show');
      $(".modal-body #user_p").val( id_get );
    }

    function delete_val(id_get){
      $('#deleteModal').modal('show');
      $(".modal-body #user_d").val( id_get );
    }
</script>
<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Groups</span>
     </strong>
       <a href="add_group.php" class="btn btn-info pull-right btn-sm"> Add New Group</a>
    </div>
     <div class="panel-body">
      <table id="userRequestList" class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th>Group Name</th>
            <th class="text-center" style="width: 20%;">Group Level</th>
            <th class="text-center" style="width: 15%;">Status</th>
            <th class="text-center" style="width: 100px;">Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($all_groups as $a_group): ?>
          <tr>
           <td class="text-center"><?php echo count_id();?></td>
           <td><?php echo remove_junk(ucwords($a_group['group_name']))?></td>
           <td class="text-center">
             <?php echo remove_junk(ucwords($a_group['group_level']))?>
           </td>
           <td class="text-center">
           <?php if($a_group['group_status'] === '1'): ?>
            <span class="label label-success"><?php echo "Active"; ?></span>
          <?php else: ?>
            <span class="label label-danger"><?php echo "Deactive"; ?></span>
          <?php endif;?>
           </td>
           <td class="text-center">
              <div class="btn-group">
                <input type="button" onclick="edit_val(<?php echo (int)$a_group['id'];?>)" class="btn btn-info btn-xs"  title="Delete" data-toggle="tooltip" value = "Edit">
                <input type="button" onclick="delete_val(<?php echo (int)$a_group['id'];?>)" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip" value = "Delete">
              </div>
          </td>
          </tr>
        <?php endforeach;?>
       </tbody>
     </table>
     </div>
    </div>
  </div>
</div>
 <!-- Modal this is used to take the password to edit-->
<div id="myModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Enter the password</h4>
          </div>
          <div class="modal-body">
              <p id="modal_body_txt"></p>
              
              <!-- Select Basic -->
        <div class="control-group">
          <div class="controls">
            <input id="user_p" name="id" type="hidden" placeholder="" class="form-control" required="" value="">
            <input id="user_password" name="password" type="password" placeholder="password" class="form-control" required="">
          </div>
        </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" id="assign_button" class="btn btn-success">Proceed</button>
          </div>
      </div>
  </div>
</div>
<!-- Modal this is used to take the password to delete-->
<div id="deleteModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Enter the password</h4>
          </div>
          <div class="modal-body">
              <p id="modal_body_txt"></p>
              
              <!-- Select Basic -->
        <div class="control-group">
          <div class="controls">
            <input id="user_d" name="id" type="hidden" placeholder="" class="form-control" required="" value="">
            <input id="delete_password" name="password" type="password" placeholder="password" class="form-control" required="">
          </div>
        </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" id="delete_button" class="btn btn-success">Proceed</button>
          </div>
      </div>
  </div>
</div>
  <?php include_once('layouts/footer.php'); ?>
