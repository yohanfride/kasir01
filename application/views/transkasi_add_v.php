<?php include("header.php") ?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Menu</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url()?>">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url()?>transaksi<?= (!empty($params))?'/?'.$params:''; ?>">Transaksi</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </div>
    <div>
        <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid row">
    <div class="col-sm-12 col-md-6 col-lg-8">
        <form id="frm-cari" method="post" action="<?= base_url('')?>transaksi/api_menu" class="form-material">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 col-sm-12">
                            <div class="form-group">
                                <label for="body-machine">Nama Menu</label>
                                <input type="text" class="form-control" data-name="s" name="s" placeholder="Tulis nama menu">
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <div class="form-group">
                                <label for="body-machine">Kategori</label>
                                <select class="form-control" id="kategori" name="kategori" >
                                    <option value="" style="color:#1976d2 !important;">Semua Kategori</option>
                                    <?php foreach ($kategori as $d) { ?>
                                    <option value="<?= $d->idkategori ?>"><?= $d->kategori ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <div class="form-group" style="padding-top:35px;">
                                <button class="btn btn-primary btn-ajax" type="submit"><i class="ti-search"></i> Cari</button>
                            </div>
                        </div>
                    </div>
                </div>                              
            </div>
        </form>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-themecolor m-b-20">Daftar Menu</h3>
                <div class="row" id="listmenu">
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
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="card" id="list-result">
            <div class="card-body">
                <h3 class="card-title text-themecolor m-b-20">Faktur : <?= $transaksi->faktur; ?> </h3>
                <div class="table-responsive" id="cart">
                    <table class="table m-b-0">
                        <thead>
                            <tr class="text-center">
                                <th>Menu</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total = 0;
                            if(isset($transaksi->item_penjualan))
                            foreach ($transaksi->item_penjualan as $key => $value) {
                                $value = (object) $value;
                                $total+= ( $value->harga * $value->jumlah );
                             ?>
                            <tr>
                                <td><b><?= $value->nama ?></b> <br/> Rp. <?= number_format($value->harga,0,',','.');  ?></td>
                                <td style="font-size: 20px;" class="text-center">
                                    <?php if($value->jumlah == 1){ ?>
                                    <a href="#" onclick="kurangi_menu(<?= $key; ?>)" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-minus-square text-danger"></i> </a> 
                                    <?php } else { ?>
                                    <a href="#" onclick="kurangi_menu(<?= $key; ?>)" data-toggle="tooltip" data-original-title="Kurangi"> <i class="fa fa-minus-square text-inverse"></i> </a> 
                                    <?php } ?>       
                                    <span class="m-l-3 m-r-4" style="width: 20px;"><b><?= number_format($value->jumlah,0,',','.');  ?></b></span>     
                                    <a href="#" onclick="tambah_menu(<?= $key; ?>)" data-toggle="tooltip" data-original-title="Tambah"> <i class="fa fa-plus-square text-inverse m-r-10"></i> </a>
                                </td>
                                <td class="text-right">
                                    <?= number_format($value->harga * $value->jumlah,0,',','.');  ?>                                    
                                </td>
                            </tr>
                            <?php } ?>   
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-12"><hr style="margin-top: 0.5rem; border-top: 2px solid rgba(0,0,0,.1); "></div>                    
                    <h4 class="col-7 text-center"><b>Total</b></h4>
                    <h4 class="col-5 text-right"><b>Rp. <span id="total"><?= number_format($total,0,',','.');  ?></span></b></h4>
                </div>
            </div>
        </div>
        <form id="frm-cart" method="post" class="form-material" >
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="body-machine">Jumlah Bayar</label>
                                <input type="text" class="form-control uang" id="bayar" name="bayar">
                            </div>
                            <div class="form-group">
                                <label for="body-machine">Kembali</label>
                                <input type="text" class="form-control uang" id="kembali" name="kembali" readonly="">
                            </div>
                            <div class="form-group">
                                <label for="name">Catatan</label>
                                <textarea class="form-control" rows="3" id="catatan" name="catatan" ></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="metode_bayar">Metode Bayar</label>
                                <select class="form-control" id="metode_bayar" name="metode_bayar" >
                                    <option value="CASH">CASH</option>
                                    <option value="ovo">OVO</option>
                                    <option value="dana">DANA</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="order_by">Nama Pelanggan</label>
                                <input type="text" class="form-control" id="order_by" name="order_by" placeholder="Nama Pelanggan">
                            </div>
                        </div>
                        <div class="col-md-12">                
                            <div class="form-group">
                                <button class="btn btn-success btn-block btn-ajax" name="save" value="save" type="submit"><i class="fa fa-check"></i> Simpan Transaksi</button>
                                <a href="<?= base_url()?>transaksi/batalkan" id="btnbatal" > <button class="btn btn-danger btn-block btn-ajax m-t-10" name="save" value="save" type="button"><i class="fa fa-close"></i> Batalkan Transaksi</button> </a>
                            </div> 
                            <input type="hidden" name="total" id="input-total">
                        </div>
                    </div>
                </div>                              
            </div>
        </form>
    </div>

<?php include("footer.php") ?>
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
        $( '.uang' ).mask('000.000.000.000.000', {reverse: true});
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
                }
            });    
            return false;
        });
        $("#frm-cart").submit(function() {
            var bayar = $("#bayar").val();
            var total = $("#total").html();
            var bayar = (bayar.replaceAll('.', ""));
            var total = (total.replaceAll('.', ""));
            var kembali = bayar - total;
            $("#input-total").val(total);
            if(total == 0){
                swal({
                  type: 'warning',
                  title: 'Menu Kosong',
                  text: 'Belum ada menu yang dipilih',
                });
                return false;
            } else if(kembali<0){
                swal({
                  type: 'warning',
                  title: 'Pembayaran Kurang',
                  text: 'Jumlah pembayaran kurang dari total transaksi'
                });
                return false;
            }
        });

        $("#bayar").keyup(function(){
            var bayar = $("#bayar").val();
            var total = $("#total").html();
            var bayar = (bayar.replaceAll('.', ""));
            var total = (total.replaceAll('.', ""));
            var kembali = bayar - total;
            $("#kembali").val(kembali.formatMoney(0,'.',','));
        });

        $("#btnbatal").click(function(){
            return confirm('Apakah anda yakin membatalkan transaksi ini?');
        });
    });

    function tambah_menu(id){
        $.ajax({
            url: '<?= base_url()?>transaksi/api_tambah_menu/'+id,
            type: 'post',
            success: function(hasil) {
               $("#list-result").html(hasil); 
            }
        });    
    }

    function kurangi_menu(id){
        $.ajax({
            url: '<?= base_url()?>transaksi/api_kurang_menu/'+id,
            type: 'post',
            success: function(hasil) {
               $("#list-result").html(hasil); 
            }
        });    
    }
    
    </script>
