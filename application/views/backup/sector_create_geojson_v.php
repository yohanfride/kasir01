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
								<a href="#">Create File GeoJSON</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-8 col-lg-6">
							<form  method="post" action="">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Form - Create File GeoJSON By Group</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-12 col-lg-12">
											<div class="form-group">
												<label for="group">Group</label>
												<select class="form-control" id="group" name="group" required="">
													<?php
													if(empty($group_current)) $group_current = '';
													foreach ($group_list as $d) { ?>
													<option value="<?= $d->group ?>" <?php if($d->group ==  $group_current) echo "selected" ?>><?= $d->group ?></option>
													<?php } ?>
												</select>
											</div>
											<?php if($success){ ?>
											<div class="form-group">
												<label for="model">Your GeoJSON Link</label>
												<a href="<?= $link_backend.'maps/'.$filename.'.geojson' ?>" target="_blank" class="fw-bold text-lowercase text-success op-8"><?= $link_backend.'maps/'.$filename.'.geojson' ?></a>
											</div>
											<?php } ?>
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