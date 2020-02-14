<?php
  $page_title = 'All Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $all_routes = find_all('routes');
?>
<?php
$cust_id=$_GET['id'];
$all_customer = find_by_id('customer',$cust_id);
//$cust_detail = find_by_custdetail_id('customer_bill_receive',$cust_id);
$customer_detail = join_custdetail_by_id($cust_id);
//echo print_r($cust_ff);
?> 
<?php include_once('layouts/header.php'); ?>
  <div class="row">
    <div class="col-md-12">
       <?php echo display_msg($msg); ?>
    </div>
    <form action="customer_detail_proceed.php?id=<?php echo $cust_id ?>" method="POST">  
    <div class="col-md-12">
      <div class="form-group">
        <button name="save" type="submit" class="btn btn-success">Save</button>
     <div class="col-md-12">
     <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    
                    </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="text" class="form-control quantity" name="name"  value="<?php echo remove_junk(ucfirst($all_customer['name'])); ?>"></td>  
              </tr>
            </tbody>
          </table>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>            
                    <th>Address</th>
                    
                    </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="text" class="form-control quantity" name="address"  value="<?php echo remove_junk(ucfirst($all_customer['address'])); ?>"></td>  
              </tr>
            </tbody>
          </table>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>            
                    <th>Route</th>
                    
                    </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php
                $v = $all_customer['route_id'];
                $cl = find_by_id('routes',$v);
               
                 ?>
                   <select class="form-control" name="route_id">
                      <option value="<?php  echo $cl['id'];?>"><?php  echo $cl['name'];?>
                        </option>
                    <?php  foreach ($all_routes as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select> 
                 </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>            
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <?php $status = $all_customer['active_customer']; 
                  ?> 
                  <select class="form-control" name="status">
                    <option value = "<?php echo $status ?>"><?php    
                    if ($status==0){
                      echo "Inactive";
                    } else {
                      echo "Active";
                    }
                    ?></option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select> 
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</form>
</div>

  <?php include_once('layouts/footer.php'); ?>        