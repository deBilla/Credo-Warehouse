<?php
  $page_title = 'Add Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all_prd('products');
  $all_customer = find_all_cst('customer');
?>
<?php include_once('layouts/header.php'); ?> 
<?php
$product = find_by_id('customer_bill',(int)$_GET['id']);
$x = $product['invoice_number'];
$y = remove_junk($product['product_id']);
$all_categories = find_all('products');
$customer_receive_special = find_by_invoice('customer_bill_receive',$x);
$pnm = find_by_id('products',$y);
$node = $customer_receive_special['customer_id'];
$cust_name = find_by_id('customer',$node);
if(!$product){
  $session->msg("d","Missing Invoice Number.");
  redirect('customer_bill_manage.php');
} 
?>
<?php
if(isset($_POST['save'])){
        $invoice_number  = remove_junk($db->escape($_POST['invoice_number']));
        $date   = $_POST['date'];
        $discount  = remove_junk($db->escape($_POST['discount']));
        $productid   = remove_junk($db->escape($_POST['productid']));
        $quantity   = remove_junk($db->escape($_POST['quantity']));
        
        $free_quantity  = remove_junk($db->escape($_POST['free_quantity']));
        $discount_quantity  = remove_junk($db->escape($_POST['discount_quantity']));
        $customer_id = remove_junk($db->escape($_POST['customer_id']));  
        $cash=remove_junk($db->escape($_POST['cash']));
        $return_sale = $_POST['return_sale'];
        $credit=remove_junk($db->escape($_POST['credit']));
        $cheque=remove_junk($db->escape($_POST['cheque']));
        $received_return=remove_junk($db->escape($_POST['received_return'])); 
        $reissued = remove_junk($db->escape($_POST['reissued'])); 

        $query_r = "update customer_bill_receive set invoice_number = '{$invoice_number}',date = '{$date}',cash = '{$cash}',credit = '{$credit}',cheque = '{$cheque}',customer_id = '{$customer_id}',discount = '{$discount}',return_sale = '{$return_sale}' where id = '{$customer_receive_special['id']}'";
       $result_r = $db->query($query_r);

       $query = "UPDATE customer_bill SET invoice_number = '{$invoice_number}',product_id = '{$productid}',quantity = '{$quantity}',free_quantity = '{$free_quantity}',discount_quantity = '{$discount_quantity}',received_return = '{$received_return}',reissued = '{$reissued}'  where id = '{$product['id']}'";
       $result = $db->query($query);
}
 
?>
<script type="text/javascript">
    function ref1(){
        window.reload();
    }
</script>
<form action="" method="POST"> 
<div class="panel">
<div class="panel panel-default">
    <div class="panel-heading clearfix"> 
        <span class="glyphicon glyphicon-th"></span> 
        <b>Customer Bill</b>
        <div class="pull-right">
                    <input type="submit" class="btn btn-primary" name="save" value="Save Record">
                    <input type="submit" class="btn btn-success" onclick="ref1();" name="refersh" value="Refresh">
        </div>
    </div>
        <div class="panel clearfix"> 
                        <table id="myTable" class="table table-bordered table-hover">  
                        <thead>  
                            <th>Product ID</th>  
                            <th>Quantity</th>  
                            <th>Free Quantity</th>
                            <th>Discount Quantity</th>
                            <th>Received Return</th>
                            <th>Reissued</th> 
                        </thead>  
                        <tbody class="detail">  
                            <tr>
                                <td><select class="form-control" name="productid">
                      <option value="<?php echo remove_junk($product['product_id']);?>"><?php echo remove_junk($pnm['name']);?></option>
                    <?php  foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select></td>  
                                <td><input type="text" class="form-control quantity" name="quantity"  value="<?php echo remove_junk($product['quantity']);?>"></td>  
                                <td><input type="text" class="form-control amount" name="free_quantity" value="<?php echo remove_junk($product['free_quantity']);?>"></td> 
                                <td><input type="text" class="form-control amount" name="discount_quantity" value="<?php echo remove_junk($product['discount_quantity']);?>"></td> 
                                <td><input type="text" class="form-control amount" name="received_return" value="<?php echo remove_junk($product['received_return']);?>"></td> 
                                <td><input type="text" class="form-control amount" name="reissued" value="<?php echo remove_junk($product['reissued']);?>"></td>
                            </tr>  
                        </tbody>    
                    </table> 
                </div></div></div>
                <div class="panel">
<div class="panel panel-default">
    <div class="panel clearfix">  
                            <div class="form-group">  
                                Bill Number  
                                <input type="number" name="invoice_number" class="form-control" value="<?php echo remove_junk($customer_receive_special['invoice_number']);?>">  
                            </div>  
                             <div class="form-group">  
                                Customer Name  
                                <select class="form-control" name="customer_id">
                      <option value="1"><?php echo remove_junk($cust_name['name']);?>
                        </option>
                    <?php  foreach ($all_customer as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select> 
                            </div>  
                            <div class="form-group">
                              Date
                                <div class="input-group">
                                  <input type="text" class="datepicker form-control" name="date" value="<?php echo remove_junk($customer_receive_special['date']);?>">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                                </div>
                            </div>

                            <div class="form-group">  
                                Cash  
                                <input type="decimal" name="cash" class="form-control" value="<?php echo remove_junk($customer_receive_special['cash']);?>">  
                            </div>
                            <div class="form-group">  
                                <font color="blue"> <b>Return Sale</b></font>
                                <input type="decimal" class="form-control" name="return_sale" value="<?php echo remove_junk($customer_receive_special['return_sale']);?>">
                            </div>  

                            <div class="form-group">  
                                <font color="red"> <b>Discount</b></font>
                                <input type="decimal" class="form-control" name="discount" value="<?php echo remove_junk($customer_receive_special['discount']);?>">
                            </div>
                            <div class="form-group">  
                                Credit  
                                <input type="decimal" name="credit" class="form-control" value="<?php echo remove_junk($customer_receive_special['credit']);?>">  
                            </div>  
 
                            <div class="form-group">  
                                Cheque 
                                <input type="decimal" name="cheque" class="form-control" value="<?php echo remove_junk($customer_receive_special['cheque']);?>">  
                            </div>   

                        </div>  
                          
               </form> 

<?php include_once('layouts/footer.php'); ?>

