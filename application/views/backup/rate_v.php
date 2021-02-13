<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Rate</h4>
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
								<a href="#">Rate</a>
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
										<h4 class="card-title">Rate Data List</h4>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Date Add</th>
													<th>Transaction Code</th>
													<th>Driver</th>
													<th>Customer</th>
													<th>Rate</th>
													<th>Note</th>
													<th style="width: 10%">Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Date Add</th>
													<th>Transaction Code</th>
													<th>Driver</th>
													<th>Customer</th>
													<th>Rate</th>
													<th>Note</th>
													<th>Action</th>
												</tr>
											</tfoot>
											<tbody>
												<?php foreach ($data as $d) { $id=number_format($d->rate_id,0,'',''); ?>
												<tr>
													<td class="text-nowrap"><?= date("Y-m-d H:i:s", strtotime($d->date_add)) ?></td>
													<td class="text-nowrap"><?= $d->transaction_code ?></td>
													<td class="text-nowrap">[<?= $d->driver->driver_code ?>] <?= $d->driver->name ?> </td>
													<td class="text-nowrap"><?= $d->customer->name ?></td>
													<td>
														<div class="avatar-xl mb-3 mt-3" style="margin: auto; display: block;">
															<img id="emoticon" src="<?= base_url();?>assets/img/emoticon-<?= $d->rate ?>.png" alt="..." class="avatar-img rounded-circle">
														</div>
													</td>
													<td><?= $d->comment ?></td>
													<td>
														<div class="form-button-action">
															<a href="<?= base_url();?>rate/detail/<?= $id ?>">
																<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary" style="padding-left: 10px; padding-right: 10px;" data-original-title="Detail Data">
																	<i class="fa fa-search"></i>
																</button>
															</a>
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