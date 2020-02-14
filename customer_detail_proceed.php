<?php
  $page_title = 'All Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php

if(isset($_POST['save'])){
  $name   = remove_junk($db->escape($_POST['name']));
  $address   = remove_junk($db->escape($_POST['address']));
  $route = remove_junk($db->escape($_POST['route_id']));
  $status = remove_junk($db->escape($_POST['status']));
  $query_r = "update customer set name = '{$name}',address = '{$address}',route_id = '{$route}', active_customer = '{$status}' where id = '{$_GET['id']}'";
  $result_r = $db->query($query_r);
}

?>
<?php
$all_routes = find_all('routes');
$cust_id=$_GET['id'];
$all_customer = find_by_id('customer',$cust_id);
//$cust_detail = find_by_custdetail_id('customer_bill_receive',$cust_id);
$customer_detail = join_custdetail_by_id($cust_id);
//echo print_r($cust_ff);
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
<script type="text/javascript">
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
            "targets": [ 6 ],
            "visible": true,
            "searchable": true
          }
        ]
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
      $('#myModal').modal('show');
    }
</script>
<div class="row">
  <div class="col-md-12">
     <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-12">
    <div class="pull-right">
      <a href="customer_detail_edit.php?id=<?php echo $cust_id ?>" class="btn btn-info" role="button">Edit</a>
      <a href="customer_detail_print.php?id=<?php echo $cust_id ?>" class="btn btn-success" role="button">Print</a>
    </div>
    <div class="pull-left">
      <h2><label class="label label-success"><?php echo remove_junk(ucfirst($all_customer['name'])); ?></label></h2>
    </div>
  </div>
   <div class="col-md-12">
   <div class="panel-body">
    <h3></td>
    </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped table-hover">
          <thead>
              <tr>            
                  <th>Address</th>
              </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo remove_junk(ucfirst($all_customer['address'])); ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped table-hover">
          <thead>
              <tr>            
                  <th>Route</th>
              </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php
              $v = $all_customer['route_id'];
              $cl = find_by_id('routes',$v);
              echo $cl['name'];
               ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped table-hover">
          <thead>
              <tr>            
                  <th>Status</th>
              </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <?php $status = $all_customer['active_customer']; 
                if ($status==0){
                  echo '<label class = "label label-danger">Inactive</label>';
                } else {
                  echo '<label class = "label label-success">Active</label>';
                }

                ?> 
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped table-hover">
          <thead>
              <tr>            
                  <th>Bills</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td>
                    <table id="userRequestList" class="table table-bordered table-striped table-hover">
                      <thead>
                          <tr>
                              <th>Date</th>
                              <th>Invoive Number</th>
                              <th>Cash Amount</th>
                              <th><font color="red"> Discount </font></th>
                              <th>Credit Amount</th>
                              <th>Received Credit</th>
                              <th>Received Cheque</th>
                              <th>Cheque Amount</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $total_cash = 0;
                        $total_credit = 0;
                        $total_discount = 0;
                        $total_rec_credit = 0;
                        $total_cheque = 0;
                        $total_rec_cheque = 0;
                        foreach ($customer_detail as $all_customer):
                          $total_cash += $all_customer['cash'];
                          $total_credit += $all_customer['credit'];
                          $total_discount += $all_customer['discount'];
                          $total_rec_credit += $all_customer['received_credit'];
                          $total_cheque += $all_customer['cheque'];
                          $total_rec_cheque += $all_customer['received_cheque'];
                        ?>
                          <tr>
                              <td class="text-center"><?php echo remove_junk(ucfirst($all_customer['date'])); ?></td>
                              <td class="text-center"><input id="creditShow" type="button" onclick="credit_modal(<?php echo (int)$all_customer['invoice_number'];?>)" class="btn btn-info btn-xs" value = "<?php echo remove_junk($all_customer['invoice_number']); ?>"> </td>
                              <td class="text-right">Rs. <?php echo remove_junk(ucfirst($all_customer['cash'])); ?></td>
                              <td class="text-right"><font color="red">Rs. <?php echo remove_junk(ucfirst($all_customer['discount'])); ?></font></td>
                              <td class="text-right">Rs. <?php echo remove_junk(ucfirst($all_customer['credit'])); ?></td>
                              <td class="text-right">Rs. <?php echo remove_junk(ucfirst($all_customer['received_credit'])); ?></td>
                               <td class="text-right">Rs. <?php echo remove_junk(ucfirst($all_customer['received_cheque'])); ?></td>
                              <td class="text-right">Rs. <?php echo remove_junk(ucfirst($all_customer['cheque'])); ?></td>
                            </tr>
                             <?php endforeach; ?>
                      </tbody>
                      <tfoot>
                      <tr>
                        <td class="text-center"><b>Total</b></td>
                        <td></td>
                        <td class="text-right"><font color="black"><b> Rs.<?php echo number_format($total_cash, 2);?></b></font></td>
                        <td class="text-right"><font color="black"><b> Rs.<?php echo number_format($total_discount, 2);?></b></font></td>
                        <td class="text-right"><font color="black"><b> Rs.<?php echo number_format($total_credit, 2);?></b></font></td>
                        <td class="text-right"><font color="black"><b> Rs.<?php echo number_format($total_rec_credit, 2);?></b></font></td>
                        <td class="text-right"><font color="black"><b> Rs.<?php echo number_format($total_rec_cheque, 2);?></b></font></td>
                        <td class="text-right"><font color="black"><b> Rs.<?php echo number_format($total_cheque, 2);?></b></font></td>
                      </tr>
                    </tfoot>
                    </table>
                    <table class="table table-bordered">
                      <tfoot>
                      <tr>
                        <td class="text-center"><b>Credit Left</b></td>
                        <td></td>
                        <td class="text-right"><font color="black"><b> Rs.<?php echo number_format($total_credit-$total_rec_credit-$total_rec_cheque, 2);?></b></font></td>
                      </tr>
                    </tfoot>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
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
  
  <?php include_once('layouts/footer.php'); ?>
