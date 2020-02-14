<?php
$page_title = 'Discount Report';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$start_date   = remove_junk($db->escape($_GET['start-date']));
$end_date     = remove_junk($db->escape($_GET['end-date']));
$discount_got      = find_discount_got_by_dates($start_date,$end_date);
$discount_give      = find_discount_give_by_dates($start_date,$end_date);
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
       font-weight: 500;
     }
   </style>
</head>
<body>
  <?php if($discount_got): ?>
    <div class="page-break">
       <div class="sale-head pull-right">
           <h1>Discount Report</h1>
           <strong><?php if(isset($start_date)){ echo $start_date;}?> To <?php if(isset($end_date)){echo $end_date;}?> </strong>
       </div>
<!--   Discount     -->            
      <table class="table table-border">
        <thead>
          <tr>
              <th>Date</th>
              <th>Invoice Number</th>
              <th>Discount</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $total_discount = 0;
          foreach($discount_got as $result): 
          $total_free = 0;
          
          $total_discount = $total_discount + $result['discount'];
          ?>
           <tr>
              <td class="text-center"><?php echo remove_junk($result['date']);?></td>
              <td class="text-center"><b><?php echo remove_junk($result['invoice_number']);?></b></td>
              <td class="text-right">Rs. <?php echo number_format($result['discount'],2);?></td>
          </tr>
        <?php endforeach; ?>
        <tfoot>
         <tr>
           <td></td>
           <td class="text-center"><b>Total discount received</b></td>
           <td class="text-right"><b> Rs.
           <?php echo number_format($total_discount, 2);
           $total_discount_prev = $total_discount;
           ?></b>
          </td>
         </tr>
        </tfoot>
        </tbody>
      </table>

<!--   Discount     -->           
      <table class="table table-border">
        <thead>
          <tr>
              <th>Date</th>
              <th>Invoice Number</th>
              <th>Discount</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          
          $total_discount = 0;
          foreach($discount_give as $result): 
          $total_free = 0;
          $total_discount = $total_discount + $result['discount'];
          ?>
           <tr>
              <td class="text-center"><?php echo remove_junk($result['date']);?></td>
              <td class="text-center"><b><?php echo remove_junk($result['invoice_number']);?></b></td>
              <td class="text-right">Rs. <?php echo number_format($result['discount'],2);?></td> 
          </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
         <tr>
           <td></td>
           <td class="text-center"><b>Total discount sent</b></td>
           <td class="text-right"><b> Rs.
           <?php echo number_format($total_discount, 2);?></b>
          </td>
         </tr>
        </tfoot>
      </table>
 <!--   Discount     -->     
  <table class="table table-border">
    <thead>
      <tr>
        <th>Product Title</th>
        <th>Discount Quantity</th>
        <th>Discount to products</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $total_free=0;
      $total_discount_qt=0; 
      $table = "customer_bill";
      $products = join_by_product_join($start_date,$end_date,$table);
      foreach($products as $result_p): 
        $product_description = find_by_id('products',$result_p['product_id']);
        $total_free = $total_free + $result_p['free_quantity'];
        $total_discount_qt=$total_discount_qt+$result_p['discount_qt'];
      ?>
      <td class="text-center"><b><?php echo remove_junk($result_p['name']);?></b></td>
      <td class="text-center"><font color="red"><?php echo remove_junk($result_p['discount_quantity']);?></font></td>
      <td class="text-right"><font color="red">Rs. <?php echo remove_junk($result_p['discount_qt']);?></font></td>
    </tbody>
    <?php endforeach; ?>
    <tfoot>
     <tr class="text-center">
       <td><b>Total Free quantity sent</b></td>
       <td class="text-center"><b>
       Total Spend on Discount
      </td>
       <td class="text-right"><b>
      Rs.  <?php echo $total_discount_qt;?></b>
      </td>
     </tr>
     <tr class="text-center">
       <td><b>Total Discount got</b></td>
       <td class="text-right"><b>
       Rs. <?php echo number_format($total_discount_prev,2);?></b>
      </td>
     </tr>
     <tr class="text-center">
       <td><b>Total Discount Spent</b></td>
       <td class="text-right"><b>
       Rs. <?php echo number_format($total_discount+$total_discount_qt,2);?></b>
      </td>
     </tr>
     <tr class="text-center">
       <td><b>Discount to be given</b></td>
       <td class="text-right"><b>
       Rs. <?php echo number_format($total_discount_prev-($total_discount+$total_discount_qt),2);?></b>
      </td>
     </tr>
    </tfoot>
  </table>
</div>




<div class="page-break">
  <div class="sale-head pull-right">
           <h1>Free Issue Report</h1>
           <strong><?php if(isset($start_date)){ echo $start_date;}?> To <?php if(isset($end_date)){echo $end_date;}?> </strong>
       </div>
    <table class="table table-border">
      <thead>
        <tr>
          <th>Product Title</th>
          <th>Free Quantity</th>
        </tr>
      </thead>
      <tbody>
      <?php 
      $table="stock";
      $products = join_by_product_join_v1($start_date,$end_date,$table);
      foreach($products as $result_p): 
      $total_free = $total_free + $result_p['free_quantity'];
      $product_description = find_by_id('products',$result_p['product_id']);
      ?>
      <td class="text-center"><b><?php echo remove_junk($result_p['name']);?></b></td>
      <td class="text-center"><font color="red"><?php echo remove_junk($result_p['free_quantity']);?></font></td>
      </tbody>
      <?php endforeach; ?>
       <tfoot>
     <tr class="text-center">
       <td><b>Total Free quantity</b></td>
       <td class="text-center"><b>
       <?php echo $total_free;
       $total_free_prev=$total_free;
       ?></b>
      </td>
    </tr>
  </tfoot>
    </table> 
  <table class="table table-border">
    <thead>
      <tr>
        <th>Product Title</th>
        <th>Free Quantity</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $total_free=0;
      $total_discount_qt=0; 
      $table = "customer_bill";
      $products = join_by_product_join($start_date,$end_date,$table);
      foreach($products as $result_p): 
        $product_description = find_by_id('products',$result_p['product_id']);
        $total_free = $total_free + $result_p['free_quantity'];
        $total_discount_qt=$total_discount_qt+$result_p['discount_qt'];
      ?>
      <td class="text-center"><b><?php echo remove_junk($result_p['name']);?></b></td>
      <td class="text-center"><font color="red"><?php echo remove_junk($result_p['free_quantity']);?></font></td>
    </tbody>
    <?php endforeach; ?>
    <tfoot>
     <tr class="text-center">
       <td><b>Total Free quantity</b></td>
       <td class="text-center"><b>
       <?php echo $total_free;?></b>
      </td>
    </tr>
    <tr class="text-center">
       <td><b>Total free got</b></td>
       <td class="text-center"><b>
       <?php echo number_format($total_free_prev);?></b>
      </td>
     </tr>
     <tr class="text-center">
       <td><b>Total free given</b></td>
       <td class="text-center"><b>
       <?php echo number_format($total_free);?></b>
      </td>
     </tr>
     <tr class="text-center">
       <td><b>Free left</b></td>
       <td class="text-center"><b>
       <?php echo number_format($total_free_prev-$total_free);?></b>
      </td>
     </tr>
    </tfoot>
  </table>
</div>
  <?php
    else:
        $session->msg("d", "Sorry no sales has been found. ");
        redirect('discount_report.php', false);
     endif;
  ?>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
