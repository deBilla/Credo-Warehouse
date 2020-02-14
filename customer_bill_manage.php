<?php
require_once('includes/load.php');
$page_title = 'Customer Bills';
$all_categories = find_all('products');
$customer_bill = find_all('customer_bill_receive');
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
            "targets": [ 4 ],
            "visible": true,
            "searchable": true
          }
        ]
      });
      
      $('#assign_button').click(function() {
        var password = document.getElementById("user_password").value;
        var bool = document.getElementById("user_p").value;
          if (password == <?php echo $password['password'];?>){
              window.location = "customer_bill_edit.php?id=" +bool;
          } else {
              swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#myModal').modal('hide');
      });

      $('#delete_button').click(function() {
        var password = document.getElementById("delete_password").value;
        var bool = document.getElementById("user_d").value;
          if (password == <?php echo $password['password'];?>){
              delete_bill(bool, "customer_bill");
          } else {
              swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#deleteModal').modal('hide');
      });

      $('#delete_all_button').click(function() {
        var password = document.getElementById("delete_all_password").value;
        var bool = document.getElementById("user_delete").value;
          if (password == <?php echo $password['password'];?>){
             delete_bill(bool, "customer_bill_receive");
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
        var free_quantity = document.getElementById("free_quantity").value;
        var discount_quantity = document.getElementById("discount_quantity").value;
        var received_return = document.getElementById("received_return").value;
        var reissued = document.getElementById("reissued").value;
        var invN = document.getElementById("addInv").value;
          $.ajax({//create an ajax request to customer_find.php
                type: "GET",
                data: {ok: 1, inv: invN, pid : productid,qty : quantity, free_qty: free_quantity, dsc: discount_quantity, rec: received_return, reiss: reissued},
                url: "customer_bill_add_new.php",             
                dataType: "html",   //expect html to be returned                
                success: function(value){ 
                  var data = value.split(",");  
                  x = Number(data[0]);
                  if(x==1){
                    swal("Success!", "Added successfully", "success");
                    location.reload();
                  }else{
                    swal("Failed!", "Failed to add"+x, "danger");
                  }     
                }
        });
        $('#addNowModal').modal('hide');
      });

      $('#delete_now_button').click(function() {
        var productid = document.getElementById("productid").value;
        var quantity = document.getElementById("quantity").value;
        var free_quantity = document.getElementById("free_quantity").value;
        var discount_quantity = document.getElementById("discount_quantity").value;
        var received_return = document.getElementById("received_return").value;
        var reissued = document.getElementById("reissued").value;
        var invN = document.getElementById("addInv").value;
          
        $('#addNowModal').modal('hide');
      });
    });

    function credit_modal(inv1){
      var inv_no = inv1;
      $.ajax({//create an ajax request to customer_find.php
        type: "GET",
        data: {ok: 1, inv: inv_no},
        url: "credit_recover_invoice.php",             
        dataType: "html",   //expect html to be returned                
        success: function(value){ 
          var data = value.split(",");  
          document.getElementById('modalInvoice').innerHTML = inv_no;
          document.getElementById('modalDate').innerHTML = data[0];
          document.getElementById('modalRoute').innerHTML = data[4];
          document.getElementById('modalCredit').innerHTML = data[1];
          document.getElementById('modalName').innerHTML = data[2];
          document.getElementById('modalPaid').innerHTML = (data[1]-data[3]).toFixed(2);
        }
      });
      $('#creditModal').modal('show');
    }

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
  $query_r = "INSERT INTO customer_bill SET invoice_number = '{$id}',product_id = '{$_POST['productid']}',quantity = '{$_POST['quantity']}',free_quantity = '{$_POST['free_quantity']}',discount_quantity = '{$_POST['discount_quantity']}',received_return = '{$_POST['received_return']}',reissued = '{$_POST['reissued']}'";
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
              <div class="col-xs-5">
                  <span class="glyphicon glyphicon-th"></span>
                  <b>Customer Bills</b>
               </div>
               <div class="col-xs-5">
                <a href="customer_bill_add.php" class="btn btn-primary">Add New</a>
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
                <th class="text-center"> Customer </th>
                <th class="text-center"> Date </th>
                <th class="text-center"> Products </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($customer_bill as $product_n):
                $customer = find_by_id('customer',$product_n['customer_id']);
              ?>
              <tr>
                <td class="text-center"><?php echo count_id();?>
                  <input type="button" onclick="delete_all(<?php echo (int)$product_n['id'];?>)" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip" value = "Delete">
                </td>
                <td class="text-center"><input id="creditShow" type="button" onclick="credit_modal(<?php echo (int)$product_n['invoice_number'];?>)" class="btn btn-info btn-xs" value = "<?php echo remove_junk($product_n['invoice_number']); ?>">
                </td>
                <td class="text-center"> <?php echo remove_junk($customer['name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product_n['date']); ?></td>
                <td class="text-center">
                  <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="text-center" > Product Name </th>
                      <th class="text-center" > Quantity </th>
                      <th class="text-center" > Free Quantity </th>
                      <th class="text-center" > Discount Quantity </th>
                      <th class="text-center" > Received Return </th>
                      <th class="text-center" > Return reissued </th>
                      <th class="text-center" > Actions </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $product_w = join_customer_by_id($product_n['invoice_number']);
                      foreach($product_w as $product):?>
                    <tr>   
                      <td> <?php echo remove_junk($product['name']); ?></td>
                      <td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>
                      <td class="text-center"> <?php echo remove_junk($product['free_quantity']); ?></td>
                      <td class="text-center"> <?php echo remove_junk($product['discount_quantity']); ?></td>
                      <td class="text-center"> <?php echo remove_junk($product['received_return']); ?></td>
                      <td class="text-center"> <?php echo remove_junk($product['reissued']); ?></td>
                      <td class="text-center">
                        <div class="btn-group">
                          <input id="edit" type="button" onclick="edit_val(<?php echo (int)$product['id'];?>)" class="btn btn-info btn-xs"  title="Delete" data-toggle="tooltip" value = "Edit">
                          <input type="button" onclick="delete_val(<?php echo (int)$product['id'];?>)" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip" value = "Delete">
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
<?php include_once('models/customer_bill/modal.php'); ?>
<!-- Modal -->
</div>
<div id="creditModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="pull-right">
              <h3><label id="modalDate" class="label label-warning"></label></h3>
            </div>
            <div class="pull-left">
              <h3><label id="modalInvoice" class="label label-primary"></label></h3>
            </div>
            <div class="pull-left">
              <h3><label id="modalName" class="label label-success"></label></h3>
            </div>
            <div class="pull-left">
              <h3><label id="modalRoute" class="label label-info"></label></h3>
            </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-6">
                <b>Credit Amount : </b><h3>Rs. <label id="modalCredit" class="label label-primary"></label></h3>
              </div>
              <div class="col-sm-6">
                <b>Credit Remain : </b><h3>Rs. <label id="modalPaid" class="label label-danger"></label></h3>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
          </div>
        </div>
    </div>
</div>