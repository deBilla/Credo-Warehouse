<?php
  $page_title = 'All routes';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  
  $all_routes = find_all('routes');
  $all_customer = find_all('customer')
?>
<?php
 if(isset($_POST['add_cat'])){
   $req_field = array('categorie-name');
   validate_fields($req_field);
   $cat_name = remove_junk($db->escape($_POST['categorie-name']));
   if(empty($errors)){
      $sql  = "INSERT INTO routes (name) VALUES ('{$cat_name}')";
      if($db->query($sql)){
        $session->msg("s", "Successfully Added Route");
        redirect('route_create.php',false);
      } else {
        $session->msg("d", "Sorry Failed to insert.");
        redirect('route_create.php',false);
      }
   } else {
     $session->msg("d", $errors);
     redirect('route_create.php',false);
   }
 }
?>
<?php
 if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    echo $id;
    $query_r = "update routes set name = '{$_GET['name']}' where id = '{$_GET['edit']}'";
    $result_r = $db->query($query_r);
    header("Location:route_create.php");
    //sleep(5);
  }
?>
<?php include_once('layouts/header.php'); ?>

  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
  </div>
   <div class="row">
    <div class="col-md-5">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Route</span>
         </strong>
        </div>
        <div class="panel-body">
          <form method="post" action="route_create.php">
            <div class="form-group">
                <input type="text" class="form-control" name="categorie-name" placeholder="Route Name">
            </div>
            <button type="submit" name="add_cat" class="btn btn-primary">Add Routes</button>
            <a href="route_edit.php" class="btn btn-success" role="button">Create New Customers</a>
        </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>All Routes</span>
       </strong>
      </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Routes</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($all_routes as $cat):?>
                <tr>
                    <td><a href="customer_detail.php?route=<?php echo($cat['id']) ?>"><?php echo remove_junk(ucfirst($cat['name'])); ?></a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
       </div>
    </div>
    </div>
   </div>
  </div>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
  </div>
   </div>
  </div>
  <?php include_once('layouts/footer.php');