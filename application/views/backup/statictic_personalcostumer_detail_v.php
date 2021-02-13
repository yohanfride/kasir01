<?php header('Access-Control-Allow-Origin: *'); ?>
<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Customer : <?= $data->name; ?></h4>
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
								<a href="<?= base_url()?>statistic/personalcostumer">Personalize Customer's Data</a>
							</li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Customer : <?= $data->name; ?></a>
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
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Personalize customer's fuel consumption behaviour (Each Day)</h4>
									</div>
								</div>
								<div class="card-body" style="overflow:hidden;">
                                    <iframe
                                        src="<?= $metabase['chart1']->link; ?>?customerid=<?= $id?>&week=1"
                                        frameborder="0"
                                        allowtransparency 
                                        style="min-height:700px;width:100%;margin-top: -150px;"
                                        id="iframe1">                                
                                    </iframe>
								</div>
							</div>
						</div>
                        <div class="col-md-12 col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Each Car Total Fuel Cosumption</h4>
                                    </div>
                                </div>
                                <div class="card-body" style="overflow:hidden;">
                                    <iframe
                                        src="<?= $metabase['circle1']->link; ?>?customerid=<?= $id?>&week=1"
                                        frameborder="0"
                                        allowtransparency 
                                        style="min-height:700px;width:100%;margin-top: -250px;"
                                        id="iframe2">                                
                                    </iframe>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Each Car Total Amount Transaction</h4>
                                    </div>
                                </div>
                                <div class="card-body" style="overflow:hidden;">
                                    <iframe
                                        src="<?= $metabase['circle3']->link; ?>?customerid=<?= $id?>&week=1"
                                        frameborder="0"
                                        allowtransparency 
                                        style="min-height:700px;width:100%;margin-top: -250px;"
                                        id="iframe3">                                
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
            if( tipe == 1){
                url1 = "<?= $metabase['chart1']->link; ?>?customerid=<?= $id?>&week=1";
                url2 = "<?= $metabase['circle1']->link; ?>?customerid=<?= $id?>&week=1";
                url3 = "<?= $metabase['circle3']->link; ?>?customerid=<?= $id?>&week=1";
            } else if( tipe == 2){
                url1 = "<?= $metabase['chart1']->link; ?>?customerid=<?= $id?>&month=1";
                url2 = "<?= $metabase['circle1']->link; ?>?customerid=<?= $id?>&month=1";
                url3 = "<?= $metabase['circle3']->link; ?>?customerid=<?= $id?>&month=1";
            } else if( tipe == 3){
                var datestr =  $("#inputStart").val();
                var dateend =  $("#inputEnd").val();
                url1 = "<?= $metabase['chart1']->link; ?>?customerid=<?= $id?>&start="+datestr+"&end="+dateend;
                url1 = "<?= $metabase['circle2']->link; ?>?customerid=<?= $id?>&start="+datestr+"&end="+dateend;
                url1 = "<?= $metabase['circle3']->link; ?>?customerid=<?= $id?>&start="+datestr+"&end="+dateend;
            } else if( tipe == 4){
                url1 = "<?= $metabase['chart1']->link; ?>?customerid=<?= $id?>";
                url2 = "<?= $metabase['circle1']->link; ?>?customerid=<?= $id?>";
                url3 = "<?= $metabase['circle3']->link; ?>?customerid=<?= $id?>";
            }
            $('#iframe1').attr('src', url1);
            $('#iframe2').attr('src', url2);
            $('#iframe3').attr('src', url3);
        });
    });
</script>