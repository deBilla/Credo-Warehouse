<?php
  $page_title = 'Edit RETURN';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$product = find_by_id('company_return_receive',(int)$_GET['id']);
$x = $product['invoice_number'];
$y = remove_junk($product['product_id']);
$all_categories = find_all_prd('products');
$stock_receive_special = find_by_invoice('company_return',$x);
$pnm = find_by_id('products',$y);

if(!$product){
  $session->msg("d","Missing Invoice Number.");
  redirect('company_return_manage.php');
}
?>
<?php
if(isset($_POST['save'])){
    $req_fields = array('invoice_number','date','productid','quantity');
    validate_fields($req_fields);

   if(empty($errors)){
       $invoice_number  = remove_junk($db->escape($_POST['invoice_number']));
       $date   = $_POST['date'];
       $productid   = remove_junk($db->escape($_POST['productid']));
       $quantity   = remove_junk($db->escape($_POST['quantity']));
       $query = "UPDATE company_return_receive SET quantity = '{$quantity}', product_id = {$productid} where id = '{$product['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Company return updated ");
                 redirect('company_return_manage.php', false);
               } else {
                 $session->msg('d',' Sorry failed to updated!');
                 redirect('company_return_edit.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('company_return_edit.php?id='.$product['id'], false);
   }
 
}
 
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<form action="company_return_edit.php?id=<?php echo (int)$product['id'] ?>" method="POST"> 
<div class="panel">
<div class="panel panel-default">
    <div class="panel-heading clearfix"> 
        <span class="glyphicon glyphicon-th"></span> 
        <b>Company Return</b>
        <div class="pull-right">
         <input type="submit" class="btn btn-primary" name="save" value="Save Record">  </div>
    </div>
    <table id="myTable" class="table table-bordered">  
                        <thead>  
                            <th>Product Name</th>  
                            <th>Quantity</th>  
                        </thead>  
                        <tbody class="detail">  
                            <tr>
                                <td><select class="form-control" name="productid">
                      <option value="<?php echo remove_junk($pnm['name']);?>"><?php echo remove_junk($pnm['name']);?></option>
                    <?php  foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select></td>  
                                <td><input type="text" class="form-control quantity" name="quantity" value="<?php echo remove_junk($product['quantity']);?>"></td>  
                            </tr>  
                        </tbody>   
                    </table> </div></div>
     <div class="panel">
<div class="panel panel-default">               
    <div class="panel clearfix">  
                    <div class="box box-primary">  
                        <div class="box-body">  
                            <div class="form-group">  
                                Invoice Number  
                                <input type="number" name="invoice_number" class="form-control" value="<?php echo remove_junk($product['invoice_number']);?>">  
                            </div>  
                            <div class="form-group">
                          Date
                            <div class="input-group">
                              <input type="text" class="datepicker form-control" name="date" value="<?php echo $stock_receive_special["date"]?>">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                            </div>
                        </div>
                        </div>  
                       
                    
                    </div>
               </form> 
<?php include_once('layouts/footer.php'); ?>
