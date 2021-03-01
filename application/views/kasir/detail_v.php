<?php include('header_v.php') ?>
<div class="navbar-container content">
   <div class="collapse navbar-collapse" id="navbar-mobile">
      <ul class="nav navbar-nav mr-auto float-left">
         <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
      </ul>
      <ul class="nav navbar-nav float-right">
         <li class="dropdown dropdown-user nav-item">
            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown" aria-expanded="false"><i class="ficon ft-user"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
               <a class="dropdown-item" href="<?= base_url()?>kasir/profil"><i class="ft-user"></i> Ganti Profil</a>
               <a class="dropdown-item" href="<?= base_url()?>kasir/setting"><i class="ft-lock"></i> Ganti Password</a>
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
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow " data-scroll-to-active="true">
   <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
         <li class="navigation-header">
            <span data-i18n="nav.category.layouts">Manajemen Profil</span><i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Manajemen Profil"></i>
         </li>
         <li class="nav-item " >
            <a href="<?= base_url();?>kasir/profil" >
            <i class="la la-user"></i><span class="menu-title" data-i18n="nav.changelog.main">Ubah Profil</span>
            </a>
         </li>
         <li class="nav-item " >
            <a href="<?= base_url();?>kasir/setting" >
            <i class="la la-lock"></i><span class="menu-title" data-i18n="nav.changelog.main">Ubah Password</span>
            </a>
         </li>
         <li class="navigation-header">
            <span data-i18n="nav.category.layouts">Manajemen Transaksi</span><i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Manajemen Transaksi"></i>
         </li>
         <li class="nav-item">
            <a href="<?= base_url();?>kasir/" >
            <i class="la la-shopping-cart"></i><span class="menu-title" data-i18n="nav.changelog.main">Kasir</span>
            </a>
         </li>
         <li class="nav-item active">
            <a href="<?= base_url();?>kasir/riwayat" >
            <i class="la la-calendar"></i><span class="menu-title" data-i18n="nav.changelog.main">Riwayat Transkasi</span>
            </a>
         </li>
      </ul>
   </div>
