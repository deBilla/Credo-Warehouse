<?php
  $page_title = 'Edit Stock';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$product = find_by_id('stock',(int)$_GET['id']);
$x = $product['invoice_number'];
$y = remove_junk($product['product_id']);
$all_categories = find_all_prd('products');
$stock_receive_special = find_by_invoice('stock_receive',$x);
$pnm = find_by_id('products',$y);

if(!$product){
  $session->msg("d","Missing Invoice Number.");
  redirect('stock_manage.php');
}
?>
<?php
if(isset($_POST['save'])){
    $req_fields = array('invoice_number','date','productid','quantity', 'discount','free_quantity' );
    validate_fields($req_fields);

   if(empty($errors)){
       $invoice_number  = remove_junk($db->escape($_POST['invoice_number']));
       $date   = $_POST['date'];
       $productid   = remove_junk($db->escape($_POST['productid']));
       $quantity   = remove_junk($db->escape($_POST['quantity']));
       $discount  = remove_junk($db->escape($_POST['discount']));
       $free_quantity  = remove_junk($db->escape($_POST['free_quantity']));
       $query_r = "UPDATE stock_receive SET discount = '{$discount}',date = '{$date}' where id = '{$product['id']}'";
       $result_r = $db->query($query_r);
       $query = "UPDATE stock SET product_id = {$productid} ,quantity = '{$quantity}',free_quantity = '{$free_quantity}' where id = '{$product['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Product updated ");
                 redirect('stock_manage.php', false);
               } else {
                 $session->msg('d',' Sorry failed to updated!');
                 redirect('stock_edit.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('stock_edit.php?id='.$product['id'], false);
   }
 
}
 
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<form action="stock_edit.php?id=<?php echo (int)$product['id'] ?>" method="POST">  
<div class="panel">
    <div class="panel panel-default">
        <div class="panel-heading clearfix"> 
            <span class="glyphicon glyphicon-th"></span> 
            <b>Company Stock Receive</b> 
            <div class="pull-right">
              <input type="submit" class="btn btn-primary" name="save" value="Save Record">
            </div>
        </div>
        <div class="panel clearfix"> 
              <table id="myTable" class="table table-bordered">  
                        <thead>  
                            <th>Product Name</th>  
                            <th>Quantity</th>  
                            <th>Free Quantity</th>   
                        </thead>  
                        <tbody class="detail">  
                            <tr>
                                <td>
                                  <select class="form-control" name="productid">
                                      <option value="<?php echo remove_junk($pnm['id']);?>"><?php echo remove_junk($pnm['name']);?></option>
                                        <?php  foreach ($all_categories as $cat): ?>
                                          <option value="<?php echo (int)$cat['id'] ?>">
                                            <?php echo $cat['name'] ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                    </td>  
                                    <td><input type="text" class="form-control quantity" name="quantity" value="<?php echo remove_junk($product['quantity']);?>">
                                    </td> 
                                    <td><input type="text" class="form-control amount" name="free_quantity" value="<?php echo remove_junk($product['free_quantity']);?>">
                                    </td>  
                                  </tr>
                                </tbody>
                              </table>
                              </div></div></div> 
                              <div class="panel">
    <div class="panel panel-default">
        <div class="panel clearfix"> 
 
                            <div class="form-group">  
                                Invoice Number  
                                <input type="number" name="invoice_number" class="form-control" value="<?php echo remove_junk($product['invoice_number']);?>">  
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                  <input type="text" class="datepicker form-control" name="date" value="<?php echo $stock_receive_special["date"]?>">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                                </div>
                            </div>   
                            
                            <div class="form-group">  
                                Discount
                                <input type="decimal" name="discount" class="form-control" value="<?php echo $stock_receive_special["discount"]?>">  
                            </div>  
                        </div>  
                          
                    
                    </div></div>
                    
                          </form> 
<?php include_once('layouts/footer.php'); ?>
