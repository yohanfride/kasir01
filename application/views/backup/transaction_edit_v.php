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
									<div class="card-title">Form - Edit Transaction Data</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="name">Customer</label>
												<select class="form-control" id="customer" name="customer">
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
												<input type="text" class="form-control" id="price" name="price" placeholder="Enter Fuel Price" required="required" value="<?php if(!empty($data->price)) echo number_format($data->price,0,',','.'); ?>"  readonly>
											</div>
											<div class="form-group">
												<label for="phone">Buy By</label>
												<select class="form-control" id="buy-by" name="buy-by">
													<option value="" onclick="changeby('total');">Fuel Liter</option>
													<option value="" onclick="changeby('money');">Money</option>
												</select>
											</div>
											<div class="form-group row">
												<div class="form-group col-6">
													<label for="model">Total</label>
													<input type="text" class="form-control" id="fuel-total" name="fuel-total" placeholder="Enter Total" value="<?= $data->total_fuel ?>" required="required" >
												</div>
												<div class="form-group col-6">
													<label for="model">Pay</label>
													<input type="text" class="form-control" id="pay-label" name="pay-label" placeholder="0" value="<?= number_format($data->pay,0,',','.') ?>" required="required" readonly>
													<input type="hidden" class="form-control" id="pay" name="pay" placeholder="0" value="<?= $data->pay ?>" required="required">
												</div>
											</div>
											<div class="form-group">
												<label for="phone">Note</label>
												<textarea class="form-control" id="note" name="note" rows="2"><?= $data->location_address; ?></textarea>
											</div>
											<div class="form-group">
												<label for="phone">Address</label>
												<textarea class="form-control" id="address" name="address" rows="2"><?= $data->note; ?></textarea>
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
												<input type="text" class="form-control" id="sector-name" name="sector-name" placeholder="-" value="<?= (empty($data->sector))?'not found':$data->sector; ?>" required="required" readonly>
											</div>
											<div class="form-group ">
												<label for="model">Driver</label>
												<input type="text" class="form-control" id="driver-name" name="driver-name" placeholder="-" value="[<?= $data->driver->driver_code; ?>] <?= $data->driver->name; ?>" required="required" readonly>
											</div>
											<div class="form-group ">
												<label for="model">Car Vehicle Number</label>
												<input type="text" class="form-control" id="car-name" name="car-name" placeholder="-" value=" <?= $data->car->vehicle_number; ?> - <?= $data->car->tank; ?>L" required="required" readonly>
											</div>
										</div>
										<input type="hidden" id="driver" name="driver" value="<?=number_format($data->driver_id,0,'','')?>">
										<input type="hidden" id="car" name="car" value="<?= number_format($data->car_id,0,'','') ?>">
										<input type="hidden" id="sector" name="sector" value="<?= $data->sector?>">
										<input type="hidden" id="location-lat" name="location-lat" value="<?= $data->location_lat?>">
										<input type="hidden" id="location-lng" name="location-lng" value="<?= $data->location_lng?>">
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
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.0-beta.2.rc.2/leaflet.js"></script> -->
<script type="text/javascript" src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" >

<script src="https://unpkg.com/esri-leaflet@2.2.3/dist/esri-leaflet.js" integrity="sha512-YZ6b5bXRVwipfqul5krehD9qlbJzc6KOGXYsDjU9HHXW2gK57xmWl2gU6nAegiErAqFXhygKIsWPKbjLPXVb2g==" crossorigin=""></script>
<link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.css" integrity="sha512-v5YmWLm8KqAAmg5808pETiccEohtt8rPVMGQ1jA6jqkWVydV5Cuz3nJ9fQ7ittSxvuqsvI9RSGfVoKPaAJZ/AQ==" crossorigin="">
<script src="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.js" integrity="sha512-zdT4Pc2tIrc6uoYly2Wp8jh6EPEWaveqqD3sT0lf5yei19BC1WulGuh5CesB0ldBKZieKGD7Qyf/G0jdSe016A==" crossorigin=""></script>

