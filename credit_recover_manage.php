<?php
require_once('includes/load.php');
$page_title = 'Credit Recovery';
$customer_bill = find_all('credit_recover');
$password = find_by_id('data_protect','1');
include_once('layouts/header.php');
?>  
<link rel="stylesheet" href="libs/bootstrap/css/dataTables.bootstrap.css">
<link rel="stylesheet" href="libs/bootstrap/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="libs/bootstrap/css/buttons.dataTables.min.css">
<script type="text/javascript" src="libs/bootstrap/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="libs/1.js"></script>
<script type="text/javascript" src="libs/bootstrap/js/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="libs/bootstrap/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="libs/bootstrap/js/pdfmake.min.js"></script>
<script type="text/javascript" src="libs/bootstrap/js/vfs_fonts.js"></script>
<script type="text/javascript" src="libs/bootstrap/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="libs/bootstrap/js/sweetalert.min.js"></script>
<script>
var loop = [];

    $( document ).ready(function() {

     var oTable = $('#userRequestList').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4'
            }
        ],
        "columnDefs": [
          {
            "targets": [ 0 ],
            "visible": false,
            "searchable": false
          },
          {
            "targets": [ 4 ],
            "visible": false,
            "searchable": false
          }
        ]
      });
      
      $('#delete_button').click(function() {
        var password = document.getElementById("delete_password").value;
        var bool = document.getElementById("user_d").value;
          if (password == <?php echo $password['password'];?>){
              delete_bill(bool, "credit_recover");
          } else {
              swal("Error!", "Password you entered is wrong!", "warning");
          }
        $('#deleteModal').modal('hide');
      });

      $('#add_new_button').click(function() {
        $('#addNowModal').modal('show');
      });

      $('#assign_button').click(function() {
        var inv_no = document.getElementById("assign_id").value;
        var rec_cred_js = document.getElementById("rec_cred_modal").value;
        var rec_cheq_js = document.getElementById("rec_cheq_modal").value;
        var date_js = document.getElementById("date_modal").value;

        if(rec_cheq_js=='') rec_cheq_js=0;
        if(rec_cred_js=='') rec_cred_js=0;
        
        $.ajax({//create an ajax request to customer_find.php
          type: "GET",
          data: {ok: 1, inv: inv_no, rec_cred : rec_cred_js,rec_cheq : rec_cheq_js,date : date_js},
          url: "credit_recover_add.php",             
          dataType: "html",   //expect html to be returned                
          success: function(value){ 
            var data = value.split(",");  
            x = Number(data[0]);
            if(x==1){
              swal("Success!", "Added successfully", "success");
              location.reload();
            }else{
              swal("Failed!", "Failed to add"+x, "danger");
            }     
          }
        });
        $('#addNowModal').modal('hide');
      });

    });

    function delete_bill(bool,table){
      $.ajax({//create an ajax request to customer_find.php
        type: "GET",
        data: {id: bool, table: table},
        url: "delete_script.php",             
        dataType: "html",   //expect html to be returned                
        success: function(value){ 
          var data = value.split(",");  
          x = Number(data[0]);
          if(x==1){
            swal("Success!", "Deleted successfully", "success");
            location.reload();
          }else{
            swal("Failed!", "Failed to Delete"+data[0], "danger");
          }     
        }
      });
    }

    function credit_modal(inv1){
      var inv_no = inv1;
      $.ajax({//create an ajax request to customer_find.php
        type: "GET",
        data: {ok: 1, inv: inv_no},
        url: "credit_recover_invoice.php",             
        dataType: "html",   //expect html to be returned                
        success: function(value){ 
          var data = value.split(",");  
          document.getElementById('modalInvoice').innerHTML = inv_no;
          document.getElementById('modalDate').innerHTML = data[0];
          document.getElementById('modalRoute').innerHTML = data[4];
          document.getElementById('modalCredit').innerHTML = data[1];
          document.getElementById('modalName').innerHTML = data[2];
          document.getElementById('modalPaid').innerHTML = (data[1]-data[3]).toFixed(2);
        }
      });
      $('#myModal').modal('show');
    }

    function delete_val(id_get){
      $('#deleteModal').modal('show');
      $(".modal-body #user_d").val( id_get );
    }

    function selectB(x){
      var list;
      var cust_d = x;
      $.ajax({    //create an ajax request to script.php
        type: "GET",
        data: {cust_id : cust_d},
        url: "credit_recover_script.php",             
        dataType: "html",   //expect html to be returned                
        success: function(value){ 
        var data = value.split(","); 
        list = data;
        var cx = Number(data[0]);
        if(cx==2){
          swal("Failed!", "No matching Invoices", "danger");
        }
        },
        async: false //very important 
      });
    //console.log(list);
    for(var i = 1; i < list.length; i++){
     this.loop.push('<option>'+list[i]+'</option>');
    }

    var selected_assign = this.loop[1];

    $.each(this.loop, function( key, value ) {
        $("#assign_id").append(value);
    });

    }

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
        },
        async : false
      }); 
      //console.log(x);
      selectB(x);
    }
