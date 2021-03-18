               <?php foreach ($menu as $d) { ?>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                     <div class="card pull-up">
                        <div class="card-content">
                           <div class="card-body">
                              <div class="product-img d-flex align-items-center">
                                 <?php if($d->diskon){ ?>
                                 <div class="badge badge-success round">-<?= $d->diskon; ?>%</div>
                                <?php } ?>
                                 <img class="img-fluid" src="<?=base_url('').'assets/upload/menu/'.$d->foto?>" alt="Card image cap">
                              </div>
                              <h4 class="product-title"><?= $d->menu ?></h4>
                              <div class="price-reviews">
                                 <span class="price-box">
                                    <?php if($d->diskon){ ?>
                                      <span class="price">Rp. <?= number_format($d->harga - ($d->harga * $d->diskon / 100),0,',','.');  ?></span>
                                      <span class="old-price">Rp. <?= number_format($d->harga,0,',','.');  ?></span>
                                    <?php } else { ?>
                                      <span class="price">Rp. <?= number_format($d->harga,0,',','.');  ?></span>
                                    <?php } ?>
                                 </span>
                              </div>
                           </div>
                           <div class="btn-add">
                              <button onclick="tambah_menu(<?= $d->idmenu; ?>);" class="btn btn-float btn-round float-right mr-1 btn-float btn-success"><i class="la la-plus"></i></button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php } ?>