<div id="routeReportModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="row">
              <div class="col-sm-6">
                <h3><label class="label label-primary">Route Report</label></h3>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="datepicker form-control" name="date" placeholder="date" id="routeReport_date">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-6">
                 <div class="form-group">
                <div class="input-group">
                  <select class="text form-control" name="route_name" id="routeReport_name">
                      <option value="">Route Name</option>
                    <?php  foreach ($all_routes as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <div class="form-group">
                 <button onclick="route_report_process();" id="routeReport" name="submit" class="btn btn-primary">Generate Report</button>
            </div>
          </div>
        </div>
    </div>
</div>

<div id="loadingReportModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="row">
              <div class="col-sm-6">
                <h3><label class="label label-primary">Loading Unloading Report</label></h3>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="datepicker form-control" name="date" placeholder="date" id="loadingReport_date">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
              <div class="form-group">
                 <button onclick="loading_report_process();" id="routeReport" name="submit" class="btn btn-primary">Generate Report</button>
            </div>
          </div>
        </div>
    </div>
</div>

<div id="stockReportModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="row">
              <div class="col-sm-6">
                <h3><label class="label label-primary">Stock Report</label></h3>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                <div class="input-group">
                  <input type="text" class="datepicker form-control" id="stockReport_start-date" placeholder="From">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                  <input type="text" class="datepicker form-control" id="stockReport_end-date" placeholder="To">
                </div>
            </div>
              </div>
            </div>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
              <div class="form-group">
                 <button onclick="stock_report_process();" id="routeReport" name="submit" class="btn btn-primary">Generate Report</button>
            </div>
          </div>
        </div>
    </div>
</div>

<div id="productSaleReportModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="row">
              <div class="col-sm-6">
                <h3><label class="label label-primary">Product Sale Report</label></h3>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                <div class="input-group">
                  <input type="text" class="datepicker form-control" id="productSaleReport_start-date" placeholder="From">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                  <input type="text" class="datepicker form-control" id="productSaleReport_end-date" placeholder="To">
                </div>
            </div>
            </div>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
              <div class="form-group">
                 <button onclick="product_sale_report_process();" id="routeReport" name="submit" class="btn btn-primary">Generate Report</button>
            </div>
          </div>
        </div>
    </div>
</div>
</div>

<div id="cashReportModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="row">
              <div class="col-sm-6">
                <h3><label class="label label-primary">Cash Report</label></h3>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                <div class="input-group">
                  <input type="text" class="datepicker form-control" id="cashReport_start-date" placeholder="From">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                  <input type="text" class="datepicker form-control" id="cashReport_end-date" placeholder="To">
                </div>
            </div>
            </div>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
              <div class="form-group">
                 <button onclick="cash_report_process();" id="routeReport" name="submit" class="btn btn-primary">Generate Report</button>
            </div>
          </div>
        </div>
    </div>
</div>
</div>

<div id="cashCreditReportModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="row">
              <div class="col-sm-6">
                <h3><label class="label label-primary">Credit Report</label></h3>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="datepicker form-control" placeholder="date" id="cashCreditReport_date">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
              <div class="form-group">
                 <button onclick="cash_credit_report_process();" id="routeReport" name="submit" class="btn btn-primary">Generate Report</button>
            </div>
          </div>
        </div>
    </div>
</div>

<div id="creditRouteReportModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="row">
              <div class="col-sm-6">
                <h3><label class="label label-primary">Credit Report</label></h3>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="datepicker form-control" name="date" placeholder="date" id="creditRouteReport_date">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-6">
                 <div class="form-group">
                <div class="input-group">
                  <select class="text form-control" name="route_name" id="creditRouteReport_name">
                      <option value="">Route Name</option>
                    <?php  foreach ($all_routes as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <div class="form-group">
                 <button onclick="credit_route_report_process();" id="routeReport" name="submit" class="btn btn-primary">Generate Report</button>
            </div>
          </div>
        </div>
    </div>
</div>

<div id="creditRouteTestReportModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="row">
              <div class="col-sm-6">
                <h3><label class="label label-primary">Credit Report</label></h3>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="datepicker form-control" name="date" placeholder="date" id="creditRouteTestReport_date">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-6">
                 <div class="form-group">
                <div class="input-group">
                  <select class="text form-control" name="route_name" id="creditRouteTestReport_name">
                      <option value="">Route Name</option>
                    <?php  foreach ($all_routes as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <div class="form-group">
                 <button onclick="credit_route_test_report_process();" id="routeReport" name="submit" class="btn btn-primary">Generate Report</button>
            </div>
          </div>
        </div>
    </div>
</div>

<div id="discountReportModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="row">
              <div class="col-sm-6">
                <h3><label class="label label-primary">Discount Report</label></h3>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                <div class="input-group">
                  <input type="text" class="datepicker form-control" id="discountReport_start-date" placeholder="From">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                  <input type="text" class="datepicker form-control" id="discountReport_end-date" placeholder="To">
                </div>
            </div>
            </div>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
              <div class="form-group">
                 <button onclick="discount_report_process();" id="routeReport" name="submit" class="btn btn-primary">Generate Report</button>
            </div>
          </div>
        </div>
    </div>
</div>
</div>