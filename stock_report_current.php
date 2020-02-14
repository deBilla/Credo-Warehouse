<?php
$page_title = 'Sales Report';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$stock_in_hand = find_stock_in_hand();
$grand_stock_buy=0;
$grand_stock_sale=0;
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
    <div class="page-break">
       <div class="sale-head pull-right">
           <h1>Stock Report</h1>
           <strong>Up to <?php  $date1 = strtotime('today');  
           echo date('Y-m-d',$date1);
           ?> </strong>
       </div>
      <table class="table table-border">
          <thead>
           <tr>
             <th>Product Name</th>
             <th>free in</th>
             <th>stock in</th>
             <th>free out</th>
             <th>discount out</th>
             <th>stock out</th>
             <th>total out</th>
             <th>net stock</th>
             <th>return in</th>
             <th>return out</th>
             <th>stock</th>
             <th>free stock</th>
             <th>total stock</th>
             <th>Sale Price</th>
             <th>Buy Price</th>
             <th>Stock Value</th>
             <th>Stock Sale Value</th>
           <tr>
          </thead>
          <tbody>
            <?php foreach ($stock_in_hand as  $product_sold): ?>
            <?php
              $billed_qty = find_by_product_id('customer_bill',$product_sold['product_id']);
              $sale_price = find_by_id('products',$product_sold['product_id'])['sale_price'];
              $buy_price = find_by_id('products',$product_sold['product_id'])['buy_price'];
              //print_r($sale_price);
              $billed=0; 
              $returnd=0; 
              $free_given=0;
              $discount_qty = 0;
              foreach ($billed_qty as $stock_bill):
                $billed = $billed + $stock_bill['quantity'];
                $free_given = $free_given + $stock_bill['free_quantity'];
                $returnd = $returnd + $stock_bill['received_return'];
                $discount_qty = $discount_qty + $stock_bill['discount_quantity'];
              endforeach;
              //echo $billed;
            ?>
            <?php
              $return_qty = find_by_product_id('company_return_receive',$product_sold['product_id']);
              $return_sent=0; 
              foreach ($return_qty as $stock_bill):
                $return_sent = $return_sent + $stock_bill['quantity'];
              endforeach;
              //echo $billed;*/
              $grand_stock1 = $product_sold['total_quantity']-$billed-$free_given+$returnd-$return_sent-$discount_qty;
              $grand_stock = $product_sold['quantity']-$billed-$discount_qty;
              $grand_stock_buy = $grand_stock*$buy_price + $grand_stock_buy;
              $grand_stock_sale = $grand_stock*$sale_price + $grand_stock_sale;
            ?>
              <tr>
                <td><?php echo remove_junk(first_character($product_sold['name'])); ?></td>
                <td><?php echo (int)$product_sold['free_quantity']; ?></td>
                <td><?php echo (int)$product_sold['quantity']; ?></td>
                <td><font color=""><?php echo (int)$free_given; ?></font></td>
                <td><font color=""><?php echo (int)$discount_qty; ?></font></td>
                <td><font color=""><?php echo $billed; ?></font></td>
                <td><font color=""><?php echo $billed+$free_given+$discount_qty; ?></font></td>
                <td><font color="blue"><b><?php echo (int)$product_sold['total_quantity']-$billed-$free_given-$discount_qty; ?></b></font></td>
                <td><font color=""><?php echo $returnd; ?></font></td>
                <td><font color=""><?php echo $return_sent; ?></font></td>
                <td><font color=""><?php echo $product_sold['quantity']-$billed+$returnd-$return_sent-$discount_qty;?></font></td>
                <td><font color=""><?php echo $product_sold['free_quantity']-$free_given; ?></font></td>
                <td><font color="red"><b><?php echo $grand_stock1; ?></font></b></td>
                <td class="text-right"><font color="">Rs. <?php echo number_format($sale_price,2); ?></font></td>
                <td class="text-right"><font color="">Rs. <?php echo number_format($buy_price,2); ?></font></td>
                <td class="text-right"><font color="">Rs. <?php echo number_format($grand_stock*$buy_price,2); ?></font></td>
                <td class="text-right"><font color="">Rs. <?php echo number_format($grand_stock*$sale_price,2); ?></font></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
         <tr>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td>Total</td>
           <td class="text-right"><b>Rs. <?php echo number_format($grand_stock_buy,2); ?></b></td>
           <td class="text-right"><b>Rs. <?php echo number_format($grand_stock_sale,2); ?></b></td>
         </tr>
        </tfoot>
         </table>
    </div>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
