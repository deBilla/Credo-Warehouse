<?php
  $page_title = 'Stock Load';
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
$result = find_by_id('stock_load_receive',$id_stock);
$date = $result['date'];
?>
<div class="panel">
    <div class="panel panel-default">
        <div class="panel-heading clearfix"> 
            <span class="glyphicon glyphicon-th"></span> 
            <b>Stock Loading</b> 
        </div>
        <div class="panel clearfix">
                <form action="stock_load_manage.php?date_add=<?php echo $date;  ?>" method="POST">  
                    <div class="box box-primary">    
                        <div class="box-body">  
                            <div class="form-group">   
                                Route Name <br><b>
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
                    </select> 
                            </div>  
                        <div class="form-group">  
                                Date </br> <b>
                        <?php   echo $date;         ?></b>
                        </div> 
                        </div>  
                        <input type="submit" class="btn btn-success" name="save_add" value="Save Record">  
                    
                    </div><br/> 
                    <table id="myTable" class="table table-bordered">  
                        <thead>  
                            <th>Product Name</th>  
                            <th>Quantity</th> 
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
                            </tr>  
                        </tbody>
                    </table> 

               </div>
               </form> 
<script type="text/javascript">
$(document).on("click",".add",function(){
var n= $('.row').length+1;
var temp = $('.row:first').clone();
$('input:first',temp).attr('placeholder','Item #'+n)
$('.row:last').after(temp);
})
</script>
<script type="text/javascript">
$(document).on("click",".delete",function(){
$("#myTable .delete").click(function () {
    $(this).parents(".row:first")[0].remove();
});
});
</script> 
<?php include_once('layouts/footer.php'); ?>

