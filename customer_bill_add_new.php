<?php
require_once('includes/load.php');
if(isset($_GET['ok']))   
{
  $id = $_GET['inv'];
  $id1 = find_by_id('customer_bill_receive',$id);
  $inv = $id1['invoice_number'];
  $query = "INSERT INTO customer_bill SET invoice_number = '{$inv}',product_id = '{$_GET['pid']}',quantity = '{$_GET['qty']}',free_quantity = '{$_GET['free_qty']}',discount_quantity = '{$_GET['dsc']}',received_return = '{$_GET['rec']}',reissued = '{$_GET['reiss']}'";
  if($db->query($query)){
   echo '1';
 } else {
 
 }
}  

?>