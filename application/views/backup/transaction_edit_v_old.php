<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Transaction</h4>
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
								<a href="<?= base_url()?>transaction">Transaction</a>
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
									<div class="card-title">Form - Add New Transaction Data</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="name">Customer</label>
												<select class="form-control" id="exampleFormControlSelect1" name="customer">
													<?php foreach ($customer as $d) { $id=number_format($d->customer_id,0,'',''); ?>
													<option value="<?= $id ?>" <?php if($data->customer_id ==  $id) echo "selected" ?> ><?= $d->name ?>&nbsp;&nbsp;&nbsp;[ <?= $d->email ?> - <?= $d->phone ?> ]</option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label for="name">Customer Car</label>
												<select class="form-control" id="customer-car" name="customer-car" required>
													<?php foreach ($customercar as $d) { $id=number_format($d->customer_car,0,'',''); ?>
													<option value="<?= $id ?>" <?php if($data->customer_car_id ==  $id) echo "selected" ?>><?= $d->vehicle_number ?> - <?= $d->brand ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label for="name">Transaction Status</label>
												<select class="form-control" id="exampleFormControlSelect1" name="status">
													<?php for($i=0; $i<count($status); $i++) { if($i==1) $i++;  ?>
													<option value="<?= $i?>" <?php if($data->status ==  $i) echo "selected" ?> ><?= $status[$i]?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label for="phone">Fuel Type</label>
												<select class="form-control" id="fuel-type" name="fuel-type" required>
													<?php 
													$prices = array(); 
													foreach ($fuel as $d) { 
														$prices[] = $d->price; ?>
													<option value="<?= $d->fuel ?>" <?php if($data->fuel_type == $d->fuel) echo "selected" ?> ><?= $d->fuel ?></option>									
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label for="model">Fuel Price</label>
												<input type="number" class="form-control" id="price" name="price" placeholder="Enter Fuel Price" required="required" value="<?= $data->price ?>">
											</div>
											<div class="form-group">
												<label for="model">Total</label>
												<input type="number" class="form-control" id="fuel-total" name="fuel-total" placeholder="Enter Total" required="required" value="<?= $data->total_fuel ?>">
											</div>
											<div class="form-group">
												<label for="model">Pay</label>
												<input type="number" class="form-control" id="pay" name="pay" placeholder="0" required="required" value="<?= $data->pay ?>">
											</div>
											<div class="form-group">
												<label for="phone">Address</label>
												<textarea class="form-control" id="address" name="address" rows="2" disable><?= $data->location_address; ?></textarea>
											</div>
											<div class="form-group">
												<label for="phone">Note</label>
												<textarea class="form-control" id="note" name="note" rows="2" disable><?= $data->note; ?></textarea>
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="phone">Meet Location</label>
												<div id="map" style="height: 300px;"></div>
											</div>
											<div class="form-group">
												<button class="btn btn-info" type="button" name="src" value="src" id="btnDriver">Search Driver</button>
											</div>
											<div class="form-group">
												<label for="model">Sector</label>
												<input type="text" class="form-control" id="sector-name" name="sector-name" placeholder="-" required="required" readonly>
											</div>
											<div class="form-group">
												<label for="name">Car</label>
												<select class="form-control" id="exampleFormControlSelect1" name="car">
													<?php foreach ($car as $d) { $id=number_format($d->car_id,0,'',''); ?>
													<option value="<?= $id ?>" <?php if($data->car_id ==  $id) echo "selected" ?>><?= $d->vehicle_number ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label for="name">Driver</label>
												<select class="form-control" id="exampleFormControlSelect1" name="driver">
													<?php foreach ($driver as $d) { $id=number_format($d->driver_id,0,'',''); ?>
													<option value="<?= $id ?>" <?php if($data->driver_id ==  $id) echo "selected" ?>><?= $d->name ?>&nbsp;&nbsp;&nbsp;[ <?= $d->driver_code ?> - <?= $d->phone ?> ]</option>
													<?php } ?>
												</select>
											</div>
											<div class="form-check">
												<label class="form-check-label">
													<input class="form-check-input" type="checkbox" name="paid" value="true">
													<span class="form-check-sign">Paid Transaction</span>
												</label>
											</div>
										</div>
										<input type="hidden" id="sector" name="sector" value="<?= $data->sector; ?>">
										<input type="hidden" id="location-lat" name="location-lat" value="<?= $data->location_lat; ?>">
										<input type="hidden" id="location-lng" name="location-lng" value="<?= $data->location_lng; ?>">
									</div>
								</div>
								<div class="card-action">
									<button class="btn btn-success" name="save" value="save">Submit</button>
									<a href="<?= base_url('transaction'); ?>"><button class="btn btn-danger" type="button">Cancel</button></a>
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

	$( "#price" ).keyup(function( event ) {
		var total = parseFloat($( "#price" ).val()) * parseFloat($( "#fuel-total" ).val());
		$("#pay").val(total);
	});
	$( "#fuel-total" ).keyup(function( event ) {
		var total = parseFloat($( "#price" ).val()) * parseFloat($( "#fuel-total" ).val());
		$("#pay").val(total);
	});
	<?php
	$js_array = json_encode($prices);
	echo "var prices = ". $js_array . ";\n";
	?>
	$("#fuel-type").change(function() {
		var index = $(this).children('option:selected').index();
		var price = prices[index];
		$( "#price" ).val(price);
		$( "#price" ).keyup();
	});

	$("#customer").change(function(){
		var value = $(this).val();
		carcustomer(value);
	});

	function carcustomer(car){
		$.ajax({
           type: "GET",
           url: "<?= base_url()?>customercar/getcar/"+car,
           success: function(data){
            	console.log(data); // show response from the php script.
            	var text='';
				for (i = 0; i < data.length; i++) {
		          text += '<option value="'+data[i].customer_car_id+'" >'+data[i].vehicle_number+' - '+data[i].brand+'</option>';
		        }
		        $("#customer-car").html(text);
           }
        });
	}
	carcustomer($("#customer").val());
</script>