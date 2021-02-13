<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Customer Car</h4>
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
								<a href="#">Customer Car</a>
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
								<a href="#">Customer Car</a>
							</li>
							<?php } ?>
							
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Car Data List</h4>
										<!-- <a href="<?= base_url()?>car/add/" class="ml-auto"><button class="btn btn-primary btn-round ml-auto">
											<i class="fa fa-plus"></i>
											Add New Car
										</button></a> -->
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>ID</th>
													<th>Vehicle Number</th>
													<th>Customer</th>
													<th>Brand</th>
													<th>Model</th>
													<th>Capacity</th>
													<th style="width: 10%">Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>ID</th>
													<th>Vehicle Number</th>
													<th>Customer</th>
													<th>Brand</th>
													<th>Model</th>
													<th>Capacity</th>
													<th>Action</th>
												</tr>
											</tfoot>
											<tbody>
												<?php foreach ($data as $d) { $id=number_format($d->customer_car_id,0,'',''); ?>
												<tr>
													<td><?= $id ?></td>
													<td><?= $d->vehicle_number ?></td>
													<td><?= $d->customer->name ?></td>
													<td><?= $d->brand ?></td>
													<td><?= $d->model ?></td>
													<td><?= number_format($d->fuel_tank_capacity,0,',','.') ?></td>
													<td>
														<div class="form-button-action">
															<a href="<?= base_url();?>customercar/<?= (isset($customer_id))?'customer/'.$customer_id.'/':'' ?>detail/<?= $id; ?>"><button type="button"  title="" class="btn btn-link btn-primary btn-lg" >
																<i class="fa fa-search"></i>
															</button></a>
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