<?php
require_once('includes/load.php');
if(isset($_GET['ok']))   
{
  $query = "INSERT INTO company_return_receive SET invoice_number = '{$_GET['inv']}',product_id = '{$_GET['pid']}',quantity = '{$_GET['qty']}'";
  if($db->query($query)){
   echo '1';
 } else {
 	
 }
}  

?>