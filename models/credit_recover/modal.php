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

<!-- Modal this is used to Add-->
<div id="addNowModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <font color="green"><h3>Credit Recover</h3></font>
          </div>
          <div class="modal-body">
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
            <div class="col-md-6">
            <div class="form-group">
                 <div class="row">
                  <div class="col-md-6">
                    <div class="control-group">
                        <div class="controls">
                          <select id="assign_id" name="assign_id" class="form-control" title="" data-width="100%">
                          </select>
                        </div>
                      </div>
                  </div>
              </div>
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <input id="date_modal" type="text" class="datepicker form-control" placeholder="date">
                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
              </div>
          </div>
          </div>
          </div>
          <div class="row">
          <div class="col-md-6">
            <div class="input-group">
             <span class="input-group-addon">
               &#8360;
             </span>
             <input id="rec_cred_modal" type="decimal" class="form-control" name="buying-price" placeholder="Received Credit"> 
          </div>
          </div>
          <div class="col-md-6">
            <div class="input-group">
             <span class="input-group-addon">
               &#8360;
             </span>
             <input id="rec_cheq_modal" type="decimal" class="form-control" name="buying-price" placeholder="Received Cheque"> 
          </div>
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