<?php
$page_title = 'Sales Report';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
  $start_date   = remove_junk($db->escape($_GET['date']));
  $results      = find_loading_unloading_by_date($start_date);
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
    <div class="page-break">
       <div class="sale-head pull-right">
           <h1>Loading Unloading Report</h1>
           <strong><?php if(isset($start_date)){ echo $start_date;}?> </strong>
       </div>
               <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center"> Loading</th>
                <th class="text-center"> Billed</th>
                <th class="text-center"> Unloading</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($results as $product_n):

              $route = find_by_id('routes',$product_n['route_id']);

              ?>
              <tr>
                <td class="text-center">
                  <table class="table table-border">
                  <thead>
                    <tr>
                      <th class="text-center" > Product <br> Name</th>
                      <th class="text-center" > Quantity </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $product_customer = join_load_by_date($product_n['date']);
                    $product_arr = array(); //declaring an array
                    $name_arr = array(); //declaring an array
                    $incr = 0;
                    //print_r($product_customer);
                    foreach($product_customer as $product_c):
                      $name_arr[$incr] = $product_c['product_id'];
                      $product_arr[$incr] = array($product_c['product_id'],$product_c['quantity']);
                      $incr++;
                    endforeach;
                    //print_r($product_arr);
                    $product_w = find_all_prd('products');
                    
                    foreach($product_w as $product):
                      if (in_array($product['id'], $name_arr)){ //check
                        //continue; 
                        $index = array_search($product['id'], $name_arr);
                    ?>
                    <tr>    
                      <td class="text-center"> <?php echo remove_junk($product['name']); ?></td>
                      <td class="text-right"> <b><?php echo remove_junk($product_arr[$index][1]); ?></b></td>
                    </tr>
                    <?php
                      }else{
                    ?>
                    <tr>    
                      <td class="text-center"> <?php echo remove_junk($product['name']); ?></td>
                      <td class="text-right"><b>0</b> <?php //echo remove_junk($product['received_return']); ?></td>
                    </tr>
                    <?php } ?>
                    <?php endforeach; ?>
                  </tbody>
                  </table>
                </td>


                <td class="text-center">
    <!-- customer bill -->
                  <table class="table table-border">
                  <thead>
                    <tr>
                      
                      <th class="text-center" > Quantity </th>
                      <th class="text-center" > Free <br>Quantity </th>
                      <th class="text-center" > Discount<br> Quantity </th>
                      <th class="text-center" > Re<br>Issued </th>
                      <th class="text-center" > Total <br> Quantity </th>
                      <th class="text-center" > Return <br> Received </th>
                      <!--<th class="text-center" > Product</th>-->
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $product_customer = join_custload_by_date_p($product_n['date']);
                    $product_arr = array(); //declaring an array
                    $name_arr = array(); //declaring an array
                    $incr = 0;
                    //print_r($product_customer);
                    foreach($product_customer as $product_c):
                      $name_arr[$incr] = $product_c['product_id'];
                      $product_arr[$incr] = array($product_c['product_id'],$product_c['quantity'],$product_c['free_quantity'],$product_c['discount_quantity'],$product_c['received_return'],$product_c['reissued']);
                      $incr++;
                    endforeach;
                    //print_r($product_arr);
                    $product_w = find_all_prd('products');
                    
                    foreach($product_w as $product):
                      if (in_array($product['id'], $name_arr)){ //check
                        //continue; 
                        $index = array_search($product['id'], $name_arr);
                        $total_quantity = $product_arr[$index][1]+$product_arr[$index][2]+$product_arr[$index][3]+$product_arr[$index][5];
                    ?>
                    <tr>    
                      <td class="text-right"> <?php echo remove_junk($product_arr[$index][1]); ?></td>
                      <td class="text-right"> <?php echo remove_junk($product_arr[$index][2]); ?></td>
                      <td class="text-right"> <?php echo remove_junk($product_arr[$index][3]); ?></td>
                      <td class="text-right"> <?php echo remove_junk($product_arr[$index][5]); ?></td>
                      <td class="text-right"> <b><font color="red"> <?php echo remove_junk($total_quantity); ?></font></b></td>
                      <td class="text-right"> <?php echo remove_junk($product_arr[$index][4]); ?></td>
                      <!--<td class="text-left">  <?php echo remove_junk($product['name']); ?></td>-->
                    </tr>
                    <?php
                      }else{
                    ?>
                    <tr>    
                      <td class="text-right"> 0<?php //echo remove_junk($product['quantity']); ?></td>
                      <td class="text-right"> 0<?php //echo remove_junk($product['received_return']); ?></td>
                      <td class="text-right"> 0<?php //echo remove_junk($product['quantity']); ?></td>
                      <td class="text-right"> 0<?php //echo remove_junk($product['received_return']); ?></td>
                      <td class="text-right"> <b><font color="red">0</font></b><?php //echo remove_junk($product['received_return']); ?></td>
                      <td class="text-right"> 0<?php //echo remove_junk($product['reissued']); ?></td>
                      <!--<td class="text-left"> <?php echo remove_junk($product['name']); ?></td>-->
                    </tr>
                    <?php } ?>
                    <?php endforeach; ?>
                  </tbody>
                  </table>
                </td>
 <!-- customer bill Ends-->
                <td class="text-center">  
          <!-- Unloading -->            
                  <table class="table table-border">
                  <thead>
                    <tr>
                      <!--<th class="text-center" > Product Name </th>-->
                      <th class="text-center" > Quantity </th>
                      <th class="text-center" > Return <br> Received </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $product_customer = join_unload_by_date_v1($product_n['date']);
                    $product_arr = array(); //declaring an array
                    $name_arr = array(); //declaring an array
                    $incr = 0;
                    //print_r($product_customer);
                    foreach($product_customer as $product_c):
                      $name_arr[$incr] = $product_c['product_id'];
                      $product_arr[$incr] = array($product_c['product_id'],$product_c['quantity'],$product_c['received_return']);
                      $incr++;
                    endforeach;
                    //print_r($product_arr);
                    $product_w = find_all_prd('products');
                    
                    foreach($product_w as $product):
                      if (in_array($product['id'], $name_arr)){ //check
                        //continue; 
                        $index = array_search($product['id'], $name_arr);
                    ?>
                    <tr>    
                      <td class="text-right"> <b><?php echo remove_junk($product_arr[$index][1]); ?></b></td>
                      <td class="text-right"> <?php echo remove_junk($product_arr[$index][2]); ?></td>
                    </tr>
                    <?php
                      }else{
                    ?>
                    <tr>    
                      <td class="text-right"><b>0 </b><?php //echo remove_junk($product['quantity']); ?></td>
                      <td class="text-right">0 <?php //echo remove_junk($product['received_return']); ?></td>
                    </tr>
                    <?php } ?>
                    <?php endforeach; ?>
                  </tbody>
                  </table>
                </td>
                </tr>
             <?php endforeach; ?>
            </tbody>
          </tabel>

    </div>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
