<?php
require_once('includes/load.php');
$id = $_GET['id'];
$r = find_by_id('products',$id);
echo $r['id'].",".$r['buy_price'].",".$r['sale_price'];

?>