function route_report(){
  $('#routeReportModal').modal('show');
}

function loading_report(){
  $('#loadingReportModal').modal('show');
}

function product_sale_report(){
  $('#productSaleReportModal').modal('show');
}

function stock_report(){
  $('#stockReportModal').modal('show');
}

function cash_report(){
  $('#cashReportModal').modal('show');
}

function cash_credit_report(){
  $('#cashCreditReportModal').modal('show');
}

function credit_route_report(){
  $('#creditRouteReportModal').modal('show');
}

function credit_route_test_report(){
  $('#creditRouteTestReportModal').modal('show');
}

function discount_report(){
  $('#discountReportModal').modal('show');
}

function route_report_process(){
  var route_name = document.getElementById("routeReport_name").value;
  var date = document.getElementById("routeReport_date").value;
  window.location = "route_report_process.php?submit=ok&route_name="+route_name+"&date="+date;
}

function loading_report_process(){
  var date = document.getElementById("loadingReport_date").value;
  window.location = "loading_unloading_report_process.php?submit=ok&date="+date;
}

function product_sale_report_process(){
  var start_date = document.getElementById("productSaleReport_start-date").value;
  var end_date = document.getElementById("productSaleReport_end-date").value;
  window.location = "product_sale_report_process.php?submit=ok&start-date="+start_date+"&end-date="+end_date;
}

function stock_report_process(){
  var start_date = document.getElementById("stockReport_start-date").value;
  var end_date = document.getElementById("stockReport_end-date").value;
  window.location = "stock_report_process.php?submit=ok&start-date="+start_date+"&end-date="+end_date;
}

function cash_report_process(){
  var start_date = document.getElementById("cashReport_start-date").value;
  var end_date = document.getElementById("cashReport_end-date").value;
  window.location = "cash_collection_report_process.php?submit=ok&start-date="+start_date+"&end-date="+end_date;
}

function cash_credit_report_process(){
  var date = document.getElementById("cashCreditReport_date").value;
  window.location = "cash_credit_collection_report_process.php?submit=ok&start-date="+date;
}

function credit_route_report_process(){
  var route_name = document.getElementById("creditRouteReport_name").value;
  var date = document.getElementById("creditRouteReport_date").value;
  window.location = "credit_route_report.php?submit=ok&route_name="+route_name+"&date="+date;
}

function credit_route_test_report_process(){
  var route_name = document.getElementById("creditRouteTestReport_name").value;
  var date = document.getElementById("creditRouteTestReport_date").value;
  window.location = "credit_route_test_report.php?submit=ok&route_name="+route_name+"&date="+date;
}

function discount_report_process(){
  var start_date = document.getElementById("discountReport_start-date").value;
  var end_date = document.getElementById("discountReport_end-date").value;
  window.location = "discount_report_process.php?submit=ok&start-date="+start_date+"&end-date="+end_date;
}