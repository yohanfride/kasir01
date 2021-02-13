<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Personalize Customer's Data</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
                                <a href="<?= base_url()?>statistic">
                                    <i class="link-icon icon-chart"></i>
                                </a>
                            </li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Personalize Customer's Data</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Customer Data List</h4>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>ID</th>
													<th>Name</th>
													<th>KTP</th>
													<th>Email</th>
													<th>Phone</th>
													<th style="width: 10%">Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>ID</th>
													<th>Name</th>
													<th>KTP</th>
													<th>Email</th>
													<th>Phone</th>
													<th>Action</th>
												</tr>
											</tfoot>
											<tbody>
												<?php foreach ($data as $d) { $id=number_format($d->customer_id,0,'',''); ?>
												<tr>
													<td><?= $id ?></td>
													<td><?= $d->name ?></td>
													<td><?= $d->ktp ?></td>
													<td><?= $d->email ?></td>
													<td><?= $d->phone ?></td>
													<td>
														<div class="form-button-action">
															<button type="button" data-toggle="tooltip" data-placement="top" title="" class="btn btn-link btn-danger" data-original-title="Personalize Customer's Data"  style="padding: .375rem .75rem;">
																<a href="<?= base_url();?>statistic/personalcostumer/<?= $id; ?>" >
																<i class="fas fa-chart-bar"></i>
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
		$('[data-toggle="tooltip"]').tooltip({
		   container: 'body'
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