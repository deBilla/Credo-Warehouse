<?php
$page_title = 'Sales Report';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
      $start_date   = remove_junk($db->escape($_GET['start-date']));
      $end_date     = remove_junk($db->escape($_GET['end-date']));
      $results      = find_product_sale_by_dates($start_date,$end_date);
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
           <h1>Product Sale Report</h1>
           <strong><?php if(isset($start_date)){ echo $start_date;}?> To <?php if(isset($end_date)){echo $end_date;}?> </strong>
       </div>
      <table class="table table-border">
        <thead>
          <tr>
              <th>Product Name</th>
              <th>Sold Amount</th>
              <th>Discount Quantity</th>
              <th>Free Quantity</th>
              <th>Return Issued</th>
              <th>Total Sold</th>
              <th>Return Received</th>
              <th>Sale Price</th>
              <th>Sub Total</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $total=0;
          /*$cash_total=0;
          $credit_total=0;
          $cheque_total=0;
          $return_sale_total=0;*/
          foreach($results as $result): 
            $total_sold=$result['quantity']+$result['free_quantity']+$result['reissued']+$result['discount_quantity'];
            $sub_total = $result['sale_price']*$result['quantity'];
            $total += $sub_total;
            /*$cash_total += $result['cash'];
            $credit_total += $result['credit'];
            $cheque_total += $result['cheque'];
            $return_sale_total += $result['return_sale'];*/
          ?>
          
           <tr>
              <td class="text-left"><b><?php echo remove_junk($result['product_name']);?></b></td>
              <td class="text-right"><b><?php echo remove_junk($result['quantity']);?></b></td>
              <td class="text-right"><?php echo remove_junk($result['discount_quantity']);?></td>
              <td class="text-right"><?php echo remove_junk($result['free_quantity']);?></td>
              <td class="text-right"><?php echo remove_junk($result['reissued']);?></td>
              <td class="text-right"><b><font color="blue"> <?php echo remove_junk($total_sold);?></font></b></td>
              <td class="text-right"><b><font color="red"><?php echo remove_junk($result['received_return']);?></font></b></td>
              <td class="text-right">Rs. <?php echo number_format($result['sale_price'],2);?></td>
              <td class="text-right">Rs. <?php echo number_format($sub_total,2);?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
          <td class="text-center"><b>Total</b></td>
          <td></td>
          <td class="text-right"></td>
          <td class="text-right"></td>
          <td class="text-right"></td>
          <td class="text-right"></td>
          <td class="text-right"></td>
          <td class="text-right"></td>
          <td class="text-right"><font color=""><b> Rs.<?php echo number_format($total, 2);?></b></font></td>
        </tr>
      </tfoot>
      </table>
    </div>
  <?php
    else:
        $session->msg("d", "Sorry no cash collection has been found. ");
        redirect('product_sale_report.php', false);
     endif;
  ?>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
