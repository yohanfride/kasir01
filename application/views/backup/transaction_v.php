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
								<a href="#">Transaction</a>
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
										<h4 class="card-title">Transaction Data List</h4>
										<a href="<?= base_url()?>transaction/time/" class="ml-auto"><button class="btn btn-secondary btn-round ml-auto">
											<i class="fa fa-clock"></i>
											Time Refueling Data
										</button></a>
										<a href="<?= base_url()?>transaction/add/" class="ml-2"><button class="btn btn-primary btn-round ml-auto">
											<i class="fa fa-plus"></i>
											Add New Transaction
										</button></a>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Date</th>
													<th>Transaction Code</th>
													<th>Customer</th>
													<th>Driver</th>
													<th>Car</th>
													<th>Total</th>
													<th>Order Status</th>
													<th>Pay Status</th>
													<th style="width: 10%">Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Date</th>
													<th>Transaction Code</th>
													<th>Customer</th>
													<th>Driver</th>
													<th>Car</th>
													<th>Total</th>
													<th>Order Status</th>
													<th>Pay Status</th>
													<th>Action</th>
												</tr>
											</tfoot>
											<tbody>
												<?php foreach ($data as $d) { $id=number_format($d->transaction_id,0,'',''); ?>
												<tr>
													<td class="text-nowrap"><?= date("Y-m-d H:i:s", strtotime($d->date_add)) ?></td>
													<td><?= $d->transaction_code ?></td>
													<td class="text-nowrap"><?= $d->customer->name ?></td>
													<td class="text-nowrap"><?= $d->driver->name ?></td>
													<td class="text-nowrap"><?= $d->car->vehicle_number ?></td>
													<td><?= number_format($d->pay,0,',','.'); ?></td>
													<td>
														<?php if($d->status == 0){ ?>
														<span class="text-warning pl-3">In Order List</span>
	                                                    <?php } else if($d->status == 1 || $d->status == 5){ ?>
	                                                    <span class="text-success pl-3">Transaction Succes</span>
	                                                    <?php } else if($d->status == 2){ ?>
	                                                    <span class="text-info pl-3">Driver On The Way</span>
	                                                    <?php } else if($d->status == 3){ ?>
	                                                    <span class="text-secondary pl-3">Driver On Location</span>
	                                                    <?php } else if($d->status == 4){ ?>
	                                                    <span class="text-primary pl-3">Transaction Start</span>
	                                                    <?php } else if($d->status == 6){ ?>
	                                                    <span class="text-danger pl-3">Cancel by Driver</span>
	                                                    <?php } else if($d->status == 7){ ?>
	                                                    <span class="text-danger pl-3">Cancel by Customer</span>
	                                                    <?php }  ?>
													</td>
													<td>
														<?php if($d->status == 1 || $d->status == 5){ ?>
	                                                    <span class="text-success pl-3">Paid</span>
	                                                    <?php } else { ?>
														<span class="text-warning pl-3">Not Paid</span>
	                                                    <?php }  ?>
													</td>
													<td>
														<div class="form-button-action" style="margin-left: -20px;">
															<?php if($d->status == 0){ ?>
															<a href="<?= base_url();?>transaction/paid/<?= $id; ?>"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success btn-lg" data-original-title="Manual Pay Order" style="padding: .375rem .75rem;">
																<i class="fa fa-money-check-alt"></i>
															</button></a>
		                                                    <?php } ?>
		                                                    <button type="button" data-toggle="tooltip" title="" class="btn btn-link " data-original-title="Detail" style="padding: .375rem .75rem;">
																<a href="<?= base_url();?>transaction/detail/<?= $id; ?>">
																<i class="fa fa-search"></i>
																</a>
															</button>
															<?php  if($user_now->role == 'god-admin'){ ?>
															<a href="<?= base_url();?>transaction/edit/<?= $id; ?>"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Data" style="padding: .375rem .75rem;">
																<i class="fa fa-edit"></i>
															</button></a>
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove" style="padding: .375rem .75rem;">
																<a href="<?= base_url();?>transaction/delete/<?= $id; ?>"  class="btn-delete">
																<i class="fa fa-times"></i>
																</a>
															</button>
															<?php } ?>
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