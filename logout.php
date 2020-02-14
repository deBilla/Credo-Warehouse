<?php
  require_once('includes/load.php');
  if(!$session->logout()) {redirect("index1.php");}
?>
