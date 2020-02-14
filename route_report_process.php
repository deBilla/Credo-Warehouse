<?php
$page_title = 'Sales Report';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$start_date   = remove_junk($db->escape($_GET['date']));
$route_name     = remove_junk($db->escape($_GET['route_name']));
$route = find_by_id('routes',$route_name);
$results      = find_route_by_date($start_date,$route_name);
?>
<!doctype html>
<html lang="en-US">
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Route Report</title>
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
       margin: 20px 0;
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
           <h1>Route Report</h1>
           <strong><?php if(isset($start_date)){ echo $start_date;}?> In <?php if(isset($route_name)){echo $route['name'];}?> </strong>
       </div>
      <table class="table table-border">
        <thead>
          <tr>
              <th>Date</th>
              <th>Customer Name</th>
              <th>Invoice Number</th>
              <th>Cash Amount</th>
              <th><font color="blue"><b> Discount</b></font></th>
              <th>Credit Amount</th>
              <th>Cheque Amount</th>
              <th>Products</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($results as $result): ?>
           <tr>
              <td class=""><?php echo remove_junk($result['date']);?></td>
              <td class="desc">
                <h6><?php echo remove_junk(ucfirst($result['name']));?></h6>
              </td>
              <td class="text-right"><?php echo remove_junk($result['invoice_number']);?></td>
              <td class="text-right"><?php echo remove_junk($result['cash']);?></td>
              <td class="text-right"><font color="blue"><b> <?php echo remove_junk($result['discount']);?></font></b></td>
              <td class="text-right"><?php echo remove_junk($result['credit']);?></td>
              <td class="text-right"><?php echo remove_junk($result['cheque']);?></td>
              <td class="text-right">
                <table class="table table-border">
                  <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Discount Quantity</th>
                        <th>Free Quantity</th>
                        <th>Received Return</th>
                        <th>Reissued</th>
                        <th>Total</th>
                        <th>Total Discount</th>
                    </tr>
                  </thead>
                  <tbody> 
                  <?php 
                  $grand_total = 0;
                  $discount_total = 0;
                  $result_product = join_customer_by_id($result['invoice_number']);
                  foreach($result_product as $result_we):
                    $total = $result_we['sale_price']*$result_we['quantity'];
                    $disc_t = $result_we['sale_price']*$result_we['discount_quantity'];
                    $grand_total += $total;
                    $discount_total += $disc_t;
                    ?>
                    <tr>
                      <td><?php echo remove_junk($result_we['name']);?></td>
                      <td><?php echo remove_junk($result_we['quantity']);?></td>
                      <td><?php echo remove_junk($result_we['discount_quantity']);?></td>
                      <td><?php echo remove_junk($result_we['free_quantity']);?></td>
                      <td><?php echo remove_junk($result_we['received_return']);?></td>
                      <td><?php echo remove_junk($result_we['reissued']);?></td>
                      <td>Rs. <?php echo number_format($total,2);?></td>
                      <td>Rs. <?php echo number_format($disc_t,2);?></td>
                    </tr>
              </tbody>
              <?php endforeach;?>
              <tfoot>
               <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                 <td class="text-center"><b>grand total</b></td>
                 <td class="text-right"><b> Rs.<?php echo number_format($grand_total, 2);?></b></td>
                 <td class="text-right"><font color="blue"><b> Rs.<?php echo number_format($discount_total, 2);?></b></font></td>
              </tr>
            </tfoot>
            </table>
              </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php
    else:
        $session->msg("d", "Sorry no route info has been found. ");
        redirect('route_report.php', false);
     endif;
  ?>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
