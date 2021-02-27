<?php include('header_v.php') ?>

            <div class="navbar-container content">
               <div class="collapse navbar-collapse" id="navbar-mobile">
                  <ul class="nav navbar-nav mr-auto float-left">
                     <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
                     <!-- <li class="nav-item d-none d-lg-block"><a class="nav-link " href="#" onclick="toggleFullscreen()"><i class="ficon ft-maximize"></i></a></li> -->
                     <li class="nav-item nav-search">
                        <form id="frm-cari" method="post" action="<?= base_url('')?>kasir/api_menu" >
                        <a class="nav-link nav-link-search" href="#"><i class="ficon ft-search"></i></a>
                        <div class="search-input d-flex">
                           <input class="input mb-1" type="text" name="s" placeholder="Tuliskan Nama Menu" >
                           <button type="submit" class="btn btn-primary ml-1 mb-1"> Cari </button>
                           <input id="kategori" name="kategori" type="hidden">
                        </div>
                        </form>
                     </li>
                  </ul>
                  <ul class="nav navbar-nav float-right">
                     <li class="d-none d-md-block">
                        <h3 class="white mr-1 mt-2 bold">Daftar Menu: <?= $toko->nama_toko; ?></h3>
                     </li>
                     <li class="dropdown dropdown-notification nav-item">
                       <a class="nav-link nav-link-label customizer-toggle" href="#" data-toggle="dropdown" aria-expanded="false"><i class="ficon ft-shopping-cart"></i>
                         <span id="cart-count" class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow">
                            <?= (isset($transaksi->item_penjualan))?count($transaksi->item_penjualan):'0';  ?>
                         </span>
                       </a>
                     </li>
                     <li class="dropdown dropdown-user nav-item">
                        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown" aria-expanded="false"><i class="ficon ft-user"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                           <a class="dropdown-item" href="<?= base_url()?>kasir/profil"><i class="ft-user"></i> Ubah Profil</a>
                           <a class="dropdown-item" href="<?= base_url()?>kasir/setting"><i class="ft-lock"></i> Ubah Password</a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="<?= base_url()?>kasir"><i class="ft-shopping-cart"></i> Kasir</a>
                           <a class="dropdown-item" href="<?= base_url()?>kasir/riwayat"><i class="ft-calendar"></i> Riwayat Transkasi</a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="<?= base_url()?>auth/logout"><i class="ft-power"></i> Keluar</a>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </nav>
      <!-- ////////////////////////////////////////////////////////////////////////////-->
      <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
         <div class="main-menu-content">
            
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
               <li class="navigation-header">
                  <span data-i18n="nav.category.layouts">Kategori Menu</span><i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Kategori Menu"></i>
               </li>
               <li class="active nav-item" id="kategori-">
                  <a href="#" onclick="kategori();" >
                     <i class="la la la-th"></i><span class="menu-title" data-i18n="nav.changelog.main">Semua Kategori</span>
                  </a>
               </li> 
               <?php foreach ($kategori as $d) { ?>
               <li class=" nav-item" id="kategori-<?= $d->idkategori?>">
                  <a href="#" onclick="kategori(<?= $d->idkategori?>);">
                     <i class="la la-th-large"></i><span class="menu-title" data-i18n="nav.changelog.main"><?= $d->kategori; ?></span><span class="badge badge badge-pill badge-warning float-right"><?= $d->total ?></span>
                  </a>
               </li>  
               <?php } ?>
            </ul>

         </div>
      </div>
      <div class="app-content content">
         <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">                  
               <div class="row match-height" id="listmenu" >
                  <?php foreach ($menu as $d) { ?>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                     <div class="card pull-up" style="height: 456.4px;">
                        <div class="card-content">
                           <div class="card-body">
                              <div class="product-img d-flex align-items-center">
                                 <img class="img-fluid" src="<?=base_url('').'assets/upload/menu/'.$d->foto?>" alt="Card image cap">
                              </div>
                              <h4 class="product-title"><?= $d->menu ?></h4>
                              <div class="price-reviews">
                                 <span class="price-box">
                                    <span class="price">Rp. <?= number_format($d->harga,0,',','.');  ?></span>
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
               </div>
            </div>
         </div>
      </div>

      <!-- BEGIN: Customizer-->
      <div class="customizer border-left-blue-grey border-left-lighten-4 ">
         <a class="customizer-close" href="#"><i class="ft-x font-medium-3"></i></a>
         <div class="customizer-content p-2">
            <h4 class="text-uppercase mb-0"><b>Daftar Pesanan</b></h4>
            <hr>
            <h4 class="mt-1 mb-1 text-bold-500">Faktur Transaksi : <?= $transaksi->faktur; ?> </h4>
            <div id="list-result">
               <div class="table-responsive">
                  <table class="table table-borderless mb-0">
                     <thead>
                        <tr class="text-center">
                           <th>No.</th>
                           <th>Menu</th>
                           <th>Jumlah</th>
                           <th>Total</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                         $total = 0;
                         $jumlah = 0;
                         $no = 1;
                         if(isset($transaksi->item_penjualan))
                         foreach ($transaksi->item_penjualan as $key => $value) {
                             $value = (object) $value;
                             $total+= ( $value->harga * $value->jumlah );
                             $jumlah+=$value->jumlah;
                        ?>
                        <tr>
                           <td class="text-center list-no"><?= $no++; ?></td>
                           <td >
                              <div class="product-title"><?= $value->nama ?></div>
                              <div class="product-color"><strong>Rp. <?= number_format($value->harga,0,',','.');  ?></strong> </div>
                           </td>
                           <td  class="list-qty">
                              <div class="input-group bootstrap-touchspin">
                                 <?php if($value->jumlah == 1){ ?>
                                 <span onclick="kurangi_menu(<?= $key; ?>)" class="input-group-btn input-group-prepend bootstrap-touchspin-injected"><button class="btn btn-danger bootstrap-touchspin-down" type="button"><i class="la la-trash"></i></button></span>
                                 <?php } else { ?>
                                 <span onclick="kurangi_menu(<?= $key; ?>)" class="input-group-btn input-group-prepend bootstrap-touchspin-injected"><button class="btn btn-primary bootstrap-touchspin-down" type="button"><i class="la la-minus"></i></button></span>
                                 <?php } ?>  
                                 <input type="text" class="text-center count touchspin form-control" value="<?= number_format($value->jumlah,0,',','.');  ?>">

                                 <span onclick="tambah_menu(<?= $key; ?>)" class="input-group-btn input-group-append bootstrap-touchspin-injected"><button class="btn btn-primary bootstrap-touchspin-up" type="button"><i class="la la-plus"></i></button></span>
                              </div>
                           </td >
                           <td class="text-right text-middle list-price">
                              <div class="total-price"><b>Rp. <?= number_format($value->harga * $value->jumlah,0,',','.');  ?>  </b></div>
                           </td>
                        </tr>
                        <?php } ?>   
                     </tbody>
                  </table>
               </div>
               <div class="row">
                 <div class="col-12"><hr style="margin-top: 0.5rem; border-top: 2px solid rgba(0,0,0,.1); "></div>                    
                 <h4 class="col-7 text-center"><b>Total</b></h4>
                 <h4 class="col-5 text-right"><b>Rp. <span id="total" class="mr-1"><span id="total"><?= number_format($total,0,',','.');  ?></span></b></h4>
               </div>
            </div>
            

            <hr>
            <h4 class="mt-1 mb-1 text-bold-500"> Informasi Transkasi </h4>
            <form class="form" method="post" action="<?= base_url("")?>kasir/pembayaran">
               <div class="form-body">
                  <div class="form-group row">
                    <label class="col-md-12 label-control" for="catatan">Catatan</label>
                    <div class="col-md-12">
                      <textarea id="catatan" rows="4" class="form-control" name="catatan" placeholder="catatan"><?= $transaksi->catatan?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-12 label-control" for="meja">No. Meja</label>
                    <div class="col-md-12 ">
                      <input type="text" id="meja" class="form-control" placeholder="No. Meja Pelanggan" name="meja" value="<?= $transaksi->meja?>">
                    </div>
                  </div>
               </div>
               <div class="form-actions right mb-5">
                  <button type="submit" class="btn btn-success mr-2" name="save" value="save">
                    <i class="la la-check-square-o"></i> Proses Pembayaran
                  </button>
                  <a id="btnbatal" href="<?= base_url()?>kasir/batalkan"><button type="button" class="btn btn-danger " >
                    <i class="ft-x"></i> Batalkan Transkasi
                  </button></a>
                </div>
            </form>
            <!-- Nomor Meja -->
            <!-- Catatan -->
         </div>
      </div>
      <!-- End: Customizer-->

<?php include('footer_v.php'); ?>

<script>
    $(document).ready(function() {
         $("#cart-count").html('<?= $jumlah; ?>');
         $("#frm-cari").submit(function() {
            $.ajax({
                url: $(this).attr("action"),
                data: $(this).serialize(),
                type: $(this).attr("method"),
                dataType: 'html',
                beforeSend: function() {
                    $(".btn-ajax").attr("disabled", true);
                },
                complete: function() {
                    $(".btn-ajax").attr("disabled", false);
                },
                success: function(hasil) {
                   $("#listmenu").html(hasil); 
                    setTimeout(function(){
                        $('.row.match-height').each(function() {
                            $(this).find('.card').not('.card .card').matchHeight(); // Not .card .card prevents collapsible cards from taking height
                        });
                    },100);
                }
            });    
            return false;
         });

        $("#btnbatal").click(function(){
            return confirm('Apakah anda yakin membatalkan transaksi ini?');
        });
    });

    function kategori(id){
      $(".nav-item").removeClass('active');
      $("#kategori-"+id).addClass('active');
      $("#kategori").val(id);
      $("#frm-cari").submit();
      console.log(id);
    }

    function tambah_menu(id){
        $.ajax({
            url: '<?= base_url()?>kasir/api_tambah_menu/'+id,
            type: 'post',
            success: function(hasil) {
               $("#list-result").html(hasil); 
            }
        });    
    }

    function kurangi_menu(id){
        $.ajax({
            url: '<?= base_url()?>kasir/api_kurang_menu/'+id,
            type: 'post',
            success: function(hasil) {
               $("#list-result").html(hasil); 
            }
        });    
    }
    
    </script>
