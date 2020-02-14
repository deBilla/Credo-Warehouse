<?php
  $page_title = 'Add Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all_prd('products');
  $all_photo = find_all('media');
?>
<?php include_once('layouts/header.php'); ?> 
<?php  
if(isset($_POST['save']))  
{  
$name=$_POST['invoice_number'];  
$location=$_POST['date'];  
$query = "insert into company_return(invoice_number,date) VALUES ('$name','$location')"; 
$db->query($query);
$id=$_POST['invoice_number']; 
foreach ($_POST['productid'] as $i => $value) {
    $query_r = "INSERT INTO company_return_receive SET invoice_number = '{$id}',product_id = '{$_POST['productid'][$i]}',quantity = '{$_POST['quantity'][$i]}'";
    $db->query($query_r);
    }
}
?>
<form action="" method="POST">  
<div class="panel">
<div class="panel panel-default">
    <div class="panel-heading clearfix"> 
        <span class="glyphicon glyphicon-th"></span> 
        <b>Company Return</b>
        <div class="pull-right">
          <input type="submit" class="btn btn-primary" name="save" value="Save Record"> 
        </div>
    </div>    
<div class="panel clearfix">             
                    <table id="myTable" class="table table-bordered table-hover">  
                        <thead>  
                            <th>Product Name</th>  
                            <th>Quantity</th>  
                            <th><input type='button' class="btn btn-success" id='add' value='Add item'/></th>  
                        </thead>  
                        <tbody class="detail">  
                            <tr>
                                <td><select class="form-control" name="productid[]">
                      <option value="">Select the Product</option>
                    <?php  foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select></td>  
                                <td><input type="text" class="form-control quantity" name="quantity[]" value="0"></td>  
                                <th><input type='button' class="btn btn-danger" id='delete' value='delete item'"/></th>
                            </tr>  
                        </tbody>  
                    </table></div></div></div>
        <div class="panel">
<div class="panel panel-default"> 
    <div class="panel clearfix">
                            <div class="form-group">  
                                <b>Invoice Number  
                                <input type="number" name="invoice_number" class="form-control">  
                            </div>  
                        <div class="form-group">
                          <label class="form-label">Date</label>
                            <div class="input-group">
                              <input type="text" class="datepicker form-control" name="date" placeholder="date">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                            </div>
                        </div>
                         </b>
                    
                    </div></div></div>
               </form> 
<script type="text/javascript">
$(document).on("click","#add",function(){
var n= $('#myTable').length+1;
var temp = $('#myTable:first').clone();
$('input:first',temp).attr('placeholder','Item #'+n)
$('#myTable:last').after(temp);
})
</script>
<script type="text/javascript">
$(document).on("click","#delete",function(){
    $(this).parents("#myTable:first")[0].remove();
});
</script> 
<?php include_once('layouts/footer.php'); ?>
