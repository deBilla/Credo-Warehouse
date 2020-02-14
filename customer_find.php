<?php
require_once('includes/load.php');
$id = $_GET['cus_name'];
//echo $id;
//$id = 'B.M.R Foodcity 2';
$r = find_by_name('customer',$id);
//print_r($r);
echo $r['id'].",".$r['route_id'];
//echo "string";
?>