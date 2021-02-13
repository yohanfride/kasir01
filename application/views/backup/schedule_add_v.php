<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Schedule</h4>
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
								<a href="<?= base_url()?>schedule">Schedule History</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Add New Data</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-12">
							<form  method="post" action="">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Form - Add New Schedule Data</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="name">Car</label>
												<select class="form-control" id="carData" name="car" required="">
													<?php foreach ($car as $d) { $id=number_format($d->car_id,0,'',''); ?>
													<option value="<?= $id ?>"><?= $d->vehicle_number ?></option>
													<?php } ?>
												</select>
											</div>	
											<div class="form-group">
												<label for="model">Current Tank (liter)</label>
												<input type="text" class="form-control" id="carTank" readonly="">
											</div>	
											<div class="form-group">
												<label for="model">Capacity (liter)</label>
												<input type="text" class="form-control" id="carCapacity" readonly="">
											</div>
											<div class="form-group">
												<label for="model">KM Total</label>
												<input type="text" class="form-control" id="carKM" readonly="">
											</div>		
											<div class="form-group">
												<label for="model">Owner</label>
												<input type="text" class="form-control" id="carOwner" readonly="">
											</div>										
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="name">Driver</label>
												<select class="form-control" id="driverData" name="driver" required="">
													<?php 
														foreach ($driver as $d) { 
															$id=number_format($d->driver_id,0,'',''); 													
													?>
													<option value="<?= $id ?>"> [ <?= $d->driver_code ?> ] <?= $d->name ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label for="model">Driver Phone</label>
												<input type="text" class="form-control" id="driverPhone" name="driverPhone" readonly="">
											</div>	
											<div class="form-group">
												<label for="name">Sector</label>
												<select class="form-control" id="sectorData" name="sector">
													<?php foreach ($sector as $d) { ?>
													<option value="<?= $d->sector ?>"><?= $d->city ?> - <?= $d->sector ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label for="name">Status</label>
												<select class="form-control" id="statusData" name="status">
													<option value="1"> On Trip ( Active )</option>
													<option value="0"> Finish Trip ( Not Active )</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="card-action">
									<button class="btn btn-success" name="save" value="save">Submit</button>
									<a href="<?= base_url('schedule'); ?>"><button class="btn btn-danger" type="button">Cancel</button></a>
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

		$("#carData").change(function() {
			var val = $("#carData").val();
			console.log(val);
			$.ajax({
				url: "<?= base_url()?>schedule/getcar/"+val, 
				success: function(result){
					if(result){
						$( "#carTank" ).val(Number( (result.tank).toFixed(2) ));
						$( "#carCapacity" ).val(Number( (result.capacity).toFixed(2) ) );	
						$( "#carKM" ).val(Number( (result.km).toFixed(2) ) );
						$( "#carOwner" ).val(result.owner);
					}
			   		
				}
			});
			
		});

		$("#driverData").change(function() {
			var val = $("#driverData").val();
			console.log(val);
			$.ajax({
				url: "<?= base_url()?>schedule/getdriver/"+val, 
				success: function(result){
					if(result){
						$( "#driverPhone" ).val(result.phone);
					}
			   		
				}
			});			
		});
		$("#carData").change();
		$("#driverData").change();
	});


</script>