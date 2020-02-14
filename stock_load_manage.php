<?php
require_once('includes/load.php');
$page_title = 'Stock Loading';
$products = join_product_table();
$stock = find_all('stock_load_receive');
$password = find_by_id('data_protect','1');
include_once('layouts/header.php');
?>  
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
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4'
            }
        ],
        "columnDefs": [
          {
            "targets": [ 0 ],
            "visible": true,
            "searchable": true
          },
          {
            "targets": [ 3 ],
            "visible": true,
            "searchable": true
          }
        ]
      });
      
      $('#assign_button').click(function() {
        var password = document.getElementById("user_password").value;
        var bool = document.getElementById("user_p").value;
          if (password == <?php echo $password['password'];?>){
              window.location = "stock_load_manage_edit.php?id=" +bool;
          } else {
              swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#myModal').modal('hide');
      });

      $('#delete_button').click(function() {
        var password = document.getElementById("delete_password").value;
        var bool = document.getElementById("user_d").value;
          if (password == <?php echo $password['password'];?>){
              delete_bill(bool, "stock_load");
          } else {
              swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#deleteModal').modal('hide');
      });

      $('#delete_all_button').click(function() {
        var password = document.getElementById("delete_all_password").value;
        var bool = document.getElementById("user_delete").value;
          if (password == <?php echo $password['password'];?>){
              delete_bill(bool, "stock_load_receive");
          } else {
             swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#deleteAllModal').modal('hide');
      });

      $('#add_button').click(function() {
        var password = document.getElementById("add_password").value;
        var bool = document.getElementById("user_add").value;
          if (password == <?php echo $password['password'];?>){
              window.location = "stock_load_manage_edit_add.php?id=" + bool;
          } else {
              swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#addModal').modal('hide');
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

    function add_val(id_get){
      $('#addModal').modal('show');
      $(".modal-body #user_add").val( id_get );
    }

    function delete_all(id_get){
      $('#deleteAllModal').modal('show');
      $(".modal-body #user_delete").val( id_get );
    }
</script>
<?php
if(isset($_GET['ok'])){
  $productname = $_GET['productid'];
  $id_update = $_GET['edit'];
  $quantity = $_GET['quantity'];
  $query_r = "update stock_load set product_id='{$productname}', quantity='{$quantity}' where id = '{$id_update}'";
  $result_r = $db->query($query_r);
}
if(isset($_POST['save_add']))  
{ 
$query_t = "UPDATE stock_load_receive SET route_id = '{$_POST['route_id']}' WHERE date = '{$_GET['date_add']}'";
$db->query($query_t);

if($_POST['productid']==''){
  $session->msg('s',"no items to add but updated ");
  redirect('stock_load_manage.php', false);
}else{
  $query_r = "INSERT INTO stock_load SET date = '{$_GET['date_add']}',product_id = '{$_POST['productid']}',quantity = '{$_POST['quantity']}'";
  $db->query($query_r);
}
} 
?>
  <div class="panel">
          <div class="col-md-12">
             <?php echo display_msg($msg); ?>
          </div>
        <div class="panel panel-default">
        <div class="panel-heading clearfix">
              <div class="col-md-12 column">
              <div class="col-xs-5">
                <span class="glyphicon glyphicon-th"></span>
                  <b>Stock Loading</b>
             </div>
             <div class="col-xs-5">
                <a href="stock_load.php" class="btn btn-primary">Add New</a>
              </div>
            </div>
          </div>
      </br>
      <div class="panel clearfix">
      <table id="userRequestList" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
          <thead>
              <tr>
                <th class="text-center">#</th>
                <th> Date </th>
                <th class="text-center"> Route Name </th>
                <th class="text-center"> Products</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($stock as $product_n):

              $route = find_by_id('routes',$product_n['route_id']);

              ?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td class="text-center"> <?php echo remove_junk($product_n['date']);?>
                  <input type="button" onclick="delete_all(<?php echo (int)$product_n['id'];?>)" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip" value = "Delete">
                </td>
                <td class="text-center"> <?php echo remove_junk($route['name']); ?></td>
                <td class="text-center">
                  <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="text-center" > Product Name </th>
                      <th class="text-center" > Quantity </th>
                      <th class="text-center" > Actions </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $product_w = join_load_by_date($product_n['date']);
                      foreach($product_w as $product):?>
                    <tr>    
                      <td> <?php echo remove_junk($product['name']); ?></td>
                      <td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>
                      <td class="text-center">
                        <div class="btn-group">
                          <input type="button" onclick="edit_val(<?php echo (int)$product['id'];?>)" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip" value = "Edit">
                          <input type="button" onclick="delete_val(<?php echo (int)$product['id'];?>)" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip" value = "Delete">
                          </a>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                  </table>
                  <input type="button" onclick="add_val(<?php echo (int)$product_n['id'];?>)" class="btn btn-success btn-xs"  title="Add" data-toggle="tooltip" value = "Add">
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
      </table>
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
              <font color="red"><h3>You are about to delete</h3></font>
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
<!-- Modal this is used to take the password to Add-->
<div id="addModal" class="modal fade">
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
            <input id="user_add" name="id" type="hidden" placeholder="" class="form-control" required="" value="">
            <input id="add_password" name="password" type="password" placeholder="password" class="form-control" required="">
          </div>
        </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" id="add_button" class="btn btn-success">Proceed</button>
          </div>
      </div>
  </div>
</div>
<!-- Modal this is used to take the password to delete all-->
<div id="deleteAllModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <font color="red"><h3>You are about to delete</h3></font>
              <h4 class="modal-title">Enter the password</h4>
          </div>
          <div class="modal-body">
              <p id="modal_body_txt"></p>
              
              <!-- Select Basic -->
        <div class="control-group">
          <div class="controls">
            <input id="user_delete" name="id" type="hidden" placeholder="" class="form-control" required="" value="">
            <input id="delete_all_password" name="password" type="password" placeholder="password" class="form-control" required="">
          </div>
        </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" id="delete_all_button" class="btn btn-success">Proceed</button>
          </div>
      </div>
  </div>
</div>
