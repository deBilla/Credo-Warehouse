<?php 
$page_title = 'Credit over 35 days Report';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
  $route = $_GET['route_name'];
  $results = find_credit_over_35_p($route);
  $results_p = find_credit_over_35_q($route);
?>
<!doctype html>
<html lang="en-US">
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Default Page Title</title>
    <link rel="stylesheet" href="css/jquery-te-1.4.0.css"/>
    <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="libs/bootstrap/css/bootstrap-date.css"/>
   <style>
   @media print {
     html,body{
        font-size: 9.5pt;
        margin: 0;
        padding: 0;
     }.page-break {
       page-break-before:always;
       width: auto;
       margin: auto;
      }
    }
    .page-break{
      width: auto;
      margin: 0 auto;
    }
     .sale-head{
       margin: 40px 0;
       text-align: center;
     }.sale-head h1,.sale-head strong{
       padding: 10px 20px;
       display: block;
     }.sale-head h1{
       margin: 0;
       border-bottom: 1px solid #212121;
     }.table>thead:first-child>tr:first-child>th{
       border-top: 1px solid #000;
      }
      table thead tr th {
       text-align: center;
       border: 1px solid #ededed;
     }table tbody tr td{
       vertical-align: middle;
     }.sale-head,table.table thead tr th,table tbody tr td,table tfoot tr td{
       border: 1px solid #212121;
       white-space: nowrap;
     }.sale-head h1,table thead tr th,table tfoot tr td{
       background-color: #f8f8f8;
     }tfoot{
       color:#000;
       text-transform: uppercase;
       font-weight: 500;
     }
   </style>
</head>
<body>
  <?php //if($results): 

  $route_name = find_by_id('routes',$route);
  ?>
    <div class="page-break">
       <div class="sale-head pull-right">
           <h1>Credit Report Of <?php echo $route_name['name'];  ?></h1>
           <strong> </strong>
       </div>
       <?php
        $cnt=0;        
        foreach($results as $result):
          $cnt++;
        endforeach;
        $cred_arr  = array(); //create a new array
        $i=0; //increment inside the for loop
        $credit_35_total=0;
          
        if ($cnt <= 0) {

        }else{
       ?>
      <table class="table table-border">
        <thead>
          <tr>
              <th class="text-left"><font color="red">Over 28 days Credit Report</font></th>
            </tr>
          </thead>
        </table>
      <table class="table table-border">
        <thead>
          <tr>
              <th>Customer Name</th>
              <th>Invoice Number</th>
              <th>Date</th>
              <th>Credit Amount</th>
              <th>Received Credit</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($results as $result): 
          if(($result['credit'] - $result['received_credit']) <=0){
              continue;
          }
          $cred_arr[$i] = $result['name']; //assign elements to array
          $credit_35_total += $result['credit'];
          $i += 1; //increment
          ?> 
           <tr>
              <td class="text-center">
                <font color="red"><?php echo remove_junk(ucfirst($result['name']));?></font>
              </td>
              <td class="text-center"><?php echo remove_junk($result['invoice_number']);?></td>
              <td class="text-center"><?php echo remove_junk($result['date']);?></td>
              <td class="text-right">Rs. <?php echo number_format($result['credit'],2);?></td>
              <td class="text-right">Rs. <?php echo number_format($result['received_credit'],2);?></td>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
          <td></td>
          <td class="text-center"><b>grand total</b></td>
          <td></td>
          <td class="text-right"><font color="red"><b> Rs.<?php echo number_format($credit_35_total, 2);?></b></font></td>
        </tr>
      </tfoot>
      </table>
      <?php   }    ?>
      <?php
      //this is to check whether table should display or not
      $count=0;
      foreach($results_p as $result): 
      if(($result['credit'] - $result['received_credit']) <=0){
              continue;
      }
        //print_r($results);
        if (in_array($result['name'], $cred_arr)){ //check
          continue;
        }
        $count++;
      endforeach;
      if ($count <= 0){

      }else{
      ?>
      <table class="table table-border">
        <thead>
          <tr>
              <th class="text-left"><font color="blue"> Credit Report</font></th>
            </tr>
          </thead>
        </table>
      <table class="table table-border">
        <thead>
          <tr>
              <th>Customer Name</th>
              <th>Invoice Number</th>
              <th>Date</th>
              <th>Credit Amount</th>
              <th>Received Credit</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $credit_total = 0;
          foreach($results_p as $result): 
          //print_r($results);
          if (in_array($result['name'], $cred_arr)){ //check
            continue;
          }
          $credit_total += $result['credit'];
          ?>
           <tr>
              <td class="text-center">
                <font color="red"><?php echo remove_junk(ucfirst($result['name']));?></font>
              </td>
              <td class="text-center"><?php echo remove_junk($result['invoice_number']);?></td>
              <td class="text-center"><?php echo remove_junk($result['date']);?></td>
              <td class="text-right">Rs. <?php echo number_format($result['credit'],2);?></td>
              <td class="text-right">Rs. <?php echo number_format($result['received_credit'],2);?></td>
        <?php endforeach; ?>
        </tbody>
      <tfoot>
        <tr>
          <td></td>
          <td class="text-center"><b>grand total</b></td>
          <td></td>
          <td class="text-right"><font color="black"><b> Rs.<?php echo number_format($credit_total, 2);?></b></font></td>
        </tr>
      </tfoot>
      </table>
      <?php }  ?>
    </div>
  <?php
   /* else:
        $session->msg("d", "Sorry no records has been found. ");
        redirect('credit_day35_report.php', false);
     endif;*/
  ?>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
