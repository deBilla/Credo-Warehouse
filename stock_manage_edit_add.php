<?php
  $page_title = 'Add Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all_prd('products');
  $all_photo = find_all('media');
?>
<?php
$id_stock = $_GET['id'];
$result = find_by_id('stock_receive',$id_stock);
$date = $result['invoice_number'];
?>
<?php include_once('layouts/header.php'); ?> 
<div class="panel">
    <div class="panel panel-default">
        <div class="panel-heading clearfix"> 
            <span class="glyphicon glyphicon-th"></span> 
            <b>Company Stock Receive</b> 
        </div>
        <div class="panel clearfix">
                <form action="stock_manage.php?inv_n=<?php echo $result['invoice_number'] ?>" method="POST">  
                    <div class="box box-primary">   
                        <div class="box-body">  
                            <b><div class="form-group">  
                                <h3> 
                                  <?php echo $result['invoice_number'] ?> </h3></b>  
                            </div>  
                            <b><div class="form-group">  
                                Discount 
                                <input type="text" class="form-control quantity" name="discount" value="<?php echo $result['discount'] ?>"> 
                                    </b>  
                            </div>  
                        </div>  
                        <input type="submit" class="btn btn-success" name="save_add" value="Save Record">  
                    
                    </div><br/>
                    <table id="myTable" class="table table-bordered">  
                        <thead>  
                            <th>Product Name</th>  
                            <th>Quantity</th> 
                            <th>Free Quantity</th>   
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
                                <td><input type="text" class="form-control amount" name="free_quantity" value="0" ></td>  
                            </tr>  
                        </tbody>   
                    </table> 

               </div>
               </form> 
<?php include_once('layouts/footer.php'); ?>
