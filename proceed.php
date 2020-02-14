<?php

require_once("includes/session.php");
$_SESSION['db_val'] = $_POST['agency'];

header("Location:index1.php")


?>