</div>
<div class="app-content content">
   <div class="content-wrapper">
      <div class="content-header row">
         <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Riwayat Transaksi</h3>
            <div class="row breadcrumbs-top">
               <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="<?= base_url()?>">Kasir</a></li>
                     <li class="breadcrumb-item"><a href="<?= base_url()?>kasir/riwayat">Riwayat Transaksi</a></li>
                     <li class="breadcrumb-item active">Detail</li>
                  </ol>
               </div>
            </div>
         </div>
         <div class="content-header-right col-md-6 col-12">
            <a href="<?= base_url()?>riwayat"><button class="btn btn-info box-shadow-2 px-2 float-md-right mb-1"  type="button" ><i class="ft-arrow-left icon-left"></i> Kembali</button></a>
         </div>
      	</div>
      	<div class="content-body row">
        	<div class="col-md-12">
        		<div class="card">
		            <div class="card-content">
		               <div class="card-body">
		                  <div class="row justify-content-around lh-condensed">
		                     <div class="order-details text-center col-md-3 col-6 mb-1 mt-1">
		                        <div class="order-title">No. Faktur</div>
		                        <div class="order-info"><?= $transaksi->faktur?></div>
		                     </div>
		                     <div class="order-details text-center col-md-3 col-6 mb-1 mt-1">
		                        <div class="order-title">Tanggal & Waktu</div>
		                        <div class="order-info"><?= date_format(date_create($transaksi->date_add), 'd-m-Y H:i'); ?></div>
		                     </div>
		                     <div class="order-details text-center col-md-3 col-6 mb-1 mt-1">
		                        <div class="order-title">Total Transaksi</div>
		                        <div class="order-info">Rp. <?= number_format($transaksi->total,0,',','.');  ?></div>
		                     </div>
		                     <div class="order-details text-center col-md-3 col-6 mb-1 mt-1">
		                        <div class="order-title">Metode Pembayaran</div>
		                        <div class="order-info"><?= $transaksi->metode_bayar ?></div>
		                     </div>
		                  </div>
		               </div>
		            </div>
	         	</div>
        	</div>
        	<div class="col-md-6 order-md-2 mb-4">
	            <div class="card">
	               <div class="card-header">
	                  <h4 class="card-title">Item Pembelian</h4>
	               </div>
	               <div class="card-content">
	                  <ul class="list-group mb-1">
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
	                     <li class="list-group-item d-flex justify-content-between lh-condensed">
	                        <div>
	                           <h6 class="my-0"><?= $value->menu ?> x <?= number_format($value->jumlah,0,',','.');  ?></h6>
	                           <small class="text-muted"><strong>Rp. <?= number_format($value->harga,0,',','.');  ?></strong></small>
	                        </div>
	                        <span class="text-muted">Rp. <?= number_format($value->harga * $value->jumlah,0,',','.');  ?></span>
	                     </li>
	                     <?php } ?>

	                     <li class="list-group-item d-flex justify-content-between">
	                        <span class="product-name"><strong>Subtotal</strong></span>
	                        <span class="product-price"><strong>Rp. <?= number_format($total,0,',','.');  ?></strong></span>
	                     </li>
	                     <li class="list-group-item d-flex justify-content-between">
	                        <span class="product-name success" style="font-size: 16px;">Total Pembayaran</span>
	                        <span class="product-price">Rp. <?= number_format($total,0,',','.');  ?></span>
	                        <input type="hidden" id="total" value="<?= $total; ?>">
	                     </li>
	                  </ul>
	               </div>
	            </div>
	        </div>
	        <div class="col-md-6 order-md-2 mb-4">
	            <div class="card">
	               <div class="card-header">
	                  <h4 class="card-title">Detail Pembelian</h4>
	               </div>
	               <div class="card-content">
	                  	<ul class="list-group mb-1">
	                    	<li class="list-group-item d-flex justify-content-between lh-condensed">
		                        <div>
		                           <span class="product-name"><strong>Nama Pelanggan</strong></span>
		                        </div>
		                        <span class="text-muted"><?= $transaksi->order_by?></span>
	                     	</li>
	                     	<li class="list-group-item d-flex justify-content-between lh-condensed">
		                        <div>
		                           <span class="product-name"><strong>Catatan</strong></span>
		                        </div>
		                        <span class="text-muted"><?= $transaksi->catatan?></span>
	                     	</li>
		                    <li class="list-group-item d-flex justify-content-between">
		                        <span class="product-name success" style="font-size: 16px;">Jumlah Pembayaran</span>
		                        <span class="product-price">Rp. <?= number_format($transaksi->bayar,0,',','.');  ?></span>
		                    </li>
		                    <li class="list-group-item d-flex justify-content-between">
		                        <span class="product-name success" style="font-size: 16px;">Kembali</span>
		                        <span class="product-price">Rp. <?= number_format($transaksi->bayar - $transaksi->total,0,',','.');  ?></span>
		                    </li>
		                    <li class="list-group-item justify-content-between">
		                        <button class="btn btn-success btn-lg mb-1 float-right" type="button" onclick="ajax_print('<?= $transaksi->faktur;?>')" ><i class="ft ft-printer"></i> Cetak Struk</button>
		                    </li>
	                  	</ul>
	               </div>
	            </div>
	         </div>
      	</div>
   </div>
</div>
<?php include('footer_v.php'); ?>
<script src="<?= base_url()?>assets/plugins/sweetalert/sweetalert.min.js"></script>
<script src="<?= base_url()?>assets/plugins/sweetalert/jquery.sweet-alert.custom.js"></script>
<script>
   function ajax_print(faktur) {
      var url ='<?= base_url(); ?>cetak/ajax_transkasi/'+faktur;
        swal('Proses Cetak','Sistem akan mencetak struk secara otomatis','success',{
            closeOnClickOutside: false,
            closeOnEsc: false,
            closeModal:false,
            buttons:false  
        });
        $.get(url, function (data) {
            window.location.href = data;
            setTimeout(function(){ 
              swal('Proses Cetak Berhasil','Proses percetakan berhasil dilakukan','success');
            }, 3000);
        }).fail(function () {
            swal('Proses Cetak Gagal','Proses percetakan gagal dilakukan','warning');
            alert("ajax error");
        });
    }
</script>