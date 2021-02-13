<?php header('Access-Control-Allow-Origin: *'); ?>
<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Daily data of fuel sales and remain onboard which linked to each area</h4>
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
								<a href="#">Daily of Fuel Sales and Remain Onboard </a>
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
                                                    <option value="1">Now</option>
                                                    <option value="2">Current Week</option>
                                                    <option value="3">Current Month</option>
                                                    <option value="4">Date</option>
                                                    <option value="5">Range Date</option>
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
										<h4 class="card-title">Fuel Sales (Liter) - Daily data of fuel sales and remain onboard which linked to each area</h4>
									</div>
								</div>
								<div class="card-body" style="overflow:hidden;">
                                    <iframe
                                        src="<?= $metabase['maps1-1']->link; ?>?now=1"
                                        frameborder="0"
                                        allowtransparency 
                                        style="min-height:700px;width:100%;margin-top: -150px;"
                                        id="iframe">                                
                                    </iframe>
								</div>
							</div>
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Remain On Board (Liter) - Daily data of fuel sales and remain onboard which linked to each area</h4>
                                    </div>
                                </div>
                                <div class="card-body" style="overflow:hidden;">
                                    <iframe
                                        src="<?= $metabase['maps2']->link; ?>"
                                        frameborder="0"
                                        allowtransparency 
                                        style="min-height:700px;width:100%;margin-top: -150px;"
                                        id="iframe2">                                
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
        $("#divDate").hide();
        $("#inputSrc").change(function(){
            var tipe = $("#inputSrc").val();
            if( tipe == 4){
                $("#divDate").removeAttr('style');
                $("#divDate").show();
            } else {
                $("#divDate").hide();
            }
            if( tipe == 5){
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
            var url = "";
            var url2 = "";

            if( tipe == 1){
                url = "<?= $metabase['maps1-1']->link; ?>?now=1";
                url2 = "<?= $metabase['maps2']->link; ?>";
            } else if( tipe == 2){
                url = "<?= $metabase['maps1-1']->link; ?>?week=1";
                url2 = "<?= $metabase['maps2-1']->link; ?>?week=1";
            } else if( tipe == 3){
                url = "<?= $metabase['maps1-1']->link; ?>?month=1";
                url2 = "<?= $metabase['maps2-1']->link; ?>?month=1";
            } else if( tipe == 4){
                var date =  $("#inputDate").val();
                url = "<?= $metabase['maps1-2']->link; ?>?date="+date;
                if(date == '<?= date('Y-m-d'); ?>'){
                    url2 = "<?= $metabase['maps2']->link; ?>";
                } else {
                    url2 = "<?= $metabase['maps2-2']->link; ?>?date="+date;
                }
            } else if( tipe == 5){
                var datestr =  $("#inputStart").val();
                var dateend =  $("#inputEnd").val();
                url = "<?= $metabase['maps1-2']->link; ?>?start="+datestr+"&end="+dateend;
                url2 = "<?= $metabase['maps2-2']->link; ?>?start="+datestr+"&end="+dateend;
            }
            $('#iframe').attr('src', url);
            $('#iframe2').attr('src', url2);
        });
    });
</script>