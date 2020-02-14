<?php
  $page_title = 'Add Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all_prd('products');
  $all_customer = find_all_cst('customer');
  $all_routes = find_all('routes');
  $all_photo = find_all('media'); 
  
if(isset($_POST['save']))  
{
$customer_id = $_POST['customer_id'];  
$name=$_POST['invoice_number'];  
$location=$_POST['date'];
$cash=$_POST['cash'];
$return_sale = $_POST['return_sale'];
$discount = $_POST['discount'];
$credit=$_POST['credit'];
$cheque=$_POST['cheque'];

$query = "insert into customer_bill_receive(invoice_number,date,cash,return_sale,discount,credit,cheque,customer_id) VALUES ('$name','$location','$cash','$return_sale','$discount','$credit','$cheque','$customer_id')"; 
$db->query($query); 
$id=$_POST['invoice_number']; 
foreach ($_POST['productid'] as $i => $value) {
    if ($_POST['productid'][$i] == ''){}
    else{
        $query_r = "INSERT INTO customer_bill SET invoice_number = '{$id}',product_id = '{$_POST['productid'][$i]}',quantity = '{$_POST['quantity'][$i]}',free_quantity = '{$_POST['free_quantity'][$i]}',discount_quantity = '{$_POST['discount_quantity'][$i]}',received_return = '{$_POST['received_return'][$i]}',reissued = '{$_POST['reissued'][$i]}'";
        $db->query($query_r); 
    }
    }
}
?>
<?php include_once('layouts/header.php'); ?> 
<form action="" method="POST">
<div class="panel">
<div class="panel panel-default">
    <div class="panel-heading clearfix">
    <div class="row">
        <div class="col-sm-4"> 
        <span class="glyphicon glyphicon-th"></span> 
        <b>Customer Bill</b>
        </div>
        <div class="col-sm-4"> 
        <select id="catList" class="btn btn-default" name="route_id">
        <option value="">Select Route</option>
        <?php  foreach ($all_routes as $cat): ?>
        <option value="<?php echo (int)$cat['id'] ?>">
        <?php 
        $catid = isset($_GET['route']) ? $_GET['route'] : 0;
        $selected = ($catid == $cat['id']) ? " selected" : "";
        echo "<option$selected value=".$cat['id'].">".$cat['name']."</option>";
        ?>
        </option>
        <?php endforeach; ?>
        </select> 
    </div>

<div class="col-sm-4">
    <div class="pull-right">
            <input type="submit" class="btn btn-primary" name="save" value="Save Record"> 
        </div></div>
</div></div>
<div class="panel clearfix"> 
<table id="myTable" class="table table-bordered">  
    <thead>  
        <th>Product ID</th>  
        <th>Quantity</th>  
        <th>Free Quantity</th>
        <th>Discount Quantity</th>
        <th>Received Return</th>
        <th>Reissued</th>
        <th><input type="button" class="btn btn-success" id="addrow" value="Add Row" /></th>
    </thead>  
    <tbody class="detail">  
        <tr>
            <td><select class="form-control" name="productid[]">
  <option value="">Select Product Name</option>
<?php  foreach ($all_categories as $cat): ?>
  <option value="<?php echo (int)$cat['id'] ?>">
    <?php echo $cat['name'] ?></option>
<?php endforeach; ?>
</select></td>  
            <td><input type="text" class="form-control quantity" name="quantity[]"  value="0"></td>  
            <td><input type="text" class="form-control amount" name="free_quantity[]" value="0"></td>
            <td><input type="text" class="form-control amount" name="discount_quantity[]" value="0"></td> 
            <td><input type="text" class="form-control amount" name="received_return[]" value="0"></td> 
            <td><input type="text" class="form-control amount" name="reissued[]" value="0"></td> 
            <td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>  
        </tr>  
    </tbody> 
<tfoot>  
<th style="text-align:center;">Total</th>  
<th style="text-align:right;" class="total" id="grand_t">0<b></b></th>  
<th style="text-align:center;">Discount</th>  
<th style="text-align:right;" class="total" id="disc_t">0<b></b></th>  
<th></th>  
<th></th>
</tfoot>  
</table></div></div></div>
<div class="panel">
    <div class="panel panel-default">
        <div class="panel clearfix">
                    <div class="form-group">  
                        <b>Bill Number  
                        <input type="number" name="invoice_number" class="form-control" value="0">  
                    </div> 

