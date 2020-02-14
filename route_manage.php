<?php
  $page_title = 'All categories';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  
  $all_routes = find_all('routes');
  $all_customer = find_all('customer');
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
                    <th class="text-center" style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($all_routes as $cat):?>
                <tr>
                  <td>
                    <?php     
                          if($cat['id']==$_GET['id']){
                    ?>
                    <input id='userInput' type="text" class="form-control quantity" name="quantity" value="<?php echo remove_junk(ucfirst($cat['name'])); ?>">

                    <?php }else{  ?>
                    <?php echo remove_junk(ucfirst($cat['name'])); } ?>
                  </td>
                    <td class="text-center">
                      <div class="btn-group">
                        <?php     
                          if($cat['id']==$_GET['id']){
                        ?>
                        <input type='button' onclick='changeText2(<?php echo $_GET['id']; ?>)'  class="btn btn-xs btn-success" value="Edit"/>
                        <?php }else{  ?>
                        <a href="route_manage.php?id=<?php echo (int)$cat['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                          <span class="glyphicon glyphicon-edit"></span>
                        <?php }  ?>
                        </a>
                        <a href="delete_categorie.php?id=<?php echo (int)$cat['id'];?>"  class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                          <span class="glyphicon glyphicon-trash"></span>
                        </a>
                      </div>
                    </td>

                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
       </div>
    </div>
    </div>
   </div>
  </div>
  <script type="text/javascript">
    function changeText2($id){
    var userInput = document.getElementById('userInput').value;
    window.location = "route_create.php?name="+userInput+"&edit="+$id;
  }
  </script>
  <?php include_once('layouts/footer.php');