<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Sector</h4>
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
								<a href="<?= base_url()?>sector">Sector</a>
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
							<form  method="post" action="">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Form - Edit Sector Data</div>
								</div>
								
								<div class="card-body">
									<div class="row">
										<div class="col-md-12 col-lg-6">
											<div class="form-group">
												<label for="sector">Sector</label>
												<input type="text" class="form-control" id="sector" name="sector" placeholder="Enter Sector" required="required" value="<?= $data->sector ?>">
											</div>
											<div class="form-group">
												<label for="group">Group</label>
												<input type="text" class="form-control" id="group" name="group" placeholder="Enter Group" required="required" value="<?= $data->group ?>">
											</div>
											<div class="form-group">
												<label for="city">City</label>
												<input type="text" class="form-control" id="city" name="city" placeholder="Enter City" required="required" value="<?= $data->city ?>">
											</div>
											<div class="form-group">
												<label for="province">Province</label>
												<input type="text" class="form-control" id="province" name="province" placeholder="Enter Province" required="required" value="<?= $data->province ?>">
											</div>
										</div>
										<div class="col-md-12 col-lg-6">
											<div class="form-group">
												<label for="type">Type</label>
												<select class="form-control" id="type" name="type">
													<option value="-" <?= ($data->type=='-')?'selected':''; ?> >Polygon</option>
													<option value="multipolygon" <?= ($data->type=='multipolygon')?'selected':''; ?> >Multipolygon</option>
												</select>
											</div>
											<div class="form-group">
												<label for="coordinates">Coordinates from GeoJSON</label>
												<textarea class="form-control" id="coordinates" name="coordinates" rows="9"><?= $data->coordinates ?></textarea>
											</div>
											<div class="form-check" >
												<label class="form-check-label">
													<input class="form-check-input" id="finish" type="checkbox" name="active" value="true" <?= ($data->status ==  1)?"checked":""; ?> >
													<span class="form-check-sign">Sector Active</span>
												</label>
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
</script>