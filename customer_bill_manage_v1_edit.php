<?php
  $page_title = 'All Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $products = join_product_table();
  $customer_bill = join_customer_bill_v1_table();
  $all_dates = find_all_date('customer_bill_receive');
?>
<?php include_once('layouts/header.php'); ?>
<script type="text/javascript" src="libs/bootstrap/js/sweetalert.min.js"></script>
<script type="text/javascript">
function findIt(){
  var customer_name = document.getElementById('sug_input').value;
  $.ajax({//create an ajax request to customer_find.php
        type: "GET",
        data: {cus_name : customer_name},
        url: "customer_find.php",             
        dataType: "html",   //expect html to be returned                
        success: function(value){ 
          var data = value.split(",");  
          x = Number(data[0]);
          y = Number(data[1]);
          swal("Found It!", "Customer Name is "+customer_name, "success");   
          $('#cust_n').val(x);   
          $('#route_n').val(y);        
        }
});
  
}

</script>
<script type="text/javascript">
    function changeText2($id){
    var cust_n = document.getElementById('cust_n').value;
    var inv_n = document.getElementById('inv_n').value;
    var date_n = document.getElementById('date_n').value;
    var cash_n = document.getElementById('cash_n').value;
    var ret_sale = document.getElementById('ret_sale').value;
    var disc_n = document.getElementById('disc_n').value;
    var cred_n = document.getElementById('cred_n').value;
    var cheq_n = document.getElementById('cheq_n').value;
    window.location = "customer_bill_manage_v1.php?id_from="+$id+"&cust_n="+cust_n+"&inv_n="+inv_n+"&date_n="+date_n+"&cash_n="+cash_n+"&ret_sale="+ret_sale+"&disc_n="+disc_n+"&cred_n="+cred_n+"&cheq_n="+cheq_n+"&ok=1";
  }
</script> 
<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <div class="input-group">
      <span class="input-group-btn">
        <button id="findIt" onclick="findIt();" type="submit" class="btn btn-primary">Find It</button>
      </span>
      <input type="text" id="sug_input" class="form-control" name="title"  placeholder="Search for customer name">
   </div>
   <div id="result" class="list-group"></div>
  </div>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
       <?php echo display_msg($msg); ?>
    </div>
    <div class="col-md-12">
      <div class="form-group">
<?php
if(isset($_GET['id'])){
$route_id=$_GET['id'];
$customer_bill = find_stock_using_id('customer_bill_receive',$route_id);
?>

  </div>
 </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <button onclick='changeText2(<?php echo (int)$route_id; ?>)'  class="btn btn-primary">Save</button>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
               <tr>
                <th class="text-center" style="width: 20%;"> Route Id </th>
                <th class="text-center" style="width: 20%;"> Customer Name </th>
                <th class="text-center" style="width: 10%;"> Invoice Number </th>
                <th class="text-center" style="width: 10%;"> Date </th>
                <th class="text-center" style="width: 10%;"> Cash </th>
                <th class="text-center" style="width: 10%;"> Return Sale </th>
                <th class="text-center" style="width: 10%;"> Discount </th>
                <th class="text-center" style="width: 10%;"> Credit </th>
                <th class="text-center" style="width: 10%;"> Cheque </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($customer_bill as $product):

              $customer = find_by_id('customer',$product['customer_id']);
              $route_id = $customer['route_id'];
              $route = find_by_id('routes',$route_id);
              ?>
              <tr>
                <td class="text-center"> 
                  <?php     
                  $all_r = find_all('routes');
                ?>
                  <select id="route_n" class="form-control" name="route_n">
                    <option value="<?php echo remove_junk($route['id']); ?>"><?php echo remove_junk($route['name']); ?></option>
                  <?php  foreach ($all_r as $cat): ?>
                    <option value="<?php echo (int)$cat['id'] ?>">
                      <?php echo $cat['name'] ?></option>
                  <?php endforeach; ?>
                  </select> 
                </td>
                <td class="text-center"> 
                <?php     
                  $all_c = find_all_cst('customer');
                ?>
                <select id="cust_n" class="form-control" name="cust_n">
                  <option value="<?php echo remove_junk($customer['id']); ?>"><?php echo remove_junk($customer['name']); ?></option>
                <?php  foreach ($all_c as $cat): ?>
                  <option value="<?php echo (int)$cat['id'] ?>">
                    <?php echo $cat['name'] ?></option>
                <?php endforeach; ?>
                </select>
                

                <td class="text-center"> 
                
                <input id="inv_n" type="text" class="form-control quantity" name="inv_n" value="<?php echo remove_junk($product['invoice_number']); ?>">
                

                <td class="text-center"> 
                
                <input id="date_n" type="date" class="form-control quantity" name="date_n" value="<?php echo remove_junk($product['date']); ?>">
                

                <td class="text-center"> 
                
                <input id="cash_n" type="decimal" class="form-control quantity" name="cash_n" value="<?php echo remove_junk($product['cash']); ?>">
                

                <td class="text-center"> 
               
                <input id="ret_sale" type="decimal" class="form-control quantity" name="ret_sale" value="<?php echo remove_junk($product['return_sale']); ?>">
                

                <td class="text-center"> 
               
                <input id="disc_n" type="text" class="form-control quantity" name="disc_n" value="<?php echo remove_junk($product['discount']); ?>">
                

                <td class="text-center"> 
               
                <input id="cred_n" type="decimal" class="form-control quantity" name="cred_n" value="<?php echo remove_junk($product['credit']); ?>">
               

                <td class="text-center"> 
                
                <input id="cheq_n" type="decimal" class="form-control quantity" name="cheq_n" value="<?php echo remove_junk($product['cheque']); ?>">
                
              </tr>
             <?php endforeach; ?>
            </tbody>
          </tabel>
        </div>
      </div>
    </div>
  </div>
  <?php
}else{


}
?>  
<?php include_once('layouts/footer.php'); ?>