<?php
if(isset($_GET['route'])){
$route_id=$_GET['route'];
$all_customer = find_by_route_id_cst('customer',$route_id);
//echo print_r($all_customer);
?>

<div class="form-group">  
Customer Name  
<select class="form-control" name="customer_id">
  <option value="">Select Customer Name</option>
<?php  foreach ($all_customer as $cust): ?>
  <option value="<?php echo (int)$cust['id'] ?>">
    <?php echo $cust['name'] ?></option>
<?php endforeach; ?>
   </select> 
</div>  
<?php }else{

$all_customer = find_all_cst('customer');
?>
                             
<div class="form-group">  
    Customer Name  
    <select class="form-control" name="customer_id">
      <option value="">Select Customer Name</option>
    <?php  foreach ($all_customer as $cust): ?>
      <option value="<?php echo (int)$cust['id'] ?>">
        <?php echo $cust['name'] ?></option>
    <?php endforeach; ?>
    </select> 
</div>  
<?php } ?>
<div class="form-group">
  <label class="form-label">Date</label>
    <div class="input-group">
      <input type="text" class="datepicker form-control" name="date" placeholder="date">
      <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
    </div>
</div>
<div class="form-group">  
    Cash Amount
    <div class="input-group">
    <span class="input-group-addon">&#8360;</span> 
    <input type="decimal" name="cash" class="form-control" value="0">  
</div></div> 
<div class="form-group">  
    <font color="blue"><b> Return sale </b></font>
    <div class="input-group">
    <span class="input-group-addon">&#8360;</span>
    <input type="decimal" name="return_sale" class="form-control" value="0">  
</div></div> 
<div class="form-group">  
    <font color="red"><b> Discount </b></font>
    <div class="input-group">
    <span class="input-group-addon">&#8360;</span>
    <input type="decimal" name="discount" class="form-control" value="0">  
</div></div>  
<div class="form-group">  
    Credit  
    <div class="input-group">
    <span class="input-group-addon">&#8360;</span>
    <input type="decimal" name="credit" class="form-control" value="0">  
</div></div>  

<div class="form-group">  
    Cheque 
    <div class="input-group">
    <span class="input-group-addon">&#8360;</span>
    <input type="decimal" name="cheque" class="form-control" value="0">  
</div></div>  
</b>
</form></div></div></div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#catList").on('change', function(){
            if($(this).val() == 0)
            {
                window.location = 'customer_bill_add.php';
            }
            else
            {
                window.location = 'customer_bill_add.php?route='+$(this).val();
            }
        });
    });
</script>               
<script type="text/javascript">
    $(document).ready(function () {
    var counter = 0;
    var sum = 1;
    var sum_sale = 0;
    var sum_disc = 0;
    var price = [];
    var quant_arr = [];
    var disc_arr = [];
    $("#addrow").on("click", function () {
        var id_send = document.getElementById("myTable").rows[sum].cells[0].childNodes[0].value;
        var quant_s = document.getElementById("myTable").rows[sum].cells[1].childNodes[0].value;
        var disc_s = document.getElementById("myTable").rows[sum].cells[3].childNodes[0].value;
        //alert(id_send);
        //alert(quant_arr[counter]);
        if (quant_s==null) quant_s=0;
        if (disc_s==null) disc_s=0;
        $.ajax({    //create an ajax request to script_emergency.php
                type: "GET",
                data: {id : id_send},
                url: "customer_bill_add_script.php",             
                dataType: "html",   //expect html to be returned                
                success: function(value){ 
                  var data = value.split(",");  
                  //alert(data[2]);
                  price[counter] = Number(data[2]); 
                  quant_arr[counter] = quant_s;
                  disc_arr[counter] = disc_s;
                  //alert(disc_arr[counter]);
                  sum_disc += price[counter]*disc_arr[counter];
                  sum_sale += price[counter]*quant_arr[counter]; 
                  $("#grand_t").text(sum_sale.toFixed(2)); 
                  $("#disc_t").text(sum_disc.toFixed(2));             
                }
        });
        sum = sum + 1;
        var newRow = $("<tr>");
        var cols = "";
        cols += '<td><select class="form-control" name="productid[]"><option value="">Select the Product</option><?php  foreach ($all_categories as $cat): ?><option value="<?php echo (int)$cat['id'] ?>"><?php echo $cat['name'] ?></option><?php endforeach; ?></select></td>';
        cols += '<td><input type="text" name="quantity[]" value="0"  class="form-control"/></td>';
        cols += '<td><input type="text" name="free_quantity[]" class="form-control" value="0" /></td>';
        cols += '<td><input type="text" class="form-control amount" name="discount_quantity[]" value="0"></td>';
        cols += '<td><input type="text" class="form-control amount" name="received_return[]" value="0"></td>';
        cols += '<td><input type="text" class="form-control amount" name="reissued[]" value="0"></td>';

        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        newRow.append(cols);
        $("table.table-bordered").append(newRow);
        counter++;
    });
    $("table.table-bordered").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();       
        sum -= 1;
        sum_sale -= price[counter]*quant_arr[counter];
        sum_disc -= price[counter]*disc_arr[counter];
        counter -= 1;
        $("#disc_t").text(sum_disc.toFixed(2));
        $("#grand_t").text(sum_sale.toFixed(2))
    });
});
</script>
<?php include_once('layouts/footer.php'); ?>
