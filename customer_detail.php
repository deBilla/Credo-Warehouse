<?php
require_once('includes/load.php');
$page_title = 'Customer Details';
$all_customer = find_all('customer');
$all_routes = find_all('routes');
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
            "targets": [ 0 ],
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
              window.location = "customer_bill_delete_v1.php?id=" + bool;
          } else {
              swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#myModal').modal('hide');
      });
    });

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
if(isset($_GET['ok'])){
    $customer_id = $_GET['cust_n'];
    $invoice_number = $_GET['inv_n'];
    $date = $_GET['date_n'];
    $cash = $_GET['cash_n'];
    $return_sale = $_GET['ret_sale'];
    $discount = $_GET['disc_n'];
   $credit = $_GET['cred_n'];
    $cheque = $_GET['cheq_n'];
    $received_credit = $_GET['rec_cred'];
    $received_cheque = $_GET['rec_cheq'];
    $id_from_prev=$_GET['id_from'];
    //credit updating
    $credit_before = find_by_invoice('customer_bill_receive',$invoice_number);
    $on_credit = 0;
    $credit_now = find_by_cust_id('credit',$customer_id);
    $credit_cust = $credit_now['credit'] + $credit - $received_credit - $credit_before['credit'] - $received_cheque;
    $on_credit = 1; 
    $customer_update = "update credit set on_credit = '{$on_credit}',credit = '{$credit_cust}' ,date = '{$date}' where customer_id = '{$customer_id}' "; 
    $db->query($customer_update);

  $query_r = "update customer_bill_receive set invoice_number='{$invoice_number}', date='{$date}', cash='{$cash}', return_sale='{$return_sale}', discount='{$discount}', credit='{$credit}', cheque='{$cheque}', received_credit='{$received_credit}', received_cheque='{$received_cheque}', customer_id='{$customer_id}' where id = '{$id_from_prev}'";
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
<div class="panel panel-default">
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
   </div>
  <div class="panel-heading clearfix">
     <select id="catList" class="btn btn-default" name="route_id">
        <option value="">All Routes</option>
      <?php  foreach ($all_routes as $cat): ?>
        <option value="<?php echo (int)$cat['id'] ?>">
          <?php 
      $catid = isset($_GET['route']) ? $_GET['route'] : 0;
      $selected = ($catid == $cat['id']) ? " selected" : "";
      echo "<option$selected value=".$cat['id'].">".$cat['name']."</option>";
          ?>
          </option>
      <?php endforeach; ?>
     </select> 
    </div>
        <div class="panel-heading clearfix">
         <div class="col-xs-5">
          <span class="glyphicon glyphicon-th"></span>
           <b>Customer Details</b>
         </div>
         <div class="col-xs-5">
           <a href="route_edit.php" class="btn btn-primary">Add New</a>
         </div>
        </div>
  
           
<?php
if(isset($_GET['route'])){
$route_id=$_GET['route'];
$all_customer = find_by_route_id('customer',$route_id);
//echo print_r($all_customer);
?> 
      <div class="panel panel-default">
        <div class="panel-body">
      <table id="userRequestList" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
        <thead>
                <tr>
                    <th>Customers</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($all_customer as $cust):?>
                <tr>
                    <td><a href="customer_detail_proceed.php?id=<?php echo (int)$cust['id']; ?>">
                  <?php echo remove_junk(ucfirst($cust['name'])); ?></td>
                  <td class="text-center">
                 <?php if($cust['active_customer'] === '1'): ?>
                  <span class="label label-success"><?php echo "Active"; ?></span>
                <?php else: ?>
                  <span class="label label-danger"><?php echo "Deactive"; ?></span>
                <?php endif;?>
                 </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
      </table>
      </div>
    </div>
  </div> 
<?php
}else{
$all_customer = find_all('customer');
//echo print_r($all_customer);
?> 
      <div class="panel panel-default">
        <div class="panel-body">
      <table id="userRequestList" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
        <thead>
                <tr>
                    <th>Customers</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($all_customer as $cust):?>
                <tr>
                    <td><a href="customer_detail_proceed.php?id=<?php echo (int)$cust['id']; ?>">
                  <?php echo remove_junk(ucfirst($cust['name'])); ?></td>
                  <td class="text-center">
                 <?php if($cust['active_customer'] === '1'): ?>
                  <span class="label label-success"><?php echo "Active"; ?></span>
                <?php else: ?>
                  <span class="label label-danger"><?php echo "Deactive"; ?></span>
                <?php endif;?>
                 </td>
                </tr>
              <?php endforeach; } ?>
            </tbody>
      </table>
      </div>
    </div>
  </div> 
  <script type="text/javascript">
    $(document).ready(function(){
        $("#catList").on('change', function(){
            if($(this).val() == 0)
            {
                window.location = 'customer_detail.php';
            }
            else
            {
                window.location = 'customer_detail.php?route='+$(this).val();
            }
        });
    });
</script> 

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