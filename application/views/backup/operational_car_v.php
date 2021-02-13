<?php include("header.php") ?>				
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Active Car</h4>
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
								<a href="#">Active Car</a>
							</li>
						</ul>
					</div>
					<div class="row row-projects">
						<?php foreach ($car as $d) { $id=number_format($d->car->car_id,0,'',''); 
							if(!isset($car_income[$id])){
								$car_income[$id] = (object) array(
									'total_income' => 0, 
									'total_item' => 0, 
									'total_fuel' => 0, 
								);
							} 
						?>

						<div class="col-sm-6 col-lg-3">
							<div id="card-car-<?= $id?>" class="card <?php if($d->car->emergency_alert){ echo 'emergency-card';} ?> ">
								<div class="p-2">
									<div class="">
										
										<img class="card-img-top rounded" src=" <?= base_url().'assets/img/default-car.png';  ?>"  alt="Product 1"> <!-- style="max-height: 142px;" -->
									</div>
									<div class="card-danger p-1"><h4 class="mb-1 fw-bold text-center"><?= $d->car->vehicle_number; ?></h4></div>
								</div>
								<div class="card-body pt-2">
									<p class="text-muted  mb-1 text-center"><b>Driver</b>: <?= $d->driver->name; ?> </p>
									<!-- <p class="text-muted  mb-1 text-center"><b>Total KM</b>: <?= number_format($d->car->total_km,2,',','.'); ?> KM </p> -->
									<div class="separator-dashed"></div>
									<p class="text-muted  mb-1 text-center">
										<b>Tank </b>: <span id="tank-<?= $d->car->device_id?>"> <?= number_format($d->car->tank,0,',','.'); ?> </span> <span>L </span>
										<?php if(!empty($temp[number_format($d->car->car_id,0,'','')])){ ?>
										<b class="text-danger">( <?= number_format($temp[number_format($d->car->car_id,0,'','')][0],2,',','.'); ?> &#8451;)</b>
										<?php } ?>
										<input type="hidden" id="capacity-<?= $d->car->device_id?>" value="<?= $d->car->capacity?>">
									</p>
									<p class="text-muted  mb-1 text-center">
										<b>Temperature </b>: <span id="temp-<?= $d->car->device_id?>"><?= number_format($d->car->atg_temp,0,',','.'); ?> </span> <span>&#8451;</span>
									</p>
									<div class="separator-dashed"></div>
									<p class="text-muted mb-1 text-center "><b>Transaction</b> : <?= number_format($car_income[$id]->total_item,0,',','.')?> items </p>
									<p class="text-muted mb-1 text-center"> Rp. <?= number_format($car_income[$id]->total_income,0,',','.')?> | <?= number_format($car_income[$id]->total_fuel,0,',','.')?>L </p>
									<?php if($d->car->emergency_alert){ ?>
									<div class="separator-dashed"></div>
									<div class="card-danger mb-1"><p class="mb-1 fw-bold text-center">Emergency Condition</p></div>
									<?php } ?>
									<div class="separator-dashed"></div>
									<div style="text-align: center;">
									<button class="btn btn-warning margin-auto" onclick="sendalert(<?= $id?>,'tank')"><span class="btn-label"><i class="fas fa-bullhorn"></i></span>Send Warning Tank Stok</button>
									</div>		



									<div class="separator-dashed"></div>
									<?php if($d->car->geo_alert){ ?>
									<div class="card-danger mb-1"><p class="mb-1 fw-bold text-center">Out of Area</p></div>
									<div class="separator-dashed"></div>
									<div style="text-align: center;">
									<button class="btn btn-warning margin-auto" onclick="sendalert(<?= $id?>,'area')"><span class="btn-label"><i class="fas fa-bullhorn"></i></span>Send Warning Area</button>
									</div>
									<?php } else { ?>
									<p class="text-muted mb-1 text-center">
										<span class="text-success">In Area </span>
									</p>
									<?php } ?>
									
									<!-- <div class="separator-dashed"></div>
									<?php if($d->car->speed_limit_alert){ ?>
									<div class="card-danger mb-1"><p class="mb-1 fw-bold text-center">Out of Speed Limit</p></div>
									<?php } else { ?>
									<p class="text-muted mb-1 text-center">
										<span class="text-success">Under Speed Limit </span>
									</p>
									<?php } ?>

									<?php  //} else if( $d->car->total_km >= $d->car->maintance_km ){ ?>
									<div class="card-danger mb-1"><p class="mb-1 fw-bold text-center">Must do Maintenance </p></div>
									<p class="mb-1 small text-center"> Out of Car Kilometers Limit </p>
						
									 -->
									<div class="separator-dashed"></div>
									<?php if( date('Y-m-d',strtotime($d->car->next_service_date)) <= date('Y-m-d') ){ ?>
									<div class="card-danger mb-1"><p class="mb-1 fw-bold text-center">Schedule Maintenance </p></div>
									<p class="mb-1 small text-center"> on <?= date('Y-m-d',strtotime($d->car->next_service_date))?> </p>
									<?php } else { ?>
									<p class="text-muted mb-1 text-center">
										<span class="text-success">No Schedule Maintenance </span>
									</p>
									<?php } ?>
									<div style="text-align: center; <?php if(!$d->car->emergency_alert){ echo 'display: none;';} ?>" id="btn-stop-sos-<?= $id?>">
										<div class="separator-dashed"></div>
										<button class="btn btn-danger margin-auto" onclick="trunof_sos(<?= $id?>)"><span class="btn-label"><i class="fas fa-power-off"></i></span>Turn Of Emergency Status</button>
									</div>																								
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
					<br/><br/>
					
					<div class="page-header">
						<h4 class="page-title">Driver Active</h4>
					</div>
					<div class="row row-projects">
						<?php foreach ($car as $d) { $id=number_format($d->car_driver_id,0,'',''); ?>
						<div class="col-sm-6 col-lg-3">
							<div class="card card-stats">
								<div class="p-2">
									<div class="icon-big icon-warning text-center pt-3 pb-3" style="font-size: 3.5em;">
										<i class="la flaticon-user-2"></i>
									</div>
									<div class="card-danger p-1 mt-1"><h4 class="mb-1 fw-bold text-center"><?= $d->driver->name; ?></h4></div>
								</div>
								<div class="card-body pt-2">
									<p class="text-muted  mb-1 text-center"><b>Phone</b>: <?= $d->driver->phone; ?> </p>
									<div class="separator-dashed"></div>
									<p class="text-muted  mb-1 text-center"><b>Car Vehicle Number</b>: <?= $d->car->vehicle_number; ?> </p>
									<div class="separator-dashed"></div>
									<div style="text-align: center;">
									<button class="btn btn-warning margin-auto" onclick="sendalert(<?= number_format($d->car_id,0,'','')?>,'condition')"><span class="btn-label"><i class="fas fa-bullhorn"></i></span>Send Warning Condition</button>
									</div>
								</div>
								
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
<?php include("footer.php") ?>			
<script src="<?= base_url()?>assets/js/mqttws31.js" type="text/javascript"></script>	
<script type="text/javascript">
	//--------------------------------------------///
	//////MQTT SETTING/////
	var mqtt;
    var reconnectTimeout = 2000,  host = '<?= $this->config->item('host_mqtt') ?>', port = <?= $this->config->item('port_mqtt') ?>, 
        topic_data = 'operational/data/sensor/', topic_alert='operational/emergencyalert/', topic_server = 'operational/server/'; 

    function format1(n,decimal,currency) {
	  return currency + n.toFixed(decimal).replace(/./g, function(c, i, a) {
	    return i > 0 && c !== "," && (a.length - i) % 3 === 0 ? "." + c : c;
	  });
	}

    function MQTTconnect() {
        mqtt = new Paho.MQTT.Client(
            host,
            port,
            "web_" + parseInt(Math.random() * 100, 10)
        );
        var options = {
            timeout: 3,
            // userName: "T0dSaE5USTVNekUxWWpZMFpXUmxOMkV3TmpJMk16ZzE=",
            // password: "aGRNRldER1RuZmJoZm94b1c3WVhVOEl3eUFoRmJE",    
            onSuccess: onConnect,
            onFailure: function (message) {
                console.log("Connection failed: " + message.errorMessage + "Retrying");
                setTimeout(MQTTconnect, reconnectTimeout);
            }
        };

        mqtt.onConnectionLost = onConnectionLost;
        mqtt.onMessageArrived = onMessageArrived;        
        console.log("Host="+ host + ", port=" + port);
        console.log(mqtt);
        //username_pw_set(username="OGRhNTI5MzE1YjY0ZWRlN2EwNjI2Mzg1",password="hdMFWDGTnfbhfoxoW7YXU8IwyAhFbD");
        mqtt.connect(options);
    }

	function onConnect() {
		mqtt.subscribe(topic_data, {qos: 0});
		mqtt.subscribe(topic_alert, {qos: 0});
		console.log("subscribe topic: "+topic_data);
	}

	function onConnectionLost(response) {
		setTimeout(MQTTconnect, reconnectTimeout);
		console.log("connection lost: " + responseObject.errorMessage + ". Reconnecting");
	};

	function onMessageArrived(message) {
		var topic = message.destinationName;
		var payload = message.payloadString;
		console.log(topic);
		console.log(payload);
		var message = JSON.parse(payload);
		if(topic == topic_alert){
			var vnumber = message.vehicle_number;
			var id = message.car_id;
			swal("Warning!", "Truck Vehicle Number "+vnumber+" in Emergency Status", {
				icon : "warning",
				buttons: {        			
					confirm: {
						className : 'btn btn-warning'
					}
				},
			});
			$("#card-car-"+id).addClass('emergency-card');
			$('#btn-stop-sos-'+id).removeAttr('style');
			$('#btn-stop-sos-'+id).css({'text-align':'center'}); 
		} else if(topic == topic_data){
			var id = message.device_code;
			var capacity = $("#capacity-"+id).val();
			var level = message.atg.level;
			var temperature = message.atg.temp;
			var fuel = level * capacity / 100;
			$("#tank-"+id).html(format1(fuel,0,""));
			$("#temp-"+id).html(format1(parseInt(temperature),0,""));
		}

	};

	function trunof_sos(id){
		$('#btn-stop-sos-'+id).css({'text-align':'center','display':'none'}); 
		$("#card-car-"+id).removeClass('emergency-card');
	}

	function sendalert(car_id,alert){
		if(alert == 'area'){
			var msgjson = '{"alert":"Area"}';
		} else if( alert == 'tank'){
			var msgjson = '{"alert":"Tank"}';
		} else if( alert == 'condition' ){
			var msgjson = '{"alert":"Condition"}';
		}
		message = new Paho.MQTT.Message(msgjson);
		message.destinationName = topic_server + car_id;
		console.log(message.destinationName);
		mqtt.send(message);
	}

	// swal({
	//     title: "Wow!",
	//     text: "Message!",
	//     type: "success"
	// }).then(function() {
	//     window.location = "redirectURL";
	// });

	//--------------------------------------------///
	$(document).ready(function() {
		MQTTconnect();
	});
</script>