<?php $user = current_user(); ?>
<!DOCTYPE html>
  <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title><?php if (!empty($page_title))
           echo remove_junk($page_title);
            elseif(!empty($user))
           echo ucfirst($user['name']);
            else echo "CredOxyz WareHouse Solution";?>
    </title>
    <meta name="viewport" content ="width=device-width,initial-scale=1,user-scalable=yes" />
    <link rel="stylesheet" href="libs/css/jquery-te-1.4.0.css"/>
    <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="libs/bootstrap/css/bootstrap-date.css"/>
    <link rel="stylesheet" href="libs/css/main.css" />

    <script type="text/javascript" src="libs/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="libs/js/jquery-migrate-1.4.1.min.js"></script>
    <script type="text/javascript" src="libs/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="libs/bootstrap/js/bootstrap-date.js"></script>
    <script type="text/javascript" src="libs/js/functions.js"></script>
    <script type="text/javascript" src="models/reports/func.js"></script>
    </head>
  <body>
  <?php  if ($session->isUserLoggedIn(true)): ?>
    <header id="header">
      <div class="logo pull-left"><a href = "http://credoxyz.epizy.com"><font color="white"> <?php echo $_SESSION['db_val'];  ?></font></a></div>
      <div class="header-content">
      <div class="header-date pull-left">
        <strong><b><i class="glyphicon glyphicon-time"></i> <?php 
        date_default_timezone_set("Asia/Colombo");
        echo date("F j, Y, g:i a");?></strong></b>
      </div>
      <div class="clearfix pull-right">
        <ul class="info-menu list-inline list-unstyled">
          <li class="profile">
            <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
              <img src="uploads/users/<?php echo $user['image'];?>" alt="user-image" class="img-circle img-inline">
              <span><?php echo remove_junk(ucfirst($user['name'])); ?> <i class="caret"></i></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                  <a href="profile.php?id=<?php echo (int)$user['id'];?>">
                      <i class="glyphicon glyphicon-user"></i>
                      Profile
                  </a>
              </li>
             <li>
                 <a href="edit_account.php" title="edit account">
                     <i class="glyphicon glyphicon-cog"></i>
                     Settings
                 </a>
             </li>
             <li class="last">
                 <a href="logout.php">
                     <i class="glyphicon glyphicon-off"></i>
                     Logout
                 </a>
             </li>
           </ul>
          </li>
        </ul>
      </div>
      <div class="clearfix pull-right">
        <ul class="info-menu list-inline list-unstyled">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="glyphicon glyphicon-book"></i> Reports
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li onclick="route_report()"><a href="#">Route Report</a></li>
            <li onclick="loading_report()"><a href="#">Loading Unloading Report</a></li>
            <li onclick="cash_report()"><a href="#">Cash Collection Report </a></li>
            <li onclick="cash_credit_report()"><a href="#">Credit Report</a></li>
            <li onclick="credit_route_test_report()"><a href="#">Credit Route test Report</a></li>
            <li><a href="credit_day35_report.php">28 days over credit Report</a></li>
            <li onclick="credit_route_report()"><a href="#">Credit Report Of Route</a></li>
            <li><a href="stock_report_current.php">Stock Report</a></li>
            <li onclick="product_sale_report()"><a href="#">Product Sale Report</a></li>
            <li onclick="stock_report()"><a href="#">Stock receive Report</a></li>
            <li onclick="discount_report()"><a href="#">Discount and free issue Report</a></li>
          </ul>
        </li>
      </ul>
      </div>
      <div class="clearfix pull-right">
        <ul class="info-menu list-inline list-unstyled">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="glyphicon glyphicon-user"></i> User Management
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
           <li><a href="group.php">Manage Groups</a> </li>
            <li><a href="users.php">Manage Users</a> </li>
          </ul>
        </li>
      </ul>
      </div>
     </div>
      <div class="clearfix pull-right">
        <ul class="info-menu list-inline list-unstyled">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#"> 
          <a href="media.php" >
          <i class="glyphicon glyphicon-picture"></i> Media Files
        </li>
      </ul>
      </div>
     </div>
    </header>
    <div class="sidebar">
      <?php if($user['user_level'] === '1'): ?>
        <!-- admin menu -->
      <?php include_once('admin_menu.php');?>

      <?php elseif($user['user_level'] === '2'): ?>
        <!-- Special user -->
      <?php include_once('special_menu.php');?>

      <?php elseif($user['user_level'] === '3'): ?>
        <!-- User menu -->
      <?php include_once('user_menu.php');?>

      <?php endif;?>

   </div>
<?php endif;
$all_routes = find_all('routes');
include_once('models/reports/route.php');
?>
<div class="page">
  <div class="container-fluid">
