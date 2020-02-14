<?php
require_once('includes/load.php');
if(isset($_GET['ok']))   
{
  $id = $_GET['inv'];
  $query = "INSERT INTO credit_recover SET invoice_number = '{$id}',received_credit = '{$_GET['rec_cred']}',received_cheque = '{$_GET['rec_cheq']}',date = '{$_GET['date']}'";
  if($db->query($query)){
   echo '1';
 } else {
 
 }
}  

?>