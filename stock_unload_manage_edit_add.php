<?php
  $page_title = 'Stock unload';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all_prd('products');
  $all_routes = find_all('routes');
  $all_photo = find_all('media');
?>
<?php include_once('layouts/header.php'); ?> 
<?php
$id_stock = $_GET['id'];
$result = find_by_id('stock_unload_receive',$id_stock);
$date = $result['date'];
?>
<form action="stock_unload_manage.php?date_add=<?php echo $date;  ?>" method="POST">  
<div class="panel">
<div class="panel panel-default">
    <div class="panel-heading clearfix"> 
    <span class="glyphicon glyphicon-th"></span> 
        <b>Stock Unloading in <?php echo $date; ?></b>
        <div class="pull-right">
          <input type="submit" class="btn btn-primary" name="save_add" value="Save Record">
        </div>
    </div>
    <div class="panel clearfix">
    <table id="myTable" class="table table-bordered">  
      <thead>  
          <th>Product Name</th>  
          <th>Quantity</th>
          <th>Received Return</th>
      </thead>  
      <tbody class="detail">  
          <tr>
              <td><select class="form-control" name="productid">
                <option value="">Select the Product</option>
              <?php  foreach ($all_categories as $cat): ?>
                <option value="<?php echo (int)$cat['id'] ?>">
                  <?php echo $cat['name'] ?></option>
              <?php endforeach; ?>
              </select></td>  
              <td><input type="text" class="form-control quantity" name="quantity" value="0"></td>
              <td><input type="text" class="form-control amount" name="received_return" value="0"></td>
          </tr>  
      </tbody>
  </table>  </div></div></div>
  <div class="panel">
<div class="panel panel-default">
          <div class="panel clearfix">       
                <div class="form-group">   
                    <b>Route Name <br>
                    <?php  
                    $route_id = $result['route_id'];
                    $route = find_by_id('routes',$route_id);
                    $route_name =  $route['name'];
                   // echo $route_name;         
                    ?></b>
                    <select class="form-control" name="route_id">
                      <option value="<?php echo $route_id ?>"><?php echo $route_name ?></option>
                    <?php  foreach ($all_routes as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select></form></div></div></div></div>
<?php include_once('layouts/footer.php'); ?>

