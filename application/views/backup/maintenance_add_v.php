<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Maintenance</h4>
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
								<a href="<?= base_url()?>maintenance">Maintenance</a>
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
									<div class="card-title">Form - Add New Maintenance Data</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="name">Car</label>
												<select class="form-control" id="car" name="car">
													<?php foreach ($car as $d) { $id=number_format($d->car_id,0,'',''); ?>
													<option value="<?= $id ?>"><?= $d->vehicle_number ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label for="name">Maintenance PIC </label>
												<input type="text" class="form-control" id="pic" name="pic" placeholder="Enter PIC Name " required="required">
											</div>
											<div class="form-group">
												<label for="body-machine">Maintenance Start Date </label>
												<input type="text" class="form-control datepicker"  data-name="date_start" name="date_start" placeholder="Enter Maintenance Start Date" required="required">
											</div>
											<div class="form-group" id="divEndDate" style="display: none">
												<label for="body-machine">Maintenance Finish Date </label>
												<input type="text" class="form-control datepicker" id="finish_date" data-name="date_finish" name="date_finish" placeholder="Enter Maintenance Start Date">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="model">Cost</label>
												<input type="number" class="form-control" id="cost" name="cost" placeholder="Enter Total Cost" value="0" required="required">
											</div>
											<div class="form-group">
												<label for="address">Note</label>
												<textarea class="form-control" id="note" name="note" rows="3"></textarea>
											</div>	
											<div class="form-check" >
												<label class="form-check-label">
													<input class="form-check-input" id="finish" type="checkbox" name="done" value="true">
													<span class="form-check-sign">Finish Maintenance</span>
												</label>
											</div>
											<div class="form-group" id="divNextDate" style="display: none">
												<label for="body-machine">Next Maintenance Date </label>
												<input type="text" class="form-control datepicker" id="date_next" data-name="date_next" name="date_next" placeholder="Enter Next Maintenance  Date" >
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
	});

	$('.datepicker').datetimepicker({
	    format: 'YYYY-MM-DD'
	});
    $("#divEndDate").hide();
	$("#finish").change(function() {
	    if(this.checked) {
	       	$("#divEndDate").removeAttr('style');
	       	$("#divNextDate").removeAttr('style');
            $("#divEndDate").show();
            $("#divNextDate").show();
            $("#finish_date").attr("required", true);
            $("#date_finish").attr("required", true);
	    } else{
            $("#divEndDate").hide();
            $("#divNextDate").hide();
	       	$("#finish_date").removeAttr('required');
	       	$("#date_finish").removeAttr('required');
	    }
	});
	$("#car").change(function(){
			id = $( "#car" ).val();
			$.ajax({
	           type: "POST",
	           url: "<?= base_url()?>maintenance/getcar/"+id,
	           success: function(data){
	            	if(data){
	            		$("#date_next").val(data);
	            	} else {
	            		$("#date_next").val("");
	            	}
	           }
	        });	
		});
	$("#car").change();
</script>