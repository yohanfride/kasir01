<?php header('Access-Control-Allow-Origin: *'); ?>
<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Cost of maintenance, extracting from operation data</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
                                <a href="<?= base_url()?>statistic">
                                    <i class="link-icon icon-chart"></i>
                                </a>
                            </li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Maintenance Cost</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Search Data</div>
                                </div>
                                                
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4" >
                                            <div class="form-group">
                                                <label for="body-machine">Search By</label>
                                                <select class="form-control" name="tipe" id="inputSrc" required>
                                                    <option value="1">Current Week</option>
                                                    <option value="2">Current Month</option>
                                                    <option value="3">Range Date</option>
                                                    <option value="4">All</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="divDate" style="display: none;">
                                            <div class="form-group">
                                                <label for="body-machine">Date</label>
                                                <input type="text" class="form-control datepicker" data-name="str" id="inputDate" placeholder="Enter Birth" required="required" value="<?= date("Y-m-d")?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="divStartDate" style="display: none;">
                                            <div class="form-group">
                                                <label for="body-machine">Start</label>
                                                <input type="text" class="form-control datepicker" data-name="str" id="inputStart" placeholder="Enter Birth" required="required" value="<?= date("Y-m-d")?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" id="divEndDate" style="display: none;">
                                                <label for="body-machine">End</label>
                                                <input type="text" class="form-control datepicker" data-name="end" id="inputEnd" placeholder="Enter Birth" required="required" value="<?= date("Y-m-d")?>">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12">
                                            <div class="form-group">
                                                <button class="btn btn-primary" type="button" id="btnSrc">Filter Data</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>                              
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Maps Maintenance Cost (IDR) Only </h4>
									</div>
								</div>
								<div class="card-body" style="overflow:hidden;">
                                    <iframe
                                        src="<?= $metabase['maps1']->link; ?>?week=1"
                                        frameborder="0"
                                        allowtransparency 
                                        style="min-height:700px;width:100%;margin-top: -230px;"
                                        id="iframe1">                                
                                    </iframe>
								</div>
							</div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Maps Total Fuel Sales (IDR) Only </h4>
                                    </div>
                                </div>
                                <div class="card-body" style="overflow:hidden;">
                                    <iframe
                                        src="<?= $metabase['maps2']->link; ?>?week=1"
                                        frameborder="0"
                                        allowtransparency 
                                        style="min-height:700px;width:100%;margin-top: -230px;"
                                        id="iframe2">                                
                                    </iframe>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Chart Based on Car/Truck </h4>
                                    </div>
                                </div>
                                <div class="card-body" style="overflow:hidden;">
                                    <iframe
                                        src="<?= $metabase['chart1']->link; ?>?week=1"
                                        frameborder="0"
                                        allowtransparency 
                                        style="min-height:700px;width:100%;margin-top: -150px;"
                                        id="iframe3">                                
                                    </iframe>
                                </div>
                            </div>
						</div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Chart Based on Sector/Area of Car/Truck</h4>
                                    </div>
                                </div>
                                <div class="card-body" style="overflow:hidden;">
                                    <iframe
                                        src="<?= $metabase['chart2']->link; ?>?week=1"
                                        frameborder="0"
                                        allowtransparency 
                                        style="min-height:700px;width:100%;margin-top: -150px;"
                                        id="iframe4">                                
                                    </iframe>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Table</h4>
                                    </div>
                                </div>
                                <div class="card-body" style="overflow:hidden;">
                                    <iframe
                                        src="<?= $metabase['table1']->link; ?>?week=1"
                                        frameborder="0"
                                        allowtransparency 
                                        style="min-height:700px;width:100%;margin-top: -140px;"
                                        id="iframe5">                                
                                    </iframe>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
<?php include("footer.php") ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.datepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $("#divStartDate").hide();
        $("#divEndDate").hide();
        $("#inputSrc").change(function(){
            var tipe = $("#inputSrc").val();
            if( tipe == 3){
                $("#divStartDate").removeAttr('style');
                $("#divEndDate").removeAttr('style');
                $("#divStartDate").show();
                $("#divEndDate").show();
            } else {
                $("#divStartDate").hide();
                $("#divEndDate").hide();
            }
        });
        $("#btnSrc").click(function(){
            var tipe = $("#inputSrc").val();
            var url1 = "";
            var url2 = "";
            var url3 = "";
            var url4 = "";
            var url5 = "";
            if( tipe == 1){
                url1 = "<?= $metabase['maps1']->link; ?>?week=1";
                url2 = "<?= $metabase['maps2']->link; ?>?week=1";
                url3 = "<?= $metabase['chart1']->link; ?>?week=1";
                url4 = "<?= $metabase['chart2']->link; ?>?week=1";
                url5 = "<?= $metabase['table1']->link; ?>?week=1";
            } else if( tipe == 2){
                url1 = "<?= $metabase['maps1']->link; ?>?month=1";
                url2 = "<?= $metabase['maps2']->link; ?>?month=1";
                url3 = "<?= $metabase['chart1']->link; ?>?month=1";
                url4 = "<?= $metabase['chart2']->link; ?>?month=1";
                url5 = "<?= $metabase['table1']->link; ?>?month=1";
            } else if( tipe == 3){
                var datestr =  $("#inputStart").val();
                var dateend =  $("#inputEnd").val();
                url1 = "<?= $metabase['maps1']->link; ?>?start="+datestr+"&end="+dateend;
                url2 = "<?= $metabase['maps2']->link; ?>?start="+datestr+"&end="+dateend;
                url3 = "<?= $metabase['chart1']->link; ?>?start="+datestr+"&end="+dateend;
                url4 = "<?= $metabase['chart2']->link; ?>?start="+datestr+"&end="+dateend;
                url5 = "<?= $metabase['table1']->link; ?>?start="+datestr+"&end="+dateend;
            } else if( tipe == 4){
                url1 = "<?= $metabase['maps1']->link; ?>";
                url2 = "<?= $metabase['maps2']->link; ?>";
                url3 = "<?= $metabase['chart1']->link; ?>";
                url4 = "<?= $metabase['chart2']->link; ?>";
                url5 = "<?= $metabase['table1']->link; ?>";
            }
            $('#iframe1').attr('src', url1);
            $('#iframe2').attr('src', url2);
            $('#iframe3').attr('src', url3);
            $('#iframe4').attr('src', url4);
            $('#iframe5').attr('src', url5);
        });
    });
</script>