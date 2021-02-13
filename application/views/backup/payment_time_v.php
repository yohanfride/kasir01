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
								<a href="<?= base_url()?>ebtransaction">Payment Transaction</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Time Payment</a>
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
										<h4 class="card-title">Payment Transaction Data List</h4>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Transaction Code</th>
													<th>Date Add</th>
													<th>Customer</th>
													<th>Start Payment</th>
													<th>Finish Payment</th>
													<th>Duration</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Transaction Code</th>
													<th>Date Add</th>
													<th>Take Order</th>
													<th>Driver On Location</th>
													<th>Start Transaction</th>
													<th>Finish Transaction</th>
												</tr>
											</tfoot>
											<tbody>
												<?php foreach ($data as $d) { $id=number_format($d->transaction_id,0,'',''); ?>
												<tr>
													<td><?= $d->transaction_code ?></td>
													<td><?= date("Y-m-d H:i:s", strtotime($d->date_add)) ?></td>
													<td class="text-nowrap"><?= $d->customer->name ?></td>
													<td class="text-nowrap"><?= ($d->date_create_payment)?date("Y-m-d H:i:s", strtotime($d->date_create_payment)):'-' ?></td>
													<td class="text-nowrap"><?= ($d->date_payment_finish)?date("Y-m-d H:i:s", strtotime($d->date_payment_finish)):'-' ?></td>
													<td class="text-nowrap"><?=  ($d->date_create_payment && $d->date_payment_finish )?( strtotime($d->date_payment_finish) - strtotime($d->date_create_payment) ):'-'; ?>s</td>
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