<?php
  require_once('includes/load.php');
  if(!$session->logout_session()) {redirect("index.php");}
?>
