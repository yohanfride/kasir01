<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Cargo Inspection</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="<?= base_url()?>operational">
									<i class="link-icon icon-settings"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="<?= base_url()?>cargoinspection">Cargo Inspection</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Edit Data</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-12">
							<form  method="post" action="">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Form - Edit Cargo Inspection Data</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="name">Car</label>
												<select class="form-control" id="car" name="car" required>
													<option value="">Choose Car/Truck</option>
													<?php 
													$driver = array();
													foreach ($car as $d) { 
														$id=number_format($d->car_id,0,'',''); 
													?>
													<option value="<?= $id ?>" <?php if($data->car_id ==  $id) echo "selected" ?> ><?= $d->vehicle_number ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label for="tank">Tank</label>
												<select class="form-control" id="tank" name="tank" required>
													<option value="0" <?php if($data->tank ==  0) echo "selected" ?> >Not Check</option>
													<option value="1" <?php if($data->tank ==  1) echo "selected" ?> >Good</option>
													<option value="2" <?php if($data->tank ==  2) echo "selected" ?> >Bad</option>
												</select>
											</div>
											<div class="form-group">
												<label for="atg">ATG</label>
												<select class="form-control" id="atg" name="atg" required>
													<option value="0" <?php if($data->atg ==  0) echo "selected" ?> >Not Check</option>
													<option value="1" <?php if($data->atg ==  1) echo "selected" ?> >Good</option>
													<option value="2" <?php if($data->atg ==  2) echo "selected" ?> >Bad</option>
												</select>
											</div>
											<div class="form-group">
												<label for="flow_meter">Flow Meter</label>
												<select class="form-control" id="flow_meter" name="flow_meter" required>
													<option value="0" <?php if($data->flow_meter ==  0) echo "selected" ?> >Not Check</option>
													<option value="1" <?php if($data->flow_meter ==  1) echo "selected" ?> >Good</option>
													<option value="2" <?php if($data->flow_meter ==  2) echo "selected" ?> >Bad</option>
												</select>
											</div>
											<div class="form-group">
												<label for="pump">Pump</label>
												<select class="form-control" id="pump" name="pump" required>
													<option value="0" <?php if($data->pump ==  0) echo "selected" ?> >Not Check</option>
													<option value="1" <?php if($data->pump ==  1) echo "selected" ?> >Good</option>
													<option value="2" <?php if($data->pump ==  2) echo "selected" ?> >Bad</option>
												</select>
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="power_system">Power System</label>
												<select class="form-control" id="power_system" name="power_system" required>
													<option value="0" <?php if($data->power_system ==  0) echo "selected" ?> >Not Check</option>
													<option value="1" <?php if($data->power_system ==  1) echo "selected" ?> >Good</option>
													<option value="2" <?php if($data->power_system ==  2) echo "selected" ?> >Bad</option>
												</select>
											</div>
											<div class="form-group">
												<label for="pipeline">Pipeline</label>
												<select class="form-control" id="pipeline" name="pipeline" required>
													<option value="0" <?php if($data->pipeline ==  0) echo "selected" ?> >Not Check</option>
													<option value="1" <?php if($data->pipeline ==  1) echo "selected" ?> >Good</option>
													<option value="2" <?php if($data->pipeline ==  2) echo "selected" ?> >Bad</option>
												</select>
											</div>
											<div class="form-group">
												<label for="hose">Hose</label>
												<select class="form-control" id="hose" name="hose" required>
													<option value="0" <?php if($data->hose ==  0) echo "selected" ?> >Not Check</option>
													<option value="1" <?php if($data->hose ==  1) echo "selected" ?> >Good</option>
													<option value="2" <?php if($data->hose ==  2) echo "selected" ?> >Bad</option>
												</select>
											</div>
											<div class="form-group">
												<label for="box">Box</label>
												<select class="form-control" id="box" name="box" required>
													<option value="0" <?php if($data->box ==  0) echo "selected" ?> >Not Check</option>
													<option value="1" <?php if($data->box ==  1) echo "selected" ?> >Good</option>
													<option value="2" <?php if($data->box ==  2) echo "selected" ?> >Bad</option>
												</select>
											</div>
											<div class="form-group">
												<label for="address">Note</label>
												<textarea class="form-control" id="note" name="note" rows="3"></textarea>
											</div>
										</div> 
									</div>
								</div>
								<div class="card-action">
									<button class="btn btn-success" name="save" value="save">Submit</button>
									<button class="btn btn-danger">Cancel</button>
								</div>								
							</div>
							</form>
						</div>
					</div>
				</div>
<?php include("footer.php") ?>
<script type="text/javascript">
	$(document).ready(function() {
		//Notify
		<?php if($success){ ?>
		$.notify({
			icon: 'flaticon-success',
			title: 'Success',
			message: '<?= $success; ?>',
		},{
			type: 'success',
			placement: {
				from: "bottom",
				align: "right"
			},
			time: 3000,
		});	
		<?php } 
		 if($error){ ?>
		$.notify({
			icon: 'flaticon-error',
			title: 'Failed',
			message: '<?= $error; ?>',
		},{
			type: 'danger',
			placement: {
				from: "bottom",
				align: "right"
			},
			time: 3000,
		});	
		<?php } ?>

		car_driver = JSON.parse('<?php echo JSON_encode($driver);?>');
    	console.log(car_driver);
    	$("#car").on('change', function() {
	        var car = $(this).find(":selected").val();
	        var driver_item = car_driver[car];
	        $("#driver_value").val(driver_item.value);
	        $("#driver").val(driver_item.id);
	    });

	});

</script>