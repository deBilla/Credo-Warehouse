<?php
 
require_once('includes/load.php');

$inv = $_GET['inv'];
$row = join_credit_invoice($inv);
echo $row[0]['date'].",".$row[0]['credit'].",".$row[0]['name'].",".$row[0]['paid'].",".$row[0]['r_name'];
?>