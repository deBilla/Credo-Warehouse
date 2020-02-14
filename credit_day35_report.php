<?php 
$page_title = 'Credit over 35 days Report';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
  $results = find_credit_over_35();
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
  <?php //if($results): ?>
    <div class="page-break">
       <div class="sale-head pull-right">
           <h1>Credit over 28 days Report</h1>
           <strong> </strong>
       </div>
      <table class="table table-border">
        <thead>
          <tr>
              <th>Route Name</th>
              <th>Customer Name</th>
              <th>Date</th>
              <th>Invoice Number</th>
              <th>Credit Amount</th>
              <th>Received Credit Amount</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $total=0;
          $total_received=0;

          foreach($results as $result): 
            if(($result['credit'] - $result['received_credit']) <=0){
              continue;
            }
            $total += $result['credit'];
            $total_received += $result['received_credit'];
          ?>
           <tr>
            <td class="text-center"><b><?php echo remove_junk($result['name_r']);?></b></td>
              <td class="text-center">
                <font color="red"><b><?php echo remove_junk(ucfirst($result['name']));?></b></font>
              </td>
              <td class="text-center"><?php echo remove_junk($result['date']);?></td>
              <td class="text-center"><?php echo remove_junk($result['invoice_number']);?></td>
              <td class="text-right">Rs. <?php echo number_format($result['credit'],2);?></td>
              <td class="text-right">Rs. <?php echo number_format($result['received_credit'],2);?></td>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
          <td class="text-center"><b>Total</b></td>
          <td class="text-right"></td>
          <td class="text-right"></td>
          <td></td>
          <td class="text-right"><font color=""><b> Rs.<?php echo number_format($total, 2);?></b></font></td>
          <td class="text-right"><font color=""><b> Rs.<?php echo number_format($total_received, 2);?></b></font></td>
        </tr>
      </table>
    </div>
  <?php
   /* else:
        $session->msg("d", "Sorry no records has been found. ");
        redirect('credit_day35_report.php', false);
     endif;*/
  ?>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
