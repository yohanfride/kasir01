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
								<a href="#">Sector</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Sector Data List</h4>
										<a href="<?= base_url()?>sector/cretegeojson/" class="ml-auto"><button class="btn btn-secondary btn-round ml-auto">
											<i class="fa fa-map"></i>
											Create File Geojson
										</button></a>

										<a href="<?= base_url()?>sector/add/" class="ml-3"><button class="btn btn-primary btn-round ml-auto">
											<i class="fa fa-plus"></i>
											Add New Sector
										</button></a>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>ID</th>
													<th>Sector</th>
													<th>Group</th>
													<th>Date Update</th>
													<th>Type</th>
													<th>Status</th>
													<th style="width: 5%">Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>ID</th>
													<th>Sector</th>
													<th>Group</th>
													<th>Date Update</th>
													<th>Type</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</tfoot>
											<tbody>
												<?php foreach ($data as $d) { $id=number_format($d->sector_id,0,'',''); ?>
												<tr>
													<td><?= $id ?></td>
													<td><?= $d->sector ?></td>
													<td><?= $d->group ?></td>
													<td><?= date("Y-m-d", strtotime($d->date_update)) ?></td>
													<td><?= ($d->type == '-')?"Polygon":"MultiPolygon" ?></td>
													<td>
														<?php if($d->status == 0){ ?>
														<span class="text-warning pl-3">Not Active</span>
	                                                    <?php } else if($d->status == 1){ ?>
	                                                    <span class="text-success pl-3">Active</span>
	                                                    <?php }  ?>
													</td>
													<td>
														<div class="form-button-action">
															<a href="<?= base_url();?>sector/edit/<?= $id; ?>"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary" style="padding-left: 10px; padding-right: 10px;" data-original-title="Edit Data">
																<i class="fa fa-edit"></i>
															</button></a>
															<button type="button" data-toggle="tooltip" title="" class="btn  btn-link btn-danger" data-original-title="Remove" style="padding-left: 10px; padding-right: 10px;">
																<a href="<?= base_url();?>sector/delete/<?= $id; ?>"  class="btn-delete">
																<i class="fa fa-times"></i>
																</a>
															</button>
														</div>
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
<?php include("footer.php") ?>
	
	<script type="text/javascript">
	$(document).ready(function() {
		$('#add-row').DataTable({
			});
		//Notify
		<?php if($success){ ?>
		$.notify({
			icon: 'flaticon-success',
			title: 'Success',
			message: "<?= $success; ?>",
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
			message: "<?= $error; ?>",
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