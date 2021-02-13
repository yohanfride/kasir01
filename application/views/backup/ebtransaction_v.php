<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Payment Transaction</h4>
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
								<a href="#">Transaction List</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-8">
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
										<a href="<?= base_url()?>ebtransaction/time/" class="ml-auto"><button class="btn btn-secondary btn-round ml-auto">
											<i class="fa fa-clock"></i>
											Time Payment Data
										</button></a>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th width="15%">Date</th>
													<th>Transaction Code</th>
													<th>Customer</th>
													<th>Account</th>
													<th>Debit</th>
													<th>Credit</th>
													<th>Information</th>
													<!-- <th style="width: 10%">Action</th> -->
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Date</th>
													<th>Transaction Code</th>
													<th>Customer</th>
													<th>Account</th>
													<th>Debit</th>
													<th>Credit</th>
													<th>Information</th>
													<!-- <th>Action</th> -->
												</tr>
											</tfoot>
											<tbody>
												<?php foreach ($data as $d) { $id=number_format($d->id,0,'',''); ?>
												<tr>
													<td><?= date("Y-m-d", strtotime($d->date_add)) ?></td>
													<td><?= $d->transaction_code ?></td>
													<td><?= $d->customer->name ?></td>
													<td><?= $d->account ?></td>
													<td><?= number_format($d->debit,0,',','.'); ?></td>
													<td><?= number_format($d->credit,0,',','.'); ?></td>
													<td><?= $d->information ?></td>
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