</script>
      <div class="panel">
        <div class="row">
          <div class="col-md-12">
             <?php echo display_msg($msg); ?>
          </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
              <div class="col-md-12 column">
              <div class="col-xs-5">
                  <span class="glyphicon glyphicon-th"></span>
                  <b>Credit Recovery</b>
               </div>
               <div class="col-xs-5">
                <button type="button" id="add_new_button" class="btn btn-primary">Add New</button>
              </div>
            </div>
          </div>
      </br>
        <div class="panel clearfix">
          <div class="col-md-12 column">
      <table id="userRequestList" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
        <thead>
          <tr>
                  <th class="text-center" >#</th>
                  <th class="text-center" > Invoice Number </th>
                  <th class="text-center" > Date </th>
                  <th class="text-center" > Received Credit </th>
                  <th class="text-center" > Received Credit </th>
                  <th class="text-center" > Received Cheque </th>
                  <th class="text-center" > Actions </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($customer_bill as $product):?>
                <tr>
                  <td class="text-center"><?php echo count_id();?></td>
                  <td class="text-center"><input id="creditShow" type="button" onclick="credit_modal(<?php echo (int)$product['invoice_number'];?>)" class="btn btn-info btn-xs" value = "<?php echo remove_junk($product['invoice_number']); ?>"> </td>
                  <td class="text-center"><?php echo remove_junk($product['date']); ?></td>
                  <td class="text-left">Rs. <?php echo remove_junk($product['received_credit']); ?></td>
                  <td class="text-left">Rs. <?php echo remove_junk($product['received_credit']); ?></td>
                  <td class="text-left">Rs. <?php echo remove_junk($product['received_cheque']); ?></td>
                  <td class="text-center">
                    <div class="btn-group">
                      <input type="button" onclick="delete_val(<?php echo (int)$product['id'];?>)" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip" value = "Delete">
                    </div>
                  </td>
                </tr>
               <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    </div>
  </div>    
<?php include_once('models/credit_recover/modal.php'); ?>
<!-- Modal -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="pull-right">
              <h3><label id="modalDate" class="label label-warning"></label></h3>
            </div>
            <div class="pull-left">
              <h3><label id="modalInvoice" class="label label-primary"></label></h3>
            </div>
            <div class="pull-left">
              <h3><label id="modalName" class="label label-success"></label></h3>
            </div>
            <div class="pull-left">
              <h3><label id="modalRoute" class="label label-info"></label></h3>
            </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-6">
                <b>Credit Amount : </b><h3>Rs. <label id="modalCredit" class="label label-primary"></label></h3>
              </div>
              <div class="col-sm-6">
                <b>Credit Remain : </b><h3>Rs. <label id="modalPaid" class="label label-danger"></label></h3>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
          </div>
        </div>
    </div>
</div>