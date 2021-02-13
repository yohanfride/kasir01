<?php include("header.php") ?>				
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Operational Service</h4>
					</div>
					<div class="row row-projects">
						<?php 
							$menu[] = (object)array( "color"=>'menu-car', "title"=>'Car / Truck', "link"=> base_url("").'truck', 'icon'=>'fas fa-truck');
							$menu[] = (object)array( "color"=>'menu-fuel', "title"=>'Active Car', "link"=> base_url("").'operational/active', 'icon'=>'fas fa-check-circle');
							$menu[] = (object)array( "color"=>'menu-cargo-inspection', "title"=>'Cargo Inspection', "link"=> base_url("").'cargoinspection', 'icon'=>'fa fa-clipboard-check');
							$menu[] = (object)array( "color"=>'menu-maintenance', "title"=>'Maintenance', "link"=> base_url("").'maintenance', 'icon'=>'fas fa-cogs');
						?>
						<?php foreach($menu as $m){ ?>
						<div class="col-lg-3 col-md-4 col-sm-6 col-6">
							<a href="<?= $m->link?>" class="block-menu">
							<div class="card <?= $m->color ?> card-annoucement card-round">
								<div class="card-body text-center">
									<div class="card-desc icon-menu-big">
										<i class="<?= $m->icon?>"></i>
									</div>
									<div class="card-opening admin-menu-title"><?= $m->title?></div>									
								</div>
							</div>
							</a>
						</div>
						<?php } ?>
					</div>
				</div>
<?php include("footer.php") ?>			


<!-- <div class="d-flex">
										<div class="avatar">
											<span class="avatar-title rounded-circle border border-white bg-danger"><span class="la flaticon-user-2"></span</span>
										</div>
										<div class="flex-1 pt-1 ml-2" style="align-items:center;">
											<h5 class="fw-bold mb-1"><?= $d->driver->name; ?></h5>
										</div>
									</div> -->