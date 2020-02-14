<?php
require_once('includes/load.php');
$page_title = 'Customer Cash Bills';
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
<script>
    $( document ).ready(function() {

      var oTable = $('#userRequestList').dataTable({
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
              window.location = "customer_bill_manage_v1_edit.php?id=" +bool;
          } else {
              swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#myModal').modal('hide');
      });

      $('#delete_button').click(function() {
        var password = document.getElementById("delete_password").value;
        var bool = document.getElementById("user_d").value;
          if (password == <?php echo $password['password'];?>){
              delete_bill(bool, "customer_bill_receive");
          } else {
              swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#myModal').modal('hide');
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
      $('#myModal').modal('show');
    }

    function edit_val(id_get){
      $('#editModal').modal('show');
      $(".modal-body #user_p").val( id_get );
    }

    function delete_val(id_get){
      $('#deleteModal').modal('show');
      $(".modal-body #user_d").val( id_get );
    }
</script>
<?php
if(isset($_GET['ok'])){
    $customer_id = $_GET['cust_n'];
    $invoice_number = $_GET['inv_n'];
    $date = $_GET['date_n'];
    $cash = $_GET['cash_n'];
    $return_sale = $_GET['ret_sale'];
    $discount = $_GET['disc_n'];
   $credit = $_GET['cred_n'];
    $cheque = $_GET['cheq_n'];
    $id_from_prev=$_GET['id_from'];

  $query_r = "update customer_bill_receive set invoice_number='{$invoice_number}', date='{$date}', cash='{$cash}', return_sale='{$return_sale}', discount='{$discount}', credit='{$credit}', cheque='{$cheque}', customer_id='{$customer_id}' where id = '{$id_from_prev}'";
  $result_r = $db->query($query_r);
//refreshing happens here  
  echo '<script type="text/javascript">',
    'window.onload = function() {',
    'if(!window.location.hash) {',
        'window.location = window.location + "#loaded";',
       ' window.location.reload(); } }',
    '</script>'
;
}
?>
      <div class="panel">
        <div class="row">
          <div class="col-md-12">
             <?php echo display_msg($msg); ?>
          </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
              <div class="col-md-12 column">
              <div class="col-xs-5">
                  <span class="glyphicon glyphicon-th"></span>
                  <b>Customer Cash Bills</b>
               </div>
               <div class="col-xs-5">
                <a href="customer_bill_add.php" class="btn btn-primary">Add New</a>
              </div>
            </div>
          </div>
      </br>
        <div class="panel clearfix">
          <div class="col-md-12 column">
      <table id="userRequestList" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
        <thead>
          <tr>
                  <th class="text-center" style="width: 50px;">#</th>
                  <th class="text-center" style="width: 20%;"> Route Name </th>
                  <th class="text-center" style="width: 20%;"> Customer Name </th>
                  <th class="text-center" style="width: 10%;"> Invoice Number </th>
                  <th class="text-center" style="width: 10%;"> Date </th>
                  <th class="text-center" style="width: 10%;"> Cash </th>
                  <th class="text-center" style="width: 10%;"> Return Sale </th>
                  <th class="text-center" style="width: 10%;"> Discount </th>
                  <th class="text-center" style="width: 10%;"> Credit </th>
                  <th class="text-center" style="width: 10%;"> Cheque </th>
                  <th class="text-center" style="width: 100px;"> Actions </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($customer_bill as $product):

                $customer = find_by_id('customer',$product['customer_id']);
                $route_id = $customer['route_id'];
                $route = find_by_id('routes',$route_id);
                ?>
                <tr>
                  <td class="text-center"><?php echo count_id();?></td>
                  <td class="text-center"> <?php echo remove_junk($route['name']); ?></td>
                  <td class="text-center"> <?php echo remove_junk($customer['name']); ?></td>
                  <td class="text-center"><input id="creditShow" type="button" onclick="credit_modal(<?php echo (int)$product['invoice_number'];?>)" class="btn btn-info btn-xs" value = "<?php echo remove_junk($product['invoice_number']); ?>"> </td>
                  <td class="text-center"> <?php echo remove_junk($product['date']); ?></td>
                  <td class="text-left">Rs. <?php echo remove_junk($product['cash']); ?></td>
                  <td class="text-left">Rs. <?php echo remove_junk($product['return_sale']); ?></td>
                  <td class="text-left">Rs. <?php echo remove_junk($product['discount']); ?></td>
                  <td class="text-left">Rs. <?php echo remove_junk($product['credit']); ?></td>
                  <td class="text-left">Rs. <?php echo remove_junk($product['cheque']); ?></td>
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
      </div>
    </div>
  </div>    
<!-- Modal -->
<div id="myModal" class="modal fade">
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
<!-- Modal this is used to take the password to edit-->
<div id="editModal" class="modal fade">
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
