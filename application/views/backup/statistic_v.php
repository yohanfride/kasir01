<?php include("header.php") ?>				
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Statistic</h4>
					</div>
					<div class="row row-projects">
						<?php
							$menu = array();
							$menu[] = (object)array( "color"=>'menu-transaction', "title"=>'Fuel Cosumption Behaviour ', "link"=> base_url("").'statistic/fuelcosumption', 'icon'=>'icon-map');
							$menu[] = (object)array( "color"=>'menu-transaction', "title"=>'Daily of Fuel Sales and Remain Onboard ', "link"=> base_url("").'statistic/dailyfuelsalesboard', 'icon'=>'icon-map');
							$menu[] = (object)array( "color"=>'menu-transaction', "title"=>"Personalize Customer's Data ", "link"=> base_url("").'statistic/personalcostumer', 'icon'=>'icon-user');
							$menu[] = (object)array( "color"=>'menu-transaction', "title"=>"Volumes on Daily Tank of Each-Car", "link"=> base_url("").'statistic/dailytankcar', 'icon'=>'fas fa-truck');
							$menu[] = (object)array( "color"=>'menu-transaction', "title"=>"Maintenance Cost", "link"=> base_url("").'statistic/maintenancecost', 'icon'=>'icon-settings');
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
