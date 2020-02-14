<?php
  require_once('includes/load.php');
?>
<?php
  $product = find_by_id($_GET['table'],(int)$_GET['id']);
  if(!$product){
    echo "2";
  }
?>
<?php
  $delete_id = delete_by_id($_GET['table'],(int)$product['id']);
  if($delete_id){
      echo "1";
  } else {
      
  }
?>
