<?php
$page_title = 'Sales Report';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php

$start_date   = remove_junk($db->escape($_GET['date']));
$route   = remove_junk($db->escape($_GET['route_name']));
$results      = find_credit_by_dates_route($start_date,$route);
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
      width: auto;
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
       text-transform: uppercase;
       font-weight: 500;
     }
   </style>
</head>
<body>
  <?php if($results): ?>
    <div class="page-break">
       <div class="sale-head pull-right">
           <h1>Cash Collection Report</h1>
           <strong>To <?php if(isset($start_date)){ echo $start_date;}?></strong>
       </div>
      <table class="table table-border">
        <thead>
          <tr>
              <th>Date</th>
              <th>Customer Name</th>
              <th>Credit Amount</th>
              <th>Received Credit</th>
              <th>Received Cheque</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $cash_total=0;
          $credit_total=0;
          $cheque_total=0;
          foreach($results as $result): 
            $cash_total += $result['credit'];
            $credit_total += $result['received_credit'];
            $cheque_total += $result['received_cheque'];

          ?>
          
           <tr>
              <td class=""><?php echo remove_junk($result['date']);?></td>
              <td class="desc">
                <h6><?php echo remove_junk(ucfirst($result['name']));?></h6>
              </td>
              <td class="text-right"><?php echo remove_junk($result['credit']);?></td>
              <td class="text-right"><?php echo remove_junk($result['received_credit']);?></td>
              <td class="text-right"><?php echo remove_junk($result['received_cheque']);?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
          <td></td>
          <td class="text-center"><b>Total</b></td>
          <td class="text-right"><font color=""><b> Rs.<?php echo number_format($cash_total, 2);?></b></font></td>
          <td class="text-right"><font color=""><b> Rs.<?php echo number_format($credit_total, 2);?></b></font></td>
          <td class="text-right"><font color=""><b> Rs.<?php echo number_format($cheque_total, 2);?></b></font></td>
        </tr>
        <tr>
          <td></td>
          <td class="text-center"><b>Credit Left</b></td>
          <td class="text-right"><font color=""><b> Rs.<?php echo number_format($cash_total-$credit_total-$cheque_total, 2);?></b></font></td>
        </tr>
      </tfoot>
      </table>
    </div>
  <?php
    else:
        $session->msg("d", "Sorry no cash collection has been found. ");
        redirect('credit_route_v1_report.php', false);
     endif;
  ?>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
