<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Driver</h4>
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
								<a href="<?= base_url()?>driver">Driver</a>
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
						<div class="col-md-12">
							<form  method="post" action="" enctype="multipart/form-data">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Form - Edit Driver Data</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="name">Name</label>
												<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required="required" value="<?= $data->name?>">
											</div>
											<div class="form-group">
												<label for="driver-code">Driver ID</label>
												<input type="text" class="form-control" id="driver-code" name="driver_code" placeholder="Enter Driver ID" required="required" value="<?= $data->driver_code?>">										
											</div>
											<div class="form-group">
												<label for="email">Email</label>
												<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required="required"  value="<?= $data->email?>">
											</div>
											<div class="form-group">
												<label for="phone">Phone</label>
												<input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone" required="required" value="<?= $data->phone?>">
											</div>
											<div class="form-group">
												<label for="phone">NIN (KTP)</label>
												<input type="text" class="form-control" id="ktp" name="ktp" placeholder="Enter NIN" required="required" value="<?= $data->ktp?>">
											</div>
											<div class="form-group">
												<label for="model">Driver's License (SIM)</label>
												<input type="text" class="form-control" id="sim" name="sim" placeholder="Enter Driver's License" required="required" value="<?= $data->sim?>">
											</div>
											<div class="form-group">
												<label for="body-machine">Birth</label>
												<input type="text" class="form-control" id="datepicker" data-name="birth" name="birth" placeholder="Enter Birth" required="required" value="<?= $data->birth?>" >
											</div>
											<div class="form-check">
												<label>Gender</label><br>
												<label class="form-radio-label">
													<input class="form-radio-input" type="radio" name="gender" value="male" <?php if($data->gender == "male") echo ' checked="" '; ?> >
													<span class="form-radio-sign">Male</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio" name="gender" value="female" <?php if($data->gender == "female") echo ' checked="" '; ?>   >
													<span class="form-radio-sign">Female</span>
												</label>
											</div>
											<div class="form-group">
												<label for="address">Address</label>
												<textarea class="form-control" id="address" name="address" rows="2"><?= $data->address?></textarea>
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="model">Driver Photo</label>
												<div class="input-file input-file-image" >
													<?php if($data->photo){ ?>
													<img class="img-responsive img-upload-preview" style="max-height: 300px;" src="<?= $this->config->item('url_node').'driverphoto/'.$data->photo ?>" >
													<?php } else { ?>
													<img class="img-upload-preview" width="200" height="250" src="http://placehold.it/200x250" alt="preview">
													<?php }  ?>
													<input type="file" class="form-control form-control-file" id="uploadImg2" name="photo" accept="image/*" >
													<label for="uploadImg2" class="btn btn-black btn-sm left">
														<span class="btn-label">
															<i class="fa fa-file-image"></i>
														</span>
														Upload - Photo/Image
													</label>
												</div>
											</div>
											<div class="form-group">
												<a href="<?= base_url()?>driver/resetpass/<?= number_format($data->driver_id,0,'','')?>"><button type="button" class="btn btn-warning  left">
													<span class="btn-label">
														<i class="fa fa-lock"></i>
													</span>
													Reset Driver Password 
												</button></a>
											</div>
										</div>
									</div>
								</div>
								<div class="card-action">
									<button class="btn btn-success" name="save" value="save">Submit</button>
									<a href="<?= base_url()?>driver"><button type="button" class="btn btn-danger">Cancel</button></a>
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

	$('#datepicker').datetimepicker({
		    format: 'YYYY-MM-DD'
		});
</script>