<?php
  $page_title = 'Add Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all('routes');
  $all_photo = find_all('media');
?>
 
<?php   
if(isset($_POST['save']))  
{  
$id=$_POST['route_name'];
foreach ($_POST['name'] as $i => $value) {
    if($_POST['name'][$i]==''){
        echo "fail" ;
    }else{
    $query = "INSERT INTO customer SET route_id = '{$id}',name = '{$_POST['name'][$i]}',address = '{$_POST['address'][$i]}', active_customer = '1'";
    $db->query($query);
    $customer_id = find_by_name('customer',$_POST['name'][$i]);
    $date = date('Y-m-d');
    $query_credit = "INSERT INTO credit SET on_credit = '0',credit = '0',date = '{$date}', customer_id = '{$customer_id['id']}' ";
    $db->query($query_credit);
    }
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<form action="" method="POST">
<div class="panel">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <span class="glyphicon glyphicon-th"></span>  
            <b>New Customer</b> 
            <div class="pull-right">
              <input type="submit" class="btn btn-primary" name="save" value="Save Record">
            </div>
        </div>
        <div class="panel clearfix">
            <table id="myTable" class="table table-bordered">  
                  <thead>  
                      
                      <th>Name</th>  
                      <th>Adress</th>  
                       
                      <th><input type='button' class="btn btn-success" id='add' value='Add item'/></th>  
                  </thead>  
                  <tbody class="detail">  
                      <tr>
                           
                          <td><input type="text" class="form-control quantity" name="name[]"></td>  
                          <td><input type="text" class="form-control discount" name="address[]"></td>  
                      
                          <th><input type='button' class="btn btn-danger" id='delete' value='delete item'"/></th>
                      </tr>  
                  </tbody>   
              </table> 
                    </div></div></div> 
                    <div class="panel">
    <div class="panel panel-default">
      <div class="panel clearfix">
                   <div class="form-group">  
                    <select class="form-control" name="route_name">
                      <option value="">Select route name</option>
                    <?php  foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select> 
                            </div>    
                        </div>  
                          
                    
                   </div></div></form>
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
