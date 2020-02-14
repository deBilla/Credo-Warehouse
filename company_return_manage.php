<?php
require_once('includes/load.php');
$page_title = 'Company Return';
$all_categories = find_all('products');
$stock_received = find_all('company_return');
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
              window.location = "company_return_edit.php?id=" +bool;
          } else {
              swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#myModal').modal('hide');
      });

      $('#delete_button').click(function() {
        var password = document.getElementById("delete_password").value;
        var bool = document.getElementById("user_d").value;
          if (password == <?php echo $password['password'];?>){
              delete_bill(bool, "company_return_receive");
          } else {
              swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#deleteModal').modal('hide');
      });

      $('#delete_all_button').click(function() {
        var password = document.getElementById("delete_all_password").value;
        var bool = document.getElementById("user_delete").value;
          if (password == <?php echo $password['password'];?>){
              delete_bill(bool, "company_return");
          } else {
              swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#deleteAllModal').modal('hide');
      });

      $('#add_button').click(function() {
        var password = document.getElementById("add_password").value;
        var bool = document.getElementById("user_add").value;
          if (password == <?php echo $password['password'];?>){
              $(".modal-body #addInv").val( bool );
              $('#addNowModal').modal('show');
          } else {
              swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#addModal').modal('hide');
      });

      $('#add_now_button').click(function() {
        var productid = document.getElementById("productid").value;
        var quantity = document.getElementById("quantity").value;
        var invN = document.getElementById("addInv").value;
          $.ajax({//create an ajax request to customer_find.php
                type: "GET",
                data: {ok: 1, inv: invN, pid : productid,qty : quantity},
                url: "company_return_add_new.php",             
                dataType: "html",   //expect html to be returned                
                success: function(value){ 
                  var data = value.split(",");  
                  x = Number(data[0]);
                  if(x==1){
                    swal("Success!", "Added successfully", "success");
                    location.reload();
                  }else{
                    swal("Failed!", "Failed to add"+data[0], "danger");
                  }     
                }
        });
        $('#addNowModal').modal('hide');
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
if(isset($_POST['save_add']))   
{
  $id = $_GET['inv'];
  $query_r = "INSERT INTO company_return_receive SET invoice_number = '{$_GET['inv']}',product_id = '{$_POST['productid']}',quantity = '{$_POST['quantity']}'";
  $db->query($query_r); 
}  

?>
  <div class="panel">
          <div class="col-md-12">
             <?php echo display_msg($msg); ?>
          </div>
        <div class="panel panel-default">
        <div class="panel-heading clearfix">
              <div class="col-md-12 column">
              <div class="pull-right">
                <a href="company_return_add.php" class="btn btn-primary">Add New</a>
              </div>
            </div>
          </div>
      </br>
      <div class="panel clearfix">
      <table id="userRequestList" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center"> Invoice Number </th>
                <th class="text-center"> Date</th>
                <th class="text-center"> Products</th>
              </tr> 
            </thead>
            <tbody>
              <?php foreach ($stock_received as $product_n):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td class="text-center"> <?php echo remove_junk($product_n['invoice_number']); 
                $table = 1;
                ?>
                  <input type="button" onclick="delete_all(<?php echo (int)$product_n['id'];?>)" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip" value = "Delete">
                </td>
                <td class="text-center"> <?php echo remove_junk($product_n['date']); ?></td>
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
                    <?php $product_w = join_return_by_id($product_n['invoice_number']);
                      foreach($product_w as $product):?>
                    <tr>    
                      <td> <?php echo remove_junk($product['name']); ?></td>
                      <td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>
                      <td class="text-center">
                        <div class="btn-group">
                          <input type="button" onclick="edit_val(<?php echo (int)$product['id'];?>)" class="btn btn-info btn-xs"  title="Delete" data-toggle="tooltip" value = "Edit">
                          <input type="button" onclick="delete_val(<?php echo (int)$product['id'];?>)" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip" value = "Delete">
                          </a>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                  </table>
                  <input type="button" onclick="add_val(<?php echo (int)$product_n['invoice_number'];?>)" class="btn btn-success btn-xs"  title="Add" data-toggle="tooltip" value = "Add">
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
      </table>
      </div>
    </div>
</div>
<?php include_once('models/company_return/modal.php'); ?> 
