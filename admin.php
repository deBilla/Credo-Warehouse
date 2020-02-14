<?php
  $page_title = 'Admin Home Page';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
 $c_categorie     = count_by_id('routes');
 $c_product       = count_by_id('products');
 $c_sale          = count_by_id('customer_bill_receive');
 $c_user          = count_by_id('customer');
 
 $stock_in_hand = find_stock_in_hand();
 $d=date("Y-m-d", strtotime("April 15 2012"));
 $d1 = date("Y-m-d", strtotime("April 15 2050"));
 $cash_report = find_cash_by_dates($d,$d1);
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
<style type="text/css">
    .insideTable {
      width: 100%;
    }
</style>
      
<script>
    $( document ).ready(function() {
      
      $('#userRequestList').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            }
        ],
        "columnDefs": [
          {
            "targets": [ 0 ],
            "visible": true,
            "searchable": true
          },
          {
            "targets": [ 12 ],
            "visible": true,
            "searchable": true
          }
        ]
      });
      
    });
</script>
<div class="row">
   <div class="col-md-6">
     <?php echo display_msg($msg); ?>
   </div>
</div>
  <div class="row">
    <div class="col-md-3">
      <a href="customer_detail.php">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-green">
          <i class="glyphicon glyphicon-user"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php  echo $c_user['total']; ?> </h2>
          <p class="text-muted">Customers</a></p>
        </div>
       </div>
    </div>
    <div class="col-md-3">
      <a href="route_create.php">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-red">
          <i class="glyphicon glyphicon-road"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php  echo $c_categorie['total']; ?> </h2>
          <p class="text-muted">Routes</a></p>
        </div>
       </div>
    </div>
    <div class="col-md-3">
      <a href="product.php">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-blue">
          <i class="glyphicon glyphicon-shopping-cart"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php  echo $c_product['total']; ?> </h2>
          <p class="text-muted">Products</a></p>
        </div>
       </div>
    </div>
    <div class="col-md-3">
      <a href="customer_bill_manage.php">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-yellow">
          <i class="glyphicon glyphicon-usd"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php  echo $c_sale['total']; ?></h2>
          <p class="text-muted">Bill Issued</p></a>
        </div>
       </div>
    </div>
</div>
<div class="row">
   <div class="col-md-12">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Stock In Hand</span>
         </strong>
       </div>
       <div class="panel-body">
         <table id="userRequestList" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
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
           </tr>
          </thead>
          <tbody>
            <?php foreach ($stock_in_hand as  $product_sold): ?>
            <?php
              $billed_qty = find_by_product_id('customer_bill',$product_sold['product_id']);
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
                <td><font color="red"><b><?php echo $product_sold['total_quantity']-$billed-$free_given+$returnd-$return_sent-$discount_qty; ?></font></b></td>
              </tr>
            <?php endforeach; ?>
          <tbody>
         </table>
       </div>
     </div>
   </div>
 </div>
<div class="row">
   <div class="col-md-12">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Discount</span>
         </strong>
       </div>
       <div class="panel-body">
         <table class="table table-striped table-bordered table-condensed">
          <thead>
           <tr>
             <th>Discount got so far</th>
             <th>Discount given so far</th>
             <th>Discount products given</th>
             <th>Total given Discount</th>
             <th>Discount can be given</th>
           <tr>
          </thead>
          <tbody>
            <?php
            $billed_qty = find_all('stock_receive');
            $discount_got=0;
            foreach ($billed_qty as  $product_sold): 
              $discount_got = $discount_got + $product_sold['discount'];
            endforeach;
            $billed_qty = find_all('customer_bill_receive');
            $discount_given=0;
            
            foreach ($billed_qty as $stock_bill):
              $discount_given = $discount_given + $stock_bill['discount'];
            endforeach;
              //echo $billed;
            $b_qty = find_all('customer_bill');
            $discount_prod=0;
            foreach ($b_qty as $stock_bill_n):
              $prod = find_by_id('products',$stock_bill_n['product_id']);
              $discount_prod = $discount_prod + $stock_bill_n['discount_quantity']*$prod['sale_price'];
            endforeach;
            $full_discount_out = $discount_prod+$discount_given;
            ?>
              <tr>
                <td>Rs. <?php echo $discount_got; ?></td>
                <td>Rs. <?php echo $discount_given; ?></td>
                <td>Rs. <?php echo $discount_prod; ?></td>
                <td><font color="red"><b>Rs. <?php echo $discount_prod+$discount_given; ?></b></font></td>
                <?php
                if(($discount_got - $full_discount_out)<0){
                ?>
                <td><font color="red"><b>Over Given Rs. <?php echo abs($discount_got - $full_discount_out); ?></font></b></td>
                <?php
                }else{
                ?>
                <td><font color="green"><b>Rs. <?php echo $discount_got - $full_discount_out; ?></font></b></td>
                <?php } ?>
              </tr>
          <tbody>
         </table>
       </div>
     </div>
   </div>
 </div>
<?php include_once('layouts/footer.php'); ?>