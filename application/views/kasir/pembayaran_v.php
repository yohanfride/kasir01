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
         <li class="nav-item" >
            <a href="<?= base_url();?>kasir/profil" >
            <i class="la la-user"></i><span class="menu-title" data-i18n="nav.changelog.main">Ubah Profil</span>
            </a>
         </li>
         <li class="nav-item" >
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
         <li class="nav-item">
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
          <h3 class="content-header-title">Pembayaran | No. Faktur: <?= $transaksi->faktur; ?></h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url()?>">Kasir</a>
                </li>
                <li class="breadcrumb-item active">Pembayaran
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <a href="<?= base_url()?>"><button class="btn btn-info box-shadow-2 px-2 float-md-right mb-1"  type="button" ><i class="ft-arrow-left icon-left"></i> Kembali</button></a>
        </div>
      </div>
      <div class="content-body row">
         <div class="col-md-6 order-md-2 mb-4">
            <div class="card">
               <div class="card-content">
                  <div class="card-body">
                     <form id="frm-cart" method="post" action="<?= base_url();?>kasir/pembayaran_ajax" >
                        <h4 class="mb-1">Informasi Transkasi</h4>
                        <div class="row">
                           <div class="col-md-6 mb-1">
                              <label for="firstName">No. Meja</label>
                              <input type="text" class="form-control" id="meja" placeholder="" value="<?= $transaksi->meja?>" name="meja">
                           </div>
                        </div>
                        <div class="">
                           <label for="username">Catatan</label>
                           <textarea id="catatan" rows="4" class="form-control" name="catatan" placeholder="catatan"><?= $transaksi->catatan?></textarea>
                        </div>
                        <hr class="mt-1 mb-1">
                        <h4 class="mb-1">Pembayaran</h4>
                        <div class="mb-1">
                            <label for="bayar">Total Transaksi</label>
                            <input type="text" class="form-control uang" id="input-total" name='total'>
                        </div>
                        <div class="mb-1">
                           <label for="bayar">Jumlah Bayar</label>
                           <div class="input-group">                                
                              <input type="text" class="form-control uang" id="bayar" name='bayar'>
                              <div class="input-group-prepend">
                                 <span class="input-group-text" onclick="gettotal()">Sesuai Total</span>
                              </div>
                           </div>
                        </div>
                        <div class="mb-1 row">
                            <div class="col-md-6 mb-1">
                              <label for="kembali">Kembali </label>
                              <input type="text" class="form-control uang" name="kembali" id="kembali" readonly>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="metode_bayar">Metode Bayar</label>
                                <select class="form-control" id="metode_bayar" name="metode_bayar" >
                                    <option value="CASH">CASH</option>
                                    <option value="ovo">OVO</option>
                                    <option value="dana">DANA</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden"  name="real_total" id="input-real-total">
                        <hr class="mb-1 ">
                        <button class="btn btn-info btn-lg float-right mb-1" type="submit" id="btn-bayar" ><i class="ft ft-check-circle"></i> Proses Pembayaran</button>
                        <button class="btn btn-success btn-lg float-right mb-1" type="button" id="btn-cetak" style="display: none;" ><i class="ft ft-printer"></i> Cetak Struk</button>
                     </form>
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
                           <h6 class="my-0"><?= $value->nama ?> x <?= number_format($value->jumlah,0,',','.');  ?></h6>
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
                        <input type="hidden" id="total-true" value="<?= $total; ?>">
                     </li>
                  </ul>
               </div>
            </div>
         </div>   
      </div>
   </div>
</div>
<?php include('footer_v.php'); ?>
<script src="<?= base_url()?>assets/js/jquery.mask.min.js"></script>
<script src="<?= base_url()?>assets/plugins/sweetalert/sweetalert.min.js"></script>
<script src="<?= base_url()?>assets/plugins/sweetalert/jquery.sweet-alert.custom.js"></script>
<script>
    Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator) {
      var n = this,
          decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
          decSeparator = decSeparator == undefined ? "." : decSeparator,
          thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
          sign = n < 0 ? "-" : "",
          i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
          j = (j = i.length) > 3 ? j % 3 : 0;
      return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
    };
   $(document).ready(function() {
        $("#input-total").val($("#total-true").val());
        $("#input-real-total").val($("#total-true").val());
        $( '.uang' ).mask('000.000.000.000.000', {reverse: true});
        $("#frm-cart").submit(function(e) {
            var bayar = $("#bayar").val();
            var total = $("#input-total").val();
            var bayar = (bayar.replaceAll('.', ""));
            var total = (total.replaceAll('.', ""));
            var kembali = bayar - total;
            if(total == 0){
                swal('Total Transkasi Kosong','Masukkan jumlah total transaksi','warning');
                return false;
            } else if(kembali<0){
                swal('Pembayaran Kurang','Jumlah pembayaran kurang dari total transaksi','warning');
                return false;
            } else {
                swal('Apakah Transkasi Sudah Benar?',"Transkasi yang disimpan tidak dapat dibatalkan!",'warning',{
                  closeOnEsc:false,
                  closeOnClickOutside:false,
                  buttons: {
                   cancel: "Tidak",
                   confirm: {
                     text: "Ya, Lanjutkan",
                     value: "ya",
                   }
                  },
                }).then((value) => { 
                    if(value == 'ya'){
                        swal('Tunggu Sebentar..!','Proses sedang berjalan..',{
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                            closeModal:false,
                            buttons:false  
                        });
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
                                var res = JSON.parse(hasil);
                                if(res.status){
                                  $("#btn-cetak").css("display",'block');
                                  $("#btn-bayar").css("display",'none');

                                  ajax_print('<?= base_url()?>cetak/ajax_transkasi/<?= $transaksi->faktur; ?>')
                                } else {
                                  swal('Pembayaran Gagal','Proses pembayaran gagal dilakukan','warning');
                                }
                            }
                        }); 
                    }
                });
            }
            e.preventDefault();
        });
        $("#bayar").keyup(function(){
            var bayar = $("#bayar").val();
            var total = $("#input-total").val();
            var bayar = (bayar.replaceAll('.', ""));
            var total = (total.replaceAll('.', ""));
            var kembali = bayar - total;
            $("#kembali").val(kembali.formatMoney(0,'.',','));
        });
        $("#btn-cetak").click(function(){
          ajax_print('<?= base_url()?>cetak/ajax_transkasi/<?= $transaksi->faktur; ?>');
        });
   });
   function gettotal(){
      var total = $("#input-total").val();
      total = (total.replaceAll('.', ""));
      total = parseInt(total);
      total = total.formatMoney(0,'.',',');
      $("#bayar").val(total);
      $("#bayar").keyup();
   }

   function ajax_print(url) {
        swal('Pembayaran Berhasil','Sistem akan mencetak struk secara otomatis','success',{
            closeOnClickOutside: false,
            closeOnEsc: false,
            closeModal:false,
            buttons:false  
        });
        $.get(url, function (data) {
            window.location.href = data;
            setTimeout(function(){ 
              swal('Proses Cetak Berhasil','Proses percetakan berhasil dilakukan','success');
              window.location.href = '<?= base_url()?>';  // main action
            }, 5000);
        }).fail(function () {
            swal('Proses Cetak Gagal','Proses percetakan gagal dilakukan','warning');
            alert("ajax error");
        });
    }
</script>