<?php
  $page_title = 'All Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $products = join_product_table();
  //$stock = find_all('stock_unload_receive');
  $all_categories = find_all_prd('products');
  $all_routes = find_all('stock_unload_receive');
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
<?php
if(isset($_GET['id'])){
$route_id=$_GET['id'];
$stock = find_all('stock_unload_receive');
//echo print_r($stock_received);
?>     
  <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <span class="glyphicon glyphicon-th"></span>
         <b>Stock Unloading edit</b>
         <div class="pull-right">
          <input type='button' value="Save" onclick='changeText2(<?php echo $_GET['id']; ?>)' class="btn btn-primary"></a>
         </div>
        </div>
              <?php foreach ($stock as $product_n):
              
              $route = find_by_id('routes',$product_n['route_id']);

              ?>
              <?php $product_w = join_unload_by_date($product_n['date']);
              foreach($product_w as $product):

                if ($route_id == $product['id']){

              ?>
                
          <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center" > Product Name </th>
              <th class="text-center" > Quantity </th>
               <th class="text-center" > Received Return </th>
            </tr>
          </thead>
          <?php  } endforeach;     ?>
          <tbody>
            <?php $product_w = join_unload_by_date($product_n['date']);
              foreach($product_w as $product):
                if ($route_id == $product['id']){
              ?>
            <tr>
              <td> 
                <select id="productid" class="form-control" name="productid[]">
                  <option value="<?php echo remove_junk($product['product_id']); ?>"><?php echo remove_junk($product['name']); ?></option>
                <?php  foreach ($all_categories as $cat): ?>
                  <option value="<?php echo (int)$cat['id'] ?>">
                    <?php echo $cat['name'] ?></option>
                <?php endforeach; ?>
                </select>
              </td>

              <td class="text-center">
                  <input id='quantity' type="text" class="form-control quantity" name="quantity" value="<?php echo remove_junk($product['quantity']); ?>">
               </td>
               <td class="text-center">
                  <input id='received_return' type="text" class="form-control quantity" name="received_return" value="<?php echo remove_junk($product['received_return']); ?>">
               </td>
            </tr>
            <?php }else{} endforeach;  ?>
          </tbody>
          </table>
             <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div> 
<?php } ?> 
<script type="text/javascript">
    function changeText2($id){
    var productid = document.getElementById('productid').value;
    var quantity = document.getElementById('quantity').value;
    var received_return=document.getElementById('received_return').value;
    window.location = "stock_unload_manage.php?productid="+productid+"&quantity="+quantity+"&received_return="+received_return+"&edit="+$id+"&ok=1";
  }
  </script>
<?php include_once('layouts/footer.php'); ?>
