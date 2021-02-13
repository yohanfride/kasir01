<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Customer Car Detail</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="<?= base_url()?>managerial">
									<i class="link-icon icon-grid"></i>
								</a>
							</li>

							<?php if(!isset($customer_id)){ ?>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="<?= base_url()?>customercar">Customer Car</a>
							</li>

							<?php } else { ?>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="<?= base_url()?>customer">Customer</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="<?= base_url()?>customercar/customer/<?= $customer_id ?>">Customer Car</a>
							</li>
							<?php } ?>

							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Detail</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-8 col-lg-6">
							<form  method="post" action="">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Customer Car Data</div>
								</div>
								
								<div class="card-body">
									<div class="row">
										<div class="col-md-12 col-lg-12">
											<div class="form-group">
												<label for="name">Customer Owner</label>
												<input type="text" class="form-control" id="body-machine" name="body-machine" placeholder="Enter Body Machine" value="<?= $data->customer->name?>">
											</div>
											<div class="form-group">
												<label for="name">Customer Email</label>
												<input type="text" class="form-control" id="body-machine" name="body-machine" placeholder="Enter Body Machine" value="<?= $data->customer->email?>">
											</div>
											<div class="form-group">
												<label for="vnumber">Vehicle Number</label>
												<input type="text" class="form-control" id="vnumber" name="vnumber" placeholder="Enter Vehicle Number" readonly value="<?= $data->vehicle_number?>">
											</div>
											<div class="form-group">
												<label for="brand">Brand</label>
												<input type="text" class="form-control" id="brand" name="brand" placeholder="-" readonly value="<?= $data->brand?>">
											</div>
											<div class="form-group">
												<label for="model">Model</label>
												<input type="text" class="form-control" id="model" name="model" placeholder="-" readonly value="<?= $data->model?>">
											</div>
											<div class="form-group">
												<label for="body-machine">Body Machine</label>
												<input type="text" class="form-control" id="body-machine" name="body-machine" readonly placeholder="-" value="<?= $data->body_machine?>">
											</div>

											<div class="form-group">
												<label for="year">Year</label>
												<input type="text" class="form-control" id="year" name="year" placeholder="-" value="<?= $data->year?>">
											</div>
											<div class="form-group">
												<label for="capacity">Capacity (Liter)</label>
												<input type="number" class="form-control" id="capacity" name="capacity" placeholder="-" readonly value="<?= $data->fuel_tank_capacity?>" >
											</div>
											<div class="form-group">
												<label for="fuel_type">Fuel Type</label>
												<input type="text" class="form-control" id="fuel_type" name="fuel_type" placeholder="-" value="<?= $data->fuel_type?>"  readonly>
											</div>
											
										</div>
									</div>
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
	});
</script>