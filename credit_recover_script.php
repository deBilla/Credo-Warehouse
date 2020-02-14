<?php
 
require_once('includes/load.php');
	
$name_arr = "";
$cust_id = $_GET['cust_id'];
$sqlquery = "SELECT * FROM customer_bill_receive WHERE customer_id = '{$cust_id}'";
$result = $db->query($sqlquery);
$num_row = mysqli_num_rows($result);
while ($row = mysqli_fetch_array($result)) {
	$name_arr = $name_arr.",".$row['invoice_number'];
}
$num_row = mysqli_num_rows($result);
if($num_row<=0){
	echo '2';
}else{
	echo $name_arr;
}
?>