<?php
  require_once('includes/load.php');

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table)." ORDER BY id DESC");
   }
}
function find_all_cst($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table)." WHERE active_customer='1'");
   }
}
function find_all_prd($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table)." WHERE active_product='1'");
   }
}
function find_all_date($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table). " GROUP BY date ORDER BY date DESC");
   }
}
/*--------------------------------------------------------------*/
/* Function for Perform queries
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
 return $result_set;
}
/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
function find_by_cust_id($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE customer_id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
function find_by_product_id($table,$id)
{
  global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table). " WHERE product_id=".$db->escape($id));
   }
}

function find_stock_using_date($table,$id)
{
  global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table). " WHERE date =\"".$id."\"");
   }
}

function find_stock_using_id($table,$id)
{
  global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table). " WHERE id =".$id);
   }
}
function find_stock_load_using_date($table,$id,$id1)
{
  global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table). " WHERE route_id =".$id1." date =\"".$id."\"");
   }
}
function find_by_using_invoice_date($table,$id,$id1)
{
  global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table). " WHERE invoice_number =".$id1." && date =\"".$id."\"");
   }
}
function find_by_using_invoice($table,$id)
{
  global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table). " WHERE invoice_number =".$id);
   }
}

function join_custdetail_by_id($id){
     global $db;
     $sql  =" SELECT c.id,c.invoice_number,SUM(x.received_cheque) AS received_cheque,SUM(x.received_credit) AS received_credit, c.date,c.cash,c.discount,c.credit,c.cheque,l.address,l.name AS cust_name";
    $sql  .=" FROM customer_bill_receive c";
    $sql  .=" LEFT JOIN customer l ON l.id = c.customer_id";
    $sql  .=" LEFT JOIN credit_recover x ON x.invoice_number = c.invoice_number";
    $sql .= " WHERE c.customer_id ='{$id}'";
    $sql  .=" GROUP BY c.invoice_number";
    $sql  .=" ORDER BY c.id DESC";
    return find_by_sql($sql);

   }

function join_credit_invoice($id){
 global $db;
 $sql  =" SELECT c.credit, c.date, l.name, SUM(x.received_credit+x.received_cheque) AS paid,r.name AS r_name";
$sql  .=" FROM customer_bill_receive c";
$sql  .=" LEFT JOIN customer l ON l.id = c.customer_id";
$sql  .=" LEFT JOIN routes r ON r.id = l.route_id";
$sql  .=" LEFT JOIN credit_recover x ON x.invoice_number = c.invoice_number";
$sql .= " WHERE c.invoice_number ='{$id}'";
return find_by_sql($sql);

}
function find_by_route_id($table,$id)
{
  global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table). " WHERE route_id=".$db->escape($id));
   }
}
function find_by_route_id_cst($table,$id)
{
  global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table). " WHERE route_id=".$db->escape($id)." AND active_customer='1'");
   }
}
function find_by_name($table,$id)
{
  global $db;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE name='{$id}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_invoice($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE invoice_number='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
/*--------------------------------------------------------------*/
/* Function for Delete data from table by id
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $db;
  if(tableExists($table))
   {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
}
/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/

function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
     return($db->fetch_assoc($result));
  }
}
/*--------------------------------------------------------------*/
/* Determine if database table exists
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
      if($table_exit) {
        if($db->num_rows($table_exit) > 0)
              return true;
         else
              return false;
      }
  }
function prompt($prompt_msg){
    echo("<script type='text/javascript'> var answer = prompt('".$prompt_msg."'); </script>");

    $answer = "<script type='text/javascript'> document.write(answer); </script>";
    return($answer);
}
 /*--------------------------------------------------------------*/
 /* Login with the data provided in $_POST,
 /* coming from the login form.
/*--------------------------------------------------------------*/
  function authenticate($username='', $password='') {
    global $db;
    $username = $db->escape($username);
    $password = $db->escape($password);
    $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
    $result = $db->query($sql);
    if($db->num_rows($result)){
      $user = $db->fetch_assoc($result);
      $password_request = sha1($password);
      if($password_request === $user['password'] ){
        return $user['id'];
      }
    }
   return false;
  }
  /*--------------------------------------------------------------*/
  /* Login with the data provided in $_POST,
  /* coming from the login_v2.php form.
  /* If you used this method then remove authenticate function.
 /*--------------------------------------------------------------*/
   function authenticate_v2($username='', $password='') {
     global $db;
     $username = $db->escape($username);
     $password = $db->escape($password);
     $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
     $result = $db->query($sql);
     if($db->num_rows($result)){
       $user = $db->fetch_assoc($result);
       $password_request = sha1($password);
       if($password_request === $user['password'] ){
         return $user;
       }
     }
    return false;
   }


  /*--------------------------------------------------------------*/
  /* Find current log in user by session id
  /*--------------------------------------------------------------*/
  function current_user(){
      static $current_user;
      global $db;
      if(!$current_user){
         if(isset($_SESSION['user_id'])):
             $user_id = intval($_SESSION['user_id']);
             $current_user = find_by_id('users',$user_id);
        endif;
      }
    return $current_user;
  }
  /*--------------------------------------------------------------*/
  /* Find all user by
  /* Joining users table and user gropus table
  /*--------------------------------------------------------------*/
  function find_all_user(){
      global $db;
      $results = array();
      $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
      $sql .="g.group_name ";
      $sql .="FROM users u ";
      $sql .="LEFT JOIN user_groups g ";
      $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
      $result = find_by_sql($sql);
      return $result;
  }
  /*--------------------------------------------------------------*/
  /* Function to update the last log in of a user
  /*--------------------------------------------------------------*/

 function updateLastLogIn($user_id)
	{
		global $db;
    $date = make_date();
    $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
	}

  /*--------------------------------------------------------------*/
  /* Find all Group name
  /*--------------------------------------------------------------*/
  function find_by_groupName($val)
  {
    global $db;
    $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Find group level
  /*--------------------------------------------------------------*/
  function find_by_groupLevel($level)
  {
    global $db;
    $sql = "SELECT group_level FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Function for cheaking which user level has access to page
  /*--------------------------------------------------------------*/
   function page_require_level($require_level){
     global $session;
     $current_user = current_user();
     $login_level = find_by_groupLevel($current_user['user_level']);
     //if user not login
     if (!$session->isUserLoggedIn(true)):
            $session->msg('d','Please login...');
            redirect('index.php', false);
      //if Group status Deactive
     elseif($login_level['group_status'] === '0'):
           $session->msg('d','This level user has been banned!');
           redirect('home.php',false);
      //cheackin log in User level and Require level is Less than or equal to
     elseif($current_user['user_level'] <= (int)$require_level):
              return true;
      else:
            $session->msg("d", "Sorry! you dont have permission to view the page.");
            redirect('home.php', false);
        endif;

     }
   /*--------------------------------------------------------------*/
   /* Function for Finding all product name
   /* JOIN with categorie  and media database table
   /*--------------------------------------------------------------*/
  function join_product_table(){
     global $db;
     $sql  =" SELECT p.id,p.active_product,p.name,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
    $sql  .=" AS categorie,m.file_name AS image";
    $sql  .=" FROM products p";
    $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
    $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
    $sql  .=" ORDER BY p.id ASC";
    return find_by_sql($sql);

   }
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/
function join_stock_product_table($id){
  global $db;
  $sql  = "SELECT s.product_id,SUM(s.quantity+s.free_quantity) AS quantity,s.invoice_number";
    $sql  .=" FROM stock s";
    $sql  .=" WHERE s.product_id = '{$id}'";
    $sql  .=" GROUP BY s.product_id";
    $sql  .=" ORDER BY s.id ASC";
  return find_by_sql($sql);
}

   /*--------------------------------------------------------------*/
   /* Function for Finding all product name
   /* JOIN with categorie  and media database table
   /*--------------------------------------------------------------*/
  function join_stock_table(){
     global $db;
     $sql  =" SELECT p.id,p.invoice_number,p.product_id,p.quantity,p.free_quantity,c.date,m.name";
    $sql  .=" FROM stock p";
    $sql  .=" LEFT JOIN stock_receive c ON c.invoice_number = p.invoice_number";
    $sql  .=" LEFT JOIN products m ON m.id = p.product_id";
    $sql  .=" ORDER BY p.id ASC";
    return find_by_sql($sql);

   }
   /*--------------------------------------------------------------*/
   /* Function for Finding all product name
   /* JOIN with categorie  and media database table
   /*--------------------------------------------------------------*/
  function join_customer_bill_table(){
     global $db;
     $sql  =" SELECT p.id,p.invoice_number,p.product_id,p.quantity,p.received_return,c.discount,p.free_quantity,c.date,m.name,c.cash,c.credit,c.cheque,l.name AS cust_name";
    $sql  .=" FROM customer_bill p";
    $sql  .=" LEFT JOIN customer_bill_receive c ON c.invoice_number = p.invoice_number";
    $sql  .=" LEFT JOIN products m ON m.id = p.product_id";
    $sql  .=" LEFT JOIN customer l ON l.id = c.customer_id";
    $sql  .=" ORDER BY p.id DESC";
    return find_by_sql($sql);
   }
   function join_customer_by_id($id){
     global $db;
     $sql  =" SELECT p.id,p.invoice_number,p.product_id,p.quantity,p.reissued,p.discount_quantity,p.received_return,c.discount,p.free_quantity,c.date,m.name,c.cash,c.credit,c.cheque,m.sale_price,l.name AS cust_name";
    $sql  .=" FROM customer_bill p";
    $sql  .=" LEFT JOIN customer_bill_receive c ON p.invoice_number = c.invoice_number";
    $sql  .=" LEFT JOIN products m ON m.id = p.product_id";
    $sql  .=" LEFT JOIN customer l ON l.id = c.customer_id";
    $sql .= " WHERE p.invoice_number ='{$id}'";
    $sql  .=" ORDER BY p.id DESC";
    return find_by_sql($sql);
   }
  function join_by_product_join($start_date,$end_date,$table){
     global $db;
      $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
     $sql  =" SELECT p.id,p.invoice_number,p.product_id,p.quantity,SUM(p.discount_quantity) AS discount_quantity,p.received_return,c.discount,SUM(p.free_quantity) AS free_quantity,c.date,m.name,SUM(p.discount_quantity*m.sale_price) AS discount_qt";
    $sql  .=" FROM {$table} p";
    $sql  .=" LEFT JOIN {$table}_receive c ON p.invoice_number = c.invoice_number";
    $sql  .=" LEFT JOIN products m ON m.id = p.product_id";
    $sql .= " WHERE c.date BETWEEN '{$start_date}' AND '{$end_date}'";
    $sql  .=" GROUP BY p.product_id DESC";
    $sql  .=" ORDER BY p.product_id DESC";
    return find_by_sql($sql);
   }
  function join_by_product_join_v1($start_date,$end_date,$table){
     global $db;
      $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
     $sql  =" SELECT p.id,p.invoice_number,p.product_id,p.quantity,c.discount,SUM(p.free_quantity) AS free_quantity,c.date,m.name";
    $sql  .=" FROM {$table} p";
    $sql  .=" LEFT JOIN {$table}_receive c ON p.invoice_number = c.invoice_number";
    $sql  .=" LEFT JOIN products m ON m.id = p.product_id";
    $sql .= " WHERE c.date BETWEEN '{$start_date}' AND '{$end_date}'";
    $sql  .=" GROUP BY p.product_id DESC";
    $sql  .=" ORDER BY p.product_id DESC";
    return find_by_sql($sql);
   }

   function join_unload_by_date($id){
     global $db;
     $id  = date("Y-m-d", strtotime($id));
     $sql  =" SELECT p.date,p.id,p.product_id,p.quantity,p.received_return,m.name";
    $sql  .=" FROM stock_unload p";
    $sql  .=" LEFT JOIN products m ON m.id = p.product_id";
    $sql .= " WHERE p.date ='{$id}'";
    $sql  .=" GROUP BY p.product_id ASC";
    return find_by_sql($sql);
   }

//loading details according to the date and route information   
   function join_load_by_date($id){
     global $db;
     $id  = date("Y-m-d", strtotime($id));
     $sql  =" SELECT p.date,p.id,p.product_id,SUM(p.quantity) AS quantity,m.name";
    $sql  .=" FROM stock_load p";
    $sql  .=" LEFT JOIN products m ON m.id = p.product_id";
    $sql .= " WHERE p.date ='{$id}'";
    $sql  .=" GROUP BY p.product_id ASC";
    return find_by_sql($sql);
   }

//unloading details according to the date and route information
   function join_unload_by_date_v1($id){
     global $db;
     $id  = date("Y-m-d", strtotime($id));
     $sql  =" SELECT p.date,p.id,p.product_id,SUM(p.quantity) AS quantity,SUM(p.received_return) AS received_return,m.name";
    $sql  .=" FROM stock_unload p";
    $sql  .=" LEFT JOIN products m ON m.id = p.product_id";
    $sql .= " WHERE p.date ='{$id}'";
    $sql .= " GROUP BY p.product_id";
    return find_by_sql($sql);
   }
//customer bill details according to the date and route information
   function join_custload_by_date_p($id){
     global $db;
     $id  = date("Y-m-d", strtotime($id));
     $sql  =" SELECT t.date,p.id,p.product_id,SUM(p.quantity) AS quantity,SUM(p.free_quantity) AS free_quantity,SUM(p.discount_quantity) AS discount_quantity,SUM(p.received_return) AS received_return,SUM(p.reissued) AS reissued,m.name";
    $sql  .=" FROM customer_bill_receive t";
    $sql  .=" LEFT JOIN customer_bill p ON p.invoice_number = t.invoice_number";
    $sql  .=" LEFT JOIN customer l ON l.id = t.customer_id";
    $sql  .=" LEFT JOIN products m ON m.id = p.product_id";
    $sql .= " WHERE t.date ='{$id}'";
    $sql .= " GROUP BY p.product_id";
    return find_by_sql($sql);
   }

   function join_stock_by_id($id){
     global $db;
     $sql  =" SELECT p.invoice_number,p.id,p.product_id,p.quantity,l.discount,p.free_quantity,m.name,l.date";
    $sql  .=" FROM stock p";
    $sql  .=" LEFT JOIN products m ON m.id = p.product_id";
    $sql  .=" LEFT JOIN stock_receive l ON l.invoice_number = p.invoice_number";
    $sql .= " WHERE p.invoice_number ='{$id}'";
    $sql  .=" ORDER BY p.id ASC";
    return find_by_sql($sql);
   }
    function join_return_by_id($id){
    global $db;
    $sql  =" SELECT p.invoice_number,p.id,p.product_id,p.quantity,m.name";
    $sql  .=" FROM company_return_receive p";
    $sql  .=" LEFT JOIN products m ON m.id = p.product_id";
    $sql .= " WHERE p.invoice_number ='{$id}'";
    $sql  .=" ORDER BY p.invoice_number ASC";
    return find_by_sql($sql);

   }
    /*--------------------------------------------------------------*/
   /* Function for Finding all product name
   /* JOIN with categorie  and media database table
   /*--------------------------------------------------------------*/
  function join_customer_bill_v1_table(){
     global $db;
     $sql  =" SELECT c.id,r.name AS route_name,c.invoice_number,c.date,c.cash,c.discount,c.return_sale,c.credit,c.cheque,l.name AS cust_name";
    $sql  .=" FROM customer_bill_receive c";
    $sql  .=" LEFT JOIN customer_bill p ON p.invoice_number = c.invoice_number";
    $sql  .=" LEFT JOIN products m ON m.id = p.product_id";
    $sql  .=" LEFT JOIN customer l ON l.id = c.customer_id";
    $sql  .=" LEFT JOIN routes r ON r.id = l.route_id";
    $sql .= " GROUP BY route_name,c.invoice_number";
    $sql  .=" ORDER BY route_name ASC";
    return find_by_sql($sql);

   }
 function find_stock_in_hand(){
   global $db;
   $sql   = " SELECT p.id,p.invoice_number,p.product_id,SUM(p.quantity) AS quantity,SUM(c.discount) AS discount,SUM(p.free_quantity) AS free_quantity,c.date,m.name, SUM(p.quantity+p.free_quantity) AS total_quantity";
   $sql  .= " FROM stock p";
   $sql  .= " LEFT JOIN stock_receive c ON c.invoice_number = p.invoice_number";
   $sql  .=" LEFT JOIN products m ON m.id = p.product_id";
   $sql  .= " WHERE m.active_product='1'";
   $sql  .= " GROUP BY p.product_id";
   $sql  .= " ORDER BY p.id DESC";
   return find_by_sql($sql);
 }
  /*--------------------------------------------------------------*/
  /* Function for Finding all product name
  /* Request coming from ajax.php for auto suggest
  /*--------------------------------------------------------------*/

   function find_product_by_title($product_name){
     global $db;
     $p_name = remove_junk($db->escape($product_name));
     $sql = "SELECT name FROM products WHERE name like '%$p_name%' LIMIT 5";
     $result = find_by_sql($sql);
     return $result;
   }
   function find_customer_by_title($product_name){
     global $db;
     $p_name = remove_junk($db->escape($product_name));
     $sql = "SELECT name FROM customer WHERE name like '%$p_name%' LIMIT 10";
     $result = find_by_sql($sql);
     return $result;
   }


  /*--------------------------------------------------------------*/
  /* Function for Finding all product info by product title
  /* Request coming from ajax.php
  /*--------------------------------------------------------------*/
  function find_all_product_info_by_title($title){
    global $db;
    $sql  = "SELECT * FROM products ";
    $sql .= " WHERE name ='{$title}'";
    $sql .=" LIMIT 1";
    return find_by_sql($sql);
  }

  /*--------------------------------------------------------------*/
  /* Function for Update product quantity
  /*--------------------------------------------------------------*/
  function update_product_qty($qty,$p_id){
    global $db;
    $qty = (int) $qty;
    $id  = (int)$p_id;
    $sql = "UPDATE products SET quantity=quantity -'{$qty}' WHERE id = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }
 /* Function for Display Recent sale
 /*--------------------------------------------------------------*/
function find_credit_over_35(){
  global $db;
  $sql  = "SELECT c.id,c.invoice_number,c.customer_id,c.date,c.credit,SUM(x.received_credit+x.received_cheque) AS received_credit,p.name,r.name AS name_r";
  $sql .= " FROM customer_bill_receive c";
  $sql .= " LEFT JOIN credit_recover x ON x.invoice_number = c.invoice_number";
  $sql .= " LEFT JOIN customer p ON p.id = c.customer_id";
  $sql .= " LEFT JOIN routes r ON r.id = p.route_id";
  $sql .= " WHERE DATE_SUB(CURDATE(),INTERVAL 28 DAY) > c.date AND c.credit != 0";
  $sql .= " GROUP BY c.invoice_number";
  $sql .= " ORDER BY p.name ASC";
  return find_by_sql($sql);
}
function find_credit_over_35_q($route){
  global $db;
  $sql  = "SELECT c.id,c.invoice_number,c.customer_id,c.date,c.credit,SUM(x.received_credit+x.received_cheque) AS received_credit,p.name,r.name AS name_r";
  $sql .= " FROM customer_bill_receive c";
  $sql .= " LEFT JOIN credit_recover x ON x.invoice_number = c.invoice_number";
  $sql .= " LEFT JOIN customer p ON p.id = c.customer_id";
  $sql .= " LEFT JOIN routes r ON r.id = p.route_id";
  $sql .= " WHERE p.route_id='{$route}' AND c.credit != 0";
  $sql .= " GROUP BY c.invoice_number";
  $sql .= " ORDER BY p.name ASC";
  return find_by_sql($sql);
}
function find_credit_over_35_p($route){
  global $db;
  $sql  = "SELECT c.id,c.invoice_number,c.customer_id,c.date,c.credit,SUM(x.received_credit+x.received_cheque) AS received_credit,p.name,r.name AS name_r";
  $sql .= " FROM customer_bill_receive c";
  $sql .= " LEFT JOIN credit_recover x ON x.invoice_number = c.invoice_number";
  $sql .= " LEFT JOIN customer p ON p.id = c.customer_id";
  $sql .= " LEFT JOIN routes r ON r.id = p.route_id";
  $sql .= " WHERE DATE_SUB(CURDATE(),INTERVAL 28 DAY) > c.date AND c.credit != 0 AND p.route_id='{$route}'";
  $sql .= " GROUP BY c.invoice_number";
  $sql .= " ORDER BY p.name ASC";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/
function find_route_by_date($start_date,$route_id){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $sql  = "SELECT p.invoice_number, c.id,p.cash,p.discount,p.credit,p.cheque,c.name,p.date,r.name AS route_name ";
  $sql .= "FROM customer_bill_receive p ";
  $sql .= "LEFT JOIN customer c ON c.id = p.customer_id";
  $sql .= " LEFT JOIN routes r ON r.id = c.route_id";
  $sql .= " WHERE p.date = '{$start_date}' AND r.id = '{$route_id}'";
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/
function find_loading_unloading_by_date($start_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $sql  = "SELECT p.route_id,p.date,r.name ";   
  $sql .= "FROM stock_load_receive p";
  $sql .= " LEFT JOIN routes r ON r.id = p.route_id";
  $sql .= " WHERE p.date = '{$start_date}'";
  $sql .= " GROUP BY p.date";
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/
function find_stock_by_dates($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date,p.product_id,p.quantity,p.invoice_number,s.discount ";
  $sql .= "FROM stock_receive s ";
  $sql .= "LEFT JOIN stock p ON p.invoice_number = s.invoice_number";
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY p.invoice_number";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return $db->query($sql);
}
function find_discount_got_by_dates($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date,p.product_id,p.quantity,p.invoice_number,s.discount ";
  $sql .= "FROM stock_receive s ";
  $sql .= "LEFT JOIN stock p ON p.invoice_number = s.invoice_number";
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY s.discount";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return $db->query($sql);
}
function find_discount_give_by_dates($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date,p.product_id,p.quantity,p.invoice_number,s.discount ";
  $sql .= "FROM customer_bill_receive s ";
  $sql .= "LEFT JOIN customer_bill p ON p.invoice_number = s.invoice_number";
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY s.discount";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/
function find_cash_by_dates($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT b.cash,b.customer_id,b.date,b.credit,b.cheque,c.name,r.name AS route_name,SUM(b.cash) AS cash,SUM(b.discount) AS discount,b.date,SUM(b.credit) AS credit,SUM(b.cheque) AS cheque,SUM(b.return_sale) AS return_sale ";
  $sql .= "FROM customer_bill_receive b ";
  $sql .= "LEFT JOIN customer c ON c.id = b.customer_id";
  $sql .= " LEFT JOIN routes r ON r.id = c.route_id";
  $sql .= " WHERE b.date BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY c.name";
  $sql .= " ORDER BY DATE(b.date) DESC";
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/
function find_product_sale_by_dates($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT b.invoice_number,c.date,p.sale_price,p.name AS product_name,SUM(b.quantity) AS quantity,SUM(b.free_quantity) AS free_quantity,SUM(b.discount_quantity) AS discount_quantity,SUM(b.reissued) AS reissued,SUM(b.received_return) AS received_return ";
  $sql .= "FROM customer_bill b ";
  $sql .= "LEFT JOIN customer_bill_receive c ON c.invoice_number = b.invoice_number";
  $sql .= " LEFT JOIN products p ON p.id = b.product_id";
  $sql .= " WHERE c.date BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY b.product_id";
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/
function find_credit_by_dates($start_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $sql  = "SELECT b.cash,b.customer_id,b.date,b.credit,SUM(x.received_credit) AS received_credit,SUM(x.received_cheque) AS received_cheque,b.cheque,c.name,r.name AS route_name,SUM(b.cash) AS cash,SUM(b.discount) AS discount,b.date,SUM(b.cheque) AS cheque ";
  $sql .= "FROM customer_bill_receive b ";
  $sql .= "LEFT JOIN customer c ON c.id = b.customer_id";
  $sql .= " LEFT JOIN credit_recover x ON x.invoice_number = b.invoice_number";
  $sql .= " LEFT JOIN routes r ON r.id = c.route_id";
  $sql .= " WHERE b.date <= '{$start_date}' AND b.credit != 0";
  $sql .= " GROUP BY b.invoice_number";
  $sql .= " ORDER BY c.name DESC";
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/
function find_credit_by_dates_route($start_date,$route){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $sql  = "SELECT b.cash,b.customer_id,b.date,b.credit,SUM(x.received_credit) AS received_credit,SUM(x.received_cheque) AS received_cheque,b.cheque,c.name,r.name AS route_name,SUM(b.cash) AS cash,SUM(b.discount) AS discount,b.date,SUM(b.cheque) AS cheque ";
  $sql .= "FROM customer_bill_receive b ";
  $sql .= "LEFT JOIN customer c ON c.id = b.customer_id";
  $sql .= " LEFT JOIN credit_recover x ON x.invoice_number = b.invoice_number";
  $sql .= " LEFT JOIN routes r ON r.id = c.route_id";
  $sql .= " WHERE b.date <= '{$start_date}' AND c.route_id = '{$route}' AND b.credit != 0";
  $sql .= " GROUP BY b.invoice_number";
  $sql .= " ORDER BY DATE(b.date) DESC";
  return $db->query($sql);
}
?>
