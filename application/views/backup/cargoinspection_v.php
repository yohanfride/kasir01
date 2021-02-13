<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Cargo Inspection</h4>
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
								<a href="#">Cargo Inspection</a>
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
										<h4 class="card-title">Cargo Inspection Data List</h4>
										<a href="<?= base_url()?>cargoinspection/add/" class="ml-auto"><button class="btn btn-primary btn-round ml-auto">
											<i class="fa fa-plus"></i>
											Add New Cargo Inspection
										</button></a>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th style="width: 15%">Date Add</th>
													<th style="width: 10%">Car</th>
													<th style="width: 15%">Note</th>
													<th style="width: 10%">Action</th>

													<th style="width: 5%">Tank</th>
													<th style="width: 5%">ATG</th>
													<th style="width: 5%">Flow Meter</th>
													<th style="width: 5%">Pump</th>
													<th style="width: 5%">Power System</th>
													<th style="width: 5%">Pipeline</th>
													<th style="width: 5%">Hose</th>
													<th style="width: 5%">Box</th>
												</tr>											
											</thead>
											<tfoot>
												<tr>
													<th>Date Add</th>
													<th>Car</th>
													<th>Note</th>
													<th>Action</th>
													<th>Tank</th>
													<th>ATG</th>
													<th>Flow Meter</th>
													<th>Pump</th>
													<th>Power System</th>
													<th>Pipeline</th>
													<th>Hose</th>
													<th>Box</th>
												</tr>
											</tfoot>
											<tbody>
												<?php foreach ($data as $d) { $id=number_format($d->cargo_inspection_id,0,'',''); ?>
												<tr>
													<td class="text-nowrap"><?= date("Y-m-d H:i:s", strtotime($d->date_add)) ?></td>
													<td class="text-nowrap"><?= $d->car->vehicle_number ?></td>
													<td style="min-width: 120px;"><?= $d->note ?></td>
													<td>
														<div class="form-button-action">
															<a href="<?= base_url();?>cargoinspection/edit/<?= $id; ?>">
																<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary" style="padding-left: 10px; padding-right: 10px;" data-original-title="Edit Data">
																	<i class="fa fa-edit"></i>
																</button>
															</a>
															<a href="<?= base_url();?>cargoinspection/delete/<?= $id; ?>"  class="btn-delete">
																<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove" style="padding-left: 10px; padding-right: 10px;">
																	
																	<i class="fa fa-times"></i>
																</button>
															</a>
														</div>
													</td>
													<td>
														<?php if($d->tank == 0){ ?>
														<span class="text-warning pl-3">Not Check</span>
	                                                    <?php } else if($d->tank == 1){ ?>
	                                                    <span class="text-success pl-3">Good</span>
	                                                    <?php } else if($d->tank == 2){ ?>
	                                                    <span class="text-danger pl-3">Bad</span>
	                                                    <?php }  ?>
													</td>
													<td>
														<?php if($d->atg == 0){ ?>
														<span class="text-warning pl-3">Not Check</span>
	                                                    <?php } else if($d->atg == 1){ ?>
	                                                    <span class="text-success pl-3">Good</span>
	                                                    <?php } else if($d->atg == 2){ ?>
	                                                    <span class="text-danger pl-3">Bad</span>
	                                                    <?php }  ?>
													</td>
													<td>
														<?php if($d->flow_meter == 0){ ?>
														<span class="text-warning pl-3">Not Check</span>
	                                                    <?php } else if($d->flow_meter == 1){ ?>
	                                                    <span class="text-success pl-3">Good</span>
	                                                    <?php } else if($d->flow_meter == 2){ ?>
	                                                    <span class="text-danger pl-3">Bad</span>
	                                                    <?php }  ?>
													</td>
													<td>
														<?php if($d->pump == 0){ ?>
														<span class="text-warning pl-3">Not Check</span>
	                                                    <?php } else if($d->pump == 1){ ?>
	                                                    <span class="text-success pl-3">Good</span>
	                                                    <?php } else if($d->pump == 2){ ?>
	                                                    <span class="text-danger pl-3">Bad</span>
	                                                    <?php }  ?>
													</td>
													<td>
														<?php if($d->power_system == 0){ ?>
														<span class="text-warning pl-3">Not Check</span>
	                                                    <?php } else if($d->power_system == 1){ ?>
	                                                    <span class="text-success pl-3">Good</span>
	                                                    <?php } else if($d->power_system == 2){ ?>
	                                                    <span class="text-danger pl-3">Bad</span>
	                                                    <?php }  ?>
													</td>
													<td>
														<?php if($d->pipeline == 0){ ?>
														<span class="text-warning pl-3">Not Check</span>
	                                                    <?php } else if($d->pipeline == 1){ ?>
	                                                    <span class="text-success pl-3">Good</span>
	                                                    <?php } else if($d->pipeline == 2){ ?>
	                                                    <span class="text-danger pl-3">Bad</span>
	                                                    <?php }  ?>
													</td>
													<td>
														<?php if($d->hose == 0){ ?>
														<span class="text-warning pl-3">Not Check</span>
	                                                    <?php } else if($d->hose == 1){ ?>
	                                                    <span class="text-success pl-3">Good</span>
	                                                    <?php } else if($d->hose == 2){ ?>
	                                                    <span class="text-danger pl-3">Bad</span>
	                                                    <?php }  ?>
													</td>
													<td>
														<?php if($d->box == 0){ ?>
														<span class="text-warning pl-3">Not Check</span>
	                                                    <?php } else if($d->box == 1){ ?>
	                                                    <span class="text-success pl-3">Good</span>
	                                                    <?php } else if($d->box == 2){ ?>
	                                                    <span class="text-danger pl-3">Bad</span>
	                                                    <?php }  ?>
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