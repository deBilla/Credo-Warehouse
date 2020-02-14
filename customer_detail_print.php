<?php
$page_title = 'Sales Report';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php

?>
<!doctype html>
<html lang="en-US">
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Default Page Title</title>
    <link rel="stylesheet" href="css/jquery-te-1.4.0.css"/>
    <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="libs/bootstrap/css/bootstrap-date.css"/>
<style>
   @media print {
     html,body{
        font-size: 9.5pt;
        margin: 0;
        padding: 0;
     }.page-break {
       page-break-before:always;
       width: auto;
       margin: auto;
      }
    }
    .page-break{
      width: 1360px;
      margin: 0 auto;
    }
     .sale-head{
       margin: 40px 0;
       text-align: center;
     }.sale-head h1,.sale-head strong{
       padding: 10px 20px;
       display: block;
     }.sale-head h1{
       margin: 0;
       border-bottom: 1px solid #212121;
     }.table>thead:first-child>tr:first-child>th{
       border-top: 1px solid #000;
      }
      table thead tr th {
       text-align: center;
       border: 1px solid #ededed;
     }table tbody tr td{
       vertical-align: middle;
     }.sale-head,table.table thead tr th,table tbody tr td,table tfoot tr td{
       border: 1px solid #212121;
       white-space: nowrap;
     }.sale-head h1,table thead tr th,table tfoot tr td{
       background-color: #f8f8f8;
     }tfoot{
       color:#000;
       font-weight: 500;
     }
   </style>
</head>
<?php
$all_routes = find_all('routes');
$cust_id=$_GET['id'];
$all_customer = find_by_id('customer',$cust_id);
//$cust_detail = find_by_custdetail_id('customer_bill_receive',$cust_id);
$customer_detail = join_custdetail_by_id($cust_id);
//echo print_r($cust_ff);
?> 
<body>
    <div class="page-break">
       <div class="sale-head pull-right">
           <h1><?php echo $all_customer['name']; ?></h1>
           <strong>Detailed report</strong>
       </div>
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td><b>Name:</b> <?php echo remove_junk(ucfirst($all_customer['name'])); ?></td>
              </tr>
            </tbody>
          </table>
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td><b>Address:</b> <?php echo remove_junk(ucfirst($all_customer['address'])); ?></td>
              </tr>
            </tbody>
          </table>
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td><b>Route Name:</b> <?php
                $v = $all_customer['route_id'];
                $cl = find_by_id('routes',$v);
                echo $cl['name'];
                 ?></td>
              </tr>
            </tbody>
          </table>
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td>
                  <b>Status:</b> <?php $status = $all_customer['active_customer']; 
                  if ($status==0){
                    echo "Inactive";
                  } else {
                    echo "Active";
                  }

                  ?> 
                </td>
              </tr>
            </tbody>
          </table>
          <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>
                      <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Invoive Number</th>
                                <th>Cash Amount</th>
                                <th><font color="red"> Discount </font></th>
                                <th>Credit Amount</th>
                                <th>Received Credit</th>
                                <th>Cheque Amount</th>
                                <th>Received Cheque</th>
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
                                <td class="text-center"><?php echo remove_junk(ucfirst($all_customer['date'])); ?></a></td>
                                <td class="text-center"><?php echo remove_junk(ucfirst($all_customer['invoice_number'])); ?></a></td>
                                <td class="text-right">Rs. <?php echo remove_junk(ucfirst($all_customer['cash'])); ?></td>
                                <td class="text-right"><font color="red">Rs. <?php echo remove_junk(ucfirst($all_customer['discount'])); ?></font></td>
                                <td class="text-right">Rs. <?php echo remove_junk(ucfirst($all_customer['credit'])); ?></td>
                                <td class="text-right">Rs. <?php echo remove_junk(ucfirst($all_customer['received_credit'])); ?></td>
                                <td class="text-right">Rs. <?php echo remove_junk(ucfirst($all_customer['cheque'])); ?></td>
                                <td class="text-right">Rs. <?php echo remove_junk(ucfirst($all_customer['received_cheque'])); ?></td>
                              </tr>
                               <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <td></td>
                          <td class="text-center"><b>Total</b></td>
                          <td class="text-right"><font color="black"><b> Rs.<?php echo number_format($total_cash, 2);?></b></font></td>
                          <td class="text-right"><font color="black"><b> Rs.<?php echo number_format($total_discount, 2);?></b></font></td>
                          <td class="text-right"><font color="black"><b> Rs.<?php echo number_format($total_credit, 2);?></b></font></td>
                          <td class="text-right"><font color="black"><b> Rs.<?php echo number_format($total_rec_credit, 2);?></b></font></td>
                          <td class="text-right"><font color="black"><b> Rs.<?php echo number_format($total_cheque, 2);?></b></font></td>
                          <td class="text-right"><font color="black"><b> Rs.<?php echo number_format($total_rec_cheque, 2);?></b></font></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td class="text-center"><b>Credit</b></td>
                          <td class="text-right"><font color="black"><b> Rs.<?php echo number_format($total_credit-$total_rec_credit-$total_rec_cheque, 2);?></b></font></td>
                        </tr>
                      </tfoot>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
