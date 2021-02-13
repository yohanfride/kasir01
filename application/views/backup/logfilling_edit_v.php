<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Log Filling</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="<?= base_url()?>managerial">
									<i class="link-icon icon-grid"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="<?= base_url()?>logfilling">Log Filling</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Edit</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-12">
							<form  method="post" action="">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Form - Edit Log Filling Data</div>
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
													foreach ($cardriver as $d) { 
														$id=number_format($d->car_id,0,'',''); 
														$driver[$id] = array(
															"id" => number_format($d->driver_id,0,'',''),
															"value" => '['.$d->driver->driver_code.'] '.$d->driver->name
														);
														if($data->car_id ==  $id){
															$current_driver = array(
																"id" => number_format($d->driver_id,0,'',''),
																"value" => '['.$d->driver->driver_code.'] '.$d->driver->name
															);
														}
													?>
													<option value="<?= $id ?>" <?php if($data->car_id ==  $id) echo "selected" ?> ><?= $d->car->vehicle_number ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label for="driver">Driver</label>
												<input type="text" class="form-control" id="driver_value" name="driver_value" value="<?= $current_driver['value'] ?>"  required="required" readonly="">
												<input type="hidden" class="form-control" id="driver" name="driver" value="<?= $current_driver['id'] ?>"   required="required">
											</div>
											<div class="form-group">
												<label for="phone">Fuel Type</label>
												<select class="form-control" id="fuel_type" name="fuel_type" required>
													<?php foreach ($fuel as $d) {  ?>
													<option value="<?= $d->fuel ?>" <?php if($data->fuel_type == $d->fuel) echo "selected" ?> ><?= $d->fuel ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="model">Filling Amount</label>
												<input type="number" class="form-control" id="total_fuel" name="total_fuel" placeholder="Enter Filling Amount"  required="required" value="<?= $data->total_fuel ?>">
											</div>
											<div class="form-group">
												<label for="address">Note</label>
												<textarea class="form-control" id="note" name="note" rows="3"><?= $data->note ?></textarea>
											</div>
											<div class="form-check" >
												<label class="form-check-label">
													<input class="form-check-input" id="finish" type="checkbox" name="done" value="true" <?= ($data->status ==  1)?"checked":""; ?>>
													<span class="form-check-sign">Finish Log Filling</span>
												</label>
											</div>	
										</div>
									</div>
								</div>
								<div class="card-action">
									<button class="btn btn-success" name="save" value="save">Submit</button>
									<a href="<?= base_url('logfilling'); ?>"><button class="btn btn-danger" type="button">Cancel</button></a>
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