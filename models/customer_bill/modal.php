<!-- Modal this is used to take the password to edit-->
<div id="myModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Enter the password</h4>
          </div>
          <div class="modal-body">
              <p id="modal_body_txt"></p>
              
              <!-- Select Basic -->
        <div class="control-group">
          <div class="controls">
            <input id="user_p" name="id" type="hidden" placeholder="" class="form-control" required="" value="">
            <input id="user_password" name="password" type="password" placeholder="password" class="form-control" required="">
          </div>
        </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" id="assign_button" class="btn btn-success">Proceed</button>
          </div>
      </div>
  </div>
</div>
<!-- Modal this is used to take the password to delete-->
<div id="deleteModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <font color="red"><h3>You are about to delete</h3></font>
              <h4 class="modal-title">Enter the password</h4>
          </div>
          <div class="modal-body">
              <p id="modal_body_txt"></p>
              
              <!-- Select Basic -->
        <div class="control-group">
          <div class="controls">
            <input id="user_d" name="id" type="hidden" placeholder="" class="form-control" required="" value="">
            <input id="delete_password" name="password" type="password" placeholder="password" class="form-control" required="">
          </div>
        </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" id="delete_button" class="btn btn-success">Proceed</button>
          </div>
      </div>
  </div>
</div>
<!-- Modal this is used to take the password to Add-->
<div id="addModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Enter the password</h4>
          </div>
          <div class="modal-body">
              <p id="modal_body_txt"></p>
              
              <!-- Select Basic -->
        <div class="control-group">
          <div class="controls">
            <input id="user_add" name="id" type="hidden" placeholder="" class="form-control" required="" value="">
            <input id="add_password" name="password" type="password" placeholder="password" class="form-control" required="">
          </div>
        </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" id="add_button" class="btn btn-success">Proceed</button>
          </div>
      </div>
  </div>
</div>
<!-- Modal this is used to take the password to delete all-->
<div id="deleteAllModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <font color="red"><h3>You are about to delete</h3></font>
              <h4 class="modal-title">Enter the password</h4>
          </div>
          <div class="modal-body">
              <p id="modal_body_txt"></p>
              
              <!-- Select Basic -->
        <div class="control-group">
          <div class="controls">
            <input id="user_delete" name="id" type="hidden" placeholder="" class="form-control" required="" value="">
            <input id="delete_all_password" name="password" type="password" placeholder="password" class="form-control" required="">
          </div>
        </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" id="delete_all_button" class="btn btn-success">Proceed</button>
          </div>
      </div>
  </div>
</div>

<!-- Modal this is used to Add-->
<div id="addNowModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <font color="green"><h3>Add Data</h3></font>
          </div>
          <div class="modal-body">
              <p id="modal_body_txt"></p>
              <input id="addInv" name="id" type="hidden" placeholder="" class="form-control" required="" value="">
              <table id="myTable" class="table table-bordered table-hover">  
                <thead>  
                  <th>Product ID</th>  
                  <th>Quantity</th>  
                  <th>Free Quantity</th>
                  <th>Discount Quantity</th>
                  <th>Received Return</th>
                  <th>Reissued</th>  
                </thead>  
                <tbody class="detail">  
                  <tr>
                    <td><select class="form-control" id="productid">
                    <option value="">Select the Product</option>
                    <?php  foreach ($all_categories as $cat): ?>
                    <option value="<?php echo (int)$cat['id'] ?>">
                    <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select></td>  
                    <td><input type="text" class="form-control quantity" id="quantity"  value="0"></td>  
                    <td><input type="text" class="form-control amount" id="free_quantity" value="0"></td>
                    <td><input type="text" class="form-control amount" id="discount_quantity" value="0"></td>
                    <td><input type="text" class="form-control amount" id="received_return" value="0"></td> 
                    <td><input type="text" class="form-control amount" id="reissued" value="0"></td> 
                  </tr>  
                </tbody>  
              </table>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" id="add_now_button" class="btn btn-success">Proceed</button>
          </div>
      </div>
  </div>
</div>