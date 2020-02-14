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
  $stock      = find_stock_by_dates($start_date,$end_date);
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
  <?php if($stock): ?>
    <div class="page-break">
       <div class="sale-head pull-right">
           <h1>Stock Receive Report</h1>
           <strong><?php if(isset($start_date)){ echo $start_date;}?> To <?php if(isset($end_date)){echo $end_date;}?> </strong>
       </div>
      <table class="table table-border">
        <thead>
          <tr>
              <th>Date</th>
              <th>Invoice Number</th>
              <th>Discount</th>
              <th>Products </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($stock as $result): ?>
           <tr>
              <td class=""><?php echo remove_junk($result['date']);?></td>
              <td class="text-right"><b><?php echo remove_junk($result['invoice_number']);?></b></td>
              <td><font color="red">Rs. <?php echo number_format($result['discount'],2);?></font></td>
              <td class="text-right">
                <table class="table table-border">
                  <thead>
                    <tr>
                      <th>Product Title</th>
                      <th>Buying Price</th>
                      <th>Selling Price</th>
                      <th>Quantity</th>
                      <th>Free Quantity</th>
                      <th>sub total to buy</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $products = join_stock_by_id($result['invoice_number']);
                    $buy_total = 0;
                    foreach($products as $result_p): 
                      $product_description = find_by_id('products',$result_p['product_id']);
                      $buy_sub = $result_p['quantity']*$product_description['buy_price'];
                      $buy_total += $buy_sub;
                    ?>
                    <td class="text-center"><b><?php echo remove_junk($result_p['name']);?></b></td>
                    <td class="text-right"><?php echo remove_junk($product_description['buy_price']);?></td>
                    <td class="text-right"><?php echo remove_junk($product_description['sale_price']);?></td>
                    <td class="text-right"><?php echo remove_junk($result_p['quantity']);?></td>
                    <td class="text-right"><font color="red"><?php echo remove_junk($result_p['free_quantity']);?></font></td>
                    <td class="text-right">Rs. <?php echo number_format($buy_sub,2);?></td>
                  </tbody>
                  <?php endforeach; ?>
                  <tfoot>
                    <tr>
                      <td class="text-center"><b>Total</b></td>
                      <td class="text-right"></td>
                      <td class="text-right"></td>
                      <td class="text-right"></td>
                      <td class="text-right"></td>
                      <td class="text-right"><font color=""><b> Rs.<?php echo number_format($buy_total, 2);?></b></font></td>
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
        $session->msg("d", "Sorry no sales has been found. ");
        redirect('sales_report.php', false);
     endif;
  ?>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