<script type="text/javascript">
	function format1(n,decimal,currency) {
	  return currency + n.toFixed(decimal).replace(/./g, function(c, i, a) {
	    return i > 0 && c !== "," && (a.length - i) % 3 === 0 ? "." + c : c;
	  });
	}

	var map,marker,geocodeService;

	function cb(data){
		console.log(data);
		$("#address").val(data.display_name);
	}

	function getaddres(marker){
   		$("#location-lat").val(marker[0]);
   		$("#location-lng").val(marker[1]);
  		geocodeService.reverse().latlng(marker).run(function(error, result) {  			
  			$("#address").val(result.address.Match_addr);
		});
	}
	
	function initMaps(center){
		console.log(center);
		map = L.map('map').setView(center, 15);
		L.tileLayer(
		  'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		    maxZoom: 18
		  }).addTo(map);
		marker = L.marker(center).addTo(map);
		//getaddres(center);
		map.on('click', function(e) {        
		    var popLocation= [e.latlng.lat,e.latlng.lng]; 
		    map.removeLayer(marker);
		    marker = L.marker(popLocation).addTo(map); 
		    getaddres(popLocation);   
		});
	}
	// get location using the Geolocation interface
	var geoLocationOptions = {
	  enableHighAccuracy: true,
	  timeout: 10000,
	  maximumAge: 0
	}

	function success(position) {
	  	myLat = position.coords.latitude.toFixed(6);
	  	myLng = position.coords.longitude.toFixed(6);
	  	latLng = [myLat, myLng];
	  	console.log('success');
	  	initMaps(latLng);
	}

	function error(err) {
		var center = [-6.2819487,106.6613594];
		console.log('error');
		initMaps(center);
	  	console.warn(`ERROR(${err.code}): ${err.message}`)
	}

	$(document).ready(function() {
		//MAPS
		
		initMaps([<?= $data->location_lat?>,<?= $data->location_lng?>]);

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

		var prices = <?= $prices[0] ?>;
		var state = 'total';
		function count_total(){
			fuel_total = $( "#fuel-total" ).val();
			if($( "#fuel-total" ).val()=='')
				fuel_total = 0;
			var total = parseFloat(prices) * parseFloat(fuel_total);
			
			$( "#fuel-total" ).val(fuel_total);
			$("#pay-label").val(format1(total,0,""));
			$("#pay").val(total);	
		}

		$( "#fuel-total" ).keyup(function( event ) {
			if(state == 'total'){
				if($( "#fuel-total" ).val()<1 && $( "#fuel-total" ).val()!='' ){
					$( "#fuel-total" ).val("1");
				}
				count_total()	
			}
			
		});
		
		function count_money(){
			var price = parseFloat(prices)
			money_total = $( "#pay-label" ).val();
			money_total = Number(money_total.replace(/[^0-9\,-]+/g,""));
			console.log()
			if($( "#pay-label" ).val()=='')
				money_total = 0;

			if(money_total) {
				var fuel_total = money_total / price;
				fuel_total = fuel_total.toFixed(2);
			} else {
				var fuel_total = 0;
			}
			$("#fuel-total").val(fuel_total);
			$("#pay-label").val(format1(money_total,0,""));
			$("#pay").val(total);
		}

		$("#pay-label" ).keyup(function( event ) {			
			if(state == 'money'){
				if($( "#pay-label" ).val()<1 && $( "#pay-label" ).val()!='' ){
					$( "#pay-label" ).val("1");				
				}
				count_money()	
			}
		});


		<?php
		$js_array = json_encode($prices);
		
		echo "var allprices = ". $js_array . ";\n";
		?>
		$("#fuel-type").change(function() {
			var index = $(this).children('option:selected').index();
			var price = allprices[index];
			$( "#price" ).val( format1(price,0,"") );
			prices = price;
			if(state == 'money'){
				count_money();
			} else {
				count_total();
			}
		});

		$("#buy-by").change(function() {
			var index = $(this).children('option:selected').index();
			if(index == 1){
				state = 'money';
				$("#pay-label").attr("readonly", false); 
				$("#fuel-total").attr("readonly", true);
				count_money();
			} else {
				state = 'total';
				$("#pay-label").attr("readonly", true); 
				$("#fuel-total").attr("readonly", false);
				count_total();
			}
		});

		$("#btnDriver").click(function(){
			lng = $( "#location-lng" ).val();
			lat = $( "#location-lat" ).val();
			fuel = $( "#fuel-type" ).val();
			$.ajax({
	           type: "POST",
	           url: "<?= base_url()?>transaction/searchcar",
	           data:{'location-lng':lng,'location-lat':lat,'fuel-type':fuel}, // serializes the form's elements.
	           success: function(data){
	            	console.log(data); // show response from the php script.
	            	if(data.status){
	            		$("#sector-name").val(data.sector);
	            		$("#driver-name").val("["+data.driver_code+"] "+ data.driver_name);
	            		$("#car-name").val(data.vehicle_number + " - " + data.tank +" L");
	            		$("#sector").val(data.sector);
	            		$("#driver").val(data.iddriver);
	            		$("#car").val(data.idcar);
	            	} else {
	            		$("#sector-name").val(data.sector);
	            		$("#driver-name").val(" - ");
	            		$("#car-name").val(" - ");
	            		$("#sector").val("");
	            		$("#driver").val("");
	            		$("#car").val("");
	            	}
	           }
	        });	
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

	});

</script>