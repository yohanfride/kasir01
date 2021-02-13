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
								<a href="#">Maintenance</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<form  method="get" action="">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Serch By Date</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="body-machine">Start</label>
												<input type="text" class="form-control datepicker" data-name="str" name="str" placeholder="Enter Birth" required="required" value="<?= $str_date?>" >
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="body-machine">End</label>
												<input type="text" class="form-control datepicker" data-name="end" name="end" placeholder="Enter Birth" required="required" value="<?= $end_date?>" >
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group" style="padding-top:35px;">
												<button class="btn btn-primary" type="submit">Search</button>
											</div>
										</div>
									</div>
								</div>								
							</div>
							</form>
						</div>
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Maintenance Data List</h4>
										<a href="<?= base_url()?>maintenance/add/" class="ml-auto"><button class="btn btn-primary btn-round ml-auto">
											<i class="fa fa-plus"></i>
											Add New Maintenance
										</button></a>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Date Add</th>
													<th>Car</th>
													<th>PIC</th>
													<!-- <th>Maintenance Start</th>
													<th>Maintenance Finish</th>
													<th>Location</th> -->
													<th>Cost</th>
													<th>Status</th>
													<th style="width: 10%">Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Date Add</th>
													<th>Car</th>
													<th>PIC</th>
													<!-- <th>Maintenance Start</th>
													<th>Maintenance Finish</th>
													<th>Location</th> -->
													<th>Cost</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</tfoot>
											<tbody>
												<?php foreach ($data as $d) { $id=number_format($d->maintenance_id,0,'',''); ?>
												<tr>
													<td><?= date("Y-m-d H:i:s", strtotime($d->date_add)) ?></td>
													<td><?= $d->car->vehicle_number ?></td>
													<td><?= $d->pic ?></td>
													<!-- <td><?= date("Y-m-d", strtotime($d->date_start)) ?></td>
													<td><?= date("Y-m-d", strtotime($d->date_finish)) ?></td>
													<td><?= $d->maintenance_location ?></td> -->
													<td><?= number_format($d->cost,0,',','.'); ?></td>
													<td>
														<?php if($d->status == 0){ ?>
														<span class="text-warning pl-3">On Maintenance</span>
	                                                    <?php } else if($d->status == 1){ ?>
	                                                    <span class="text-success pl-3">Done</span>
	                                                    <?php }  ?>
													</td>
													<td>
														<div class="form-button-action">
															<a href="<?= base_url();?>maintenance/edit/<?= $id; ?>"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Data">
																<i class="fa fa-edit"></i>
															</button></a>
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
																<a href="<?= base_url();?>maintenance/delete/<?= $id; ?>"  class="btn-delete">
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

		
		$('.datepicker').datetimepicker({
		    format: 'YYYY-MM-DD'
		});

	});
</script>