                <?php foreach ($data as $d) { ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-img-top" height="100">
                                <img class="img-responsive" src="<?=base_url('').'assets/upload/menu/'.$d->foto?>" alt="Card image cap">
                            </div>
                            <div class="card-body">
                                <h4 class="font-normal"><?= $d->menu ?></h4>
                                <p class="m-b-0 m-t-10">Rp. <?= number_format($d->harga,0,',','.');  ?></p>
                                <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20" onclick="tambah_menu(<?= $d->idmenu; ?>)"> <i class="fa fa-plus"></i> Tambah</button>
                            </div>
                        </div>
                    </div>
                <?php } ?>