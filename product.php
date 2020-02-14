<?php
require_once('includes/load.php');
$page_title = 'Products';
$products = join_product_table();
$stock = join_stock_table();
$all_routes = find_all('stock_receive');
$password = find_by_id('data_protect','1');
$stock_received = find_all('stock_receive');
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
              window.location = "edit_product.php?id=" +bool;
          } else {
              swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#myModal').modal('hide');
      });

      $('#delete_button').click(function() {
        var password = document.getElementById("delete_password").value;
        var bool = document.getElementById("user_d").value;
          if (password == <?php echo $password['password'];?>){
              delete_bill(bool, "products");
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
<?php
if(isset($_POST['save_add']))   
{
  $id = $_GET['inv_n'];
  $disc = $_POST['discount'];
  $query_y = "UPDATE stock_receive SET discount = '{$disc}' WHERE invoice_number='{$id}'";
  $db->query($query_y);
  if($_POST['productid']==''){
    $session->msg('s',"no items to add but updated ");
    redirect('stock_load_manage.php', false);
  }else{
  $query_r = "INSERT INTO stock SET invoice_number = '{$id}',product_id = '{$_POST['productid']}',quantity = '{$_POST['quantity']}',free_quantity = '{$_POST['free_quantity']}'";
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
                  <b>Products</b>
             </div>
             <div class="col-xs-5">
                <a href="add_product.php" class="btn btn-primary">Add New</a>
              </div>
            </div>
          </div>
      </br>
      <div class="panel clearfix">
      <table id="userRequestList" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th> Photo</th>
            <th> Status</th>
            <th> Product Title </th>
            <th class="text-center" style="width: 10%;"> Categorie </th>
            <th class="text-center" style="width: 10%;"> Total added </th>
            <th class="text-center" style="width: 10%;"> Sold Amount </th>
            <th class="text-center" style="width: 10%;"> Instock </th>
            <th><font color="red">Return Receive</font></th>
            <th class="text-center" style="width: 10%;"> Buying Price </th>
            <th class="text-center" style="width: 10%;"> Saleing Price </th>
            <th class="text-center" style="width: 10%;"> Product Added </th>
            <th class="text-center" style="width: 100px;"> Actions </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product):?>
          <?php
      $billed_qty = find_by_product_id('customer_bill',$product['id']);
      $billed=0; 
      $returnd=0; 
      $discount_o = 0;
      foreach ($billed_qty as $stock_bill):
        $billed = $billed + $stock_bill['quantity'] + $stock_bill['free_quantity'];
        $returnd = $returnd + $stock_bill['received_return'];
        $discount_o=$discount_o+$stock_bill['discount_quantity'];
      endforeach;
      //echo $billed;
      ?>
          <?php   
          //$x = $product['id'];
          $stock =  find_by_product_id('stock',$product['id']);
          $count = 0;
          foreach ($stock as $stock1):
              $count = $count + $stock1['quantity'] + $stock1['free_quantity'];
          endforeach;?>
            <tr>
            <td class="text-center"><?php echo count_id();?></td>
            <td>
              <?php if($product['media_id'] === '0'): ?>
                <img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
              <?php else: ?>
              <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
            <?php endif; ?>
            </td>
            <td> 
            <?php if($product['active_product']==1):?>
            <span class="label label-success"><?php echo "Active"; ?></span>
            <?php else:?>
            <span class="label label-danger"><?php echo "Deactive"; ?></span>
            <?php endif; ?>
            </td>
            <td> <?php echo remove_junk($product['name']); ?></td>
            <td class="text-center"> <?php echo remove_junk($product['categorie']); ?></td>
            <td class="text-center"> <?php echo remove_junk($count); ?></td>
            <td class="text-center"> <?php echo remove_junk($billed); ?></td>
            <td class="text-center"> <?php echo $count-$billed-$discount_o; ?></td>
            <td><font color="red"><?php echo $returnd; ?></font></td>
            <td class="text-center"> <?php echo remove_junk($product['buy_price']); ?></td>
            <td class="text-center"> <?php echo remove_junk($product['sale_price']); ?></td>
            <td class="text-center"> <?php echo read_date($product['date']); ?></td>
            <td class="text-center">
              <div class="btn-group">
                <input type="button" onclick="edit_val(<?php echo (int)$product['id'];?>)" class="btn btn-info btn-xs"  title="Delete" data-toggle="tooltip" value = "Edit">
                <input type="button" onclick="delete_val(<?php echo (int)$product['id'];?>)" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip" value = "Delete">
              </div>
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
