<?php
  $page_title = 'Add Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all_prd('products');
  $all_photo = find_all('media');
?>
<?php  
if(isset($_POST['save']))  
{  
$name=$_POST['invoice_number'];  
$location=$_POST['date'];  
$discount = $_POST['discount'];
$query = "insert into stock_receive(invoice_number,date,discount) VALUES ('$name','$location','$discount')"; 
$db->query($query);
$id=$_POST['invoice_number']; 
foreach ($_POST['productid'] as $i => $value) {
    if ($_POST['productid'][$i] == ''){}
    else{
    $query_r = "INSERT INTO stock SET invoice_number = '{$id}',product_id = '{$_POST['productid'][$i]}',quantity = '{$_POST['quantity'][$i]}',free_quantity = '{$_POST['free_quantity'][$i]}'";
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
            <span class="glyphicon glyphicon-th"></span> 
            <b>Company Stock Receive</b> 
            <div class="pull-right">
                <input type="submit" class="btn btn-primary" name="save" value="Save Record">  
            </div>
        </div>
        <div class="panel clearfix"> 
        <table id="myTable" class=" table table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>  
                    <th>Quantity</th> 
                    <th>Free Quantity</th> 
                    <th><input type="button" class="btn btn-success" id="addrow" value="Add Row" /></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select class="form-control" name="productid[]">
                              <option value="">Select the Product</option>
                            <?php  foreach ($all_categories as $cat): ?>
                              <option value="<?php echo (int)$cat['id'] ?>">
                                <?php echo $cat['name'] ?></option>
                            <?php endforeach; ?>
                            </select>
                    </td>
                    <td>
                        <input type="text" name="quantity[]" value="0"  class="form-control"/>
                    </td>
                    <td>
                        <input type="text" name="free_quantity[]" class="form-control" value="0" />
                    </td>
                    <td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>  
                </tr>
            </tbody>
            <tfoot>  
        <th style="text-align:center;">Total</th>  
        <th style="text-align:right;" class="total" id="grand_t">0<b></b></th>   
        <th></th>  
        <th></th>
        </tfoot> 
        </table></div></div></div>
         <div class="panel">
    <div class="panel panel-default">
        <div class="panel clearfix"> 
            <div class="form-group">  
                <b>Invoice Number  
                <input type="number" name="invoice_number" class="form-control">  
            </div>  
            <div class="form-group">
              <label class="form-label">Date</label>
                <div class="input-group">
                  <input type="text" class="datepicker form-control" name="date" placeholder="date">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                </div>
            </div> 
            <div class="form-group">  
                <font color="blue"> Discount </font>
                <div class="input-group">
                <span class="input-group-addon">&#8360;</span>
                <input type="decimal" name="discount" class="form-control" value="0">  
            </div> </div>
        </div></div></div></b>
               </form>  
<script type="text/javascript">
    $(document).ready(function () {
    var counter = 0;
    var sum = 1;
    var sum_sale = 0;
    var price = [];
    var quant_arr = [];
    var x = 1;
    $("#addrow").on("click", function () {
        if(x<0) x=0;
        var id_send = document.getElementById("myTable").rows[sum].cells[0].childNodes[x].value;
        var quant_s = document.getElementById("myTable").rows[sum].cells[1].childNodes[x].value;
        x -= 1;
        //alert(id_send);
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
                  //alert(quant_arr[counter]);
                  sum_sale += price[counter]*quant_arr[counter]; 
                  $("#grand_t").text(sum_sale.toFixed(2));            
                }
        });
        sum = sum + 1;

        var newRow = $("<tr>");
        var cols = "";
        cols += '<td><select class="form-control" name="productid[]"><option value="">Select the Product</option><?php  foreach ($all_categories as $cat): ?><option value="<?php echo (int)$cat['id'] ?>"><?php echo $cat['name'] ?></option><?php endforeach; ?></select></td>';
        cols += '<td><input type="text" name="quantity[]" value="0"  class="form-control"/></td>';
        cols += '<td><input type="text" name="free_quantity[]" class="form-control" value="0" /></td>';

        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        newRow.append(cols);
        $("table.table-bordered").append(newRow);
        counter++;
    });
    $("table.table-bordered").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();       
        sum -= 1;
        sum_sale -= price[counter]*quant_arr[counter];
        counter -= 1;
        $("#grand_t").text(sum_sale.toFixed(2))
    });
});
</script>
<?php include_once('layouts/footer.php'); ?>
