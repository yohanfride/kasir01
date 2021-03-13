<?php include("header.php") ?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Tambah Pembelian Bahan</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url()?>">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url()?>pembelian<?= (!empty($params))?'/?'.$params:''; ?>">Pembelian</a></li>
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
    
    <div class="col-md-12 col-lg-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title m-b-10">Detail Transkasi Pembelian</h3>
                <?php if($error){ ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                        <h3 class="text-danger"><i class="fa fa-exclamation-triangle"></i> Perhatian</h3> <?= $error?>
                    </div>
                    <?php } ?>
                    <?php if($success){ ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                        <h3 class="text-success"><i class="fa fa-check"></i> Sukses</h3> <?= $success?>
                    </div>
                <?php } ?>
                <form method="post" class="form-material" onsubmit="return cek();">
                    <div class="form-body">
                        <div class="form-group">
                            <label for="faktur">No. Faktur</label>
                            <input type="text" class="form-control" id="faktur" name="faktur" placeholder="Masukkan No. Faktur Pembelian" required="required">
                        </div>
                        <div class="form-group">
                            <label for="date-format" class="control-label">Tanggal Pembelian (Berdasarkan Faktur)</label>
                            <input type="text" class="form-control frm-ajax" id="date-format" name="tanggal" placeholder="Masukkan Tanggal Pembelian">
                        </div>
                        <div class="form-group">
                            <label for="biaya">Biaya Tambahan</label>
                            <input type="text" class="form-control uang" id="biaya" name="biaya" placeholder="" value="0"  placeholder="Masukkan Biaya Tambahan" inputmode="numeric">
                        </div>
                        <div class="form-group">
                            <label for="total">Total Biaya</label>
                            <input type="text" class="form-control uang" id="total" name="total" placeholder="" required="required" value="0" readonly>
                        </div>
                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea class="form-control" rows="3" id="catatan" name="catatan" ></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success" name="save" value="save"> <i class="fa fa-check"></i> Simpan</button>
                        <a href="<?= base_url("pembelian") ?><?= (!empty($params))?'/?'.$params:''; ?>" id="btnbatal"><button type="button" class="btn btn-inverse">Batalkan</button></a>
                    </div>
                    <input type="hidden" name="item" id="input-item">
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center">
                    <h3 class="card-title">Daftar Bahan</h3>
                    <a href="#" class="ml-auto" onclick="tambahbahan()"><button class="btn btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Tambah Bahan
                    </button></a>
                </div>
                <div class="table-responsive dataTables_wrapper m-t-40">                    
                    <table class="display table" >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Bahan</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="list-bahan">
                            <input type="hidden" id="total-pembelian" value="0">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <button id="btnmodal" alt="default" data-toggle="modal" data-target="#responsive-modal" class="model_img img-responsive" style="display: none;" ></button>
    <div id="responsive-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;"> <!-- tabindex="-1"  -->
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-tambah" onsubmit="return false;" method="post" class="form-material" >
                    <div class="modal-header">
                        <h4 id="modal-title">Tambah Item Pembelian</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="notif-danger" class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                            <h3 class="text-danger"><i class="fa fa-exclamation-triangle"></i> Perhatian</h3> <span id="error-msg"></span>
                        </div>
                        <div id="notif-success"  class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                            <h3 class="text-success"><i class="fa fa-check"></i> Sukses</h3> <span id="success-msg"></span>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Bahan</label>
                            <select class="select2 form-control custom-select" name="bahan" id="bahan" style="width: 100%; height:36px;">
                                <?php foreach ($bahan as $d) { ?>
                                <option value="<?= $d->idstok ?>" id="bahan-<?= $d->idstok ?>" ><?= $d->nama ?> (<?= $d->satuan; ?>) </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">Jumlah</label>
                            <input type="text" class="form-control uang frm-ajax" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah Pembelian" required="required" inputmode="numeric">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">Harga Pembelian (Total Semua Item)</label>
                            <input type="text" class="form-control uang frm-ajax" id="harga" name="harga" placeholder="Masukkan Harga Pembelian Total" required="required" inputmode="numeric">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success frm-ajax waves-effect waves-light"><i class="fa fa-check"></i> Simpan</button>
                        <button id="btn-close" type="button" class="btn btn-inverse frm-ajax waves-effect" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php include("footer.php") ?>
<!-- Plugin JavaScript -->
<script src="<?= base_url();?>assets/plugins/moment/moment.js"></script>
<script src="<?= base_url();?>assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<!-- Clock Plugin JavaScript -->
<script src="<?= base_url();?>assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
<!-- Color Picker Plugin JavaScript -->
<script src="<?= base_url();?>assets/plugins/jquery-asColorPicker-master/libs/jquery-asColor.js"></script>
<script src="<?= base_url();?>assets/plugins/jquery-asColorPicker-master/libs/jquery-asGradient.js"></script>
<script src="<?= base_url();?>assets/plugins/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
<!-- Date Picker Plugin JavaScript -->
<script src="<?= base_url();?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- Date range Plugin JavaScript -->
<script src="<?= base_url();?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?= base_url();?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url(); ?>assets/js/jquery.mask.min.js"></script>

<script src="<?= base_url(); ?>assets/plugins/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
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
        $('#date-format').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
        $( '.uang' ).mask('000.000.000.000', {reverse: true});
        $(".select2").select2();
        $('.selectpicker').selectpicker();
        $("#date-format").val(moment(new Date()).format('YYYY-MM-DD'));
        $("#form-tambah").submit(function() {
            var item = $("#input-item").val();
            var key = $("#bahan").val();
            var additem = {'key':key,'harga':$("#harga").val(),'jumlah':$("#jumlah").val(),'nama':$("#bahan-"+key).html()};
            if(item == ''){
                var item = []; 
            } else {
                var item = JSON.parse(item);
            }
            item.push(additem);
            tampilItem(item);
            $("#btnmodal").click();
            return false;
        });

        $("#biaya").keyup(function(){
            hitungBiaya();
        });

        $("#btnbatal").click(function(){
            return confirm('Apakah anda yakin mebatalkan transaksi ini?');
        });
    });

    function cek(){
        var total = parseInt($("#total-pembelian").val());
        if(total == 0){
            swal({
                  type: 'warning',
                  title: 'Item Bahan Kosong',
                  text: 'Belum ada bahan yang dipilih',
                });
            return false;
        }
    }

    function tampilItem(item){
        $("#input-item").val(JSON.stringify(item));
        var itemtable = "";
        var total = 0;
        for(var i=0; i<item.length; i++){
            console.log(item[i]);
            var jumlah = parseInt(item[i]['jumlah'].replaceAll('.', ""));
            var harga = parseInt(item[i]['harga'].replaceAll('.', ""));
            total+=harga;
            rowitem ="<tr>"+
            '<td>'+(i+1)+'</td>'+
            '<td>'+item[i]['nama']+'</td>'+
            '<td>'+Number((jumlah).toFixed(1)).toLocaleString()+'</td>'+
            '<td> Rp. '+Number((harga).toFixed(1)).toLocaleString()+'</td>'+
            '<td><a href="#" onclick="hapusbahan('+i+')" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger"></i> </a></td>'+
            '</tr>'
            itemtable+=rowitem;  
        }
        rowitem = "<tr style='font-weight: 400;'>"+
        '<td colspan="3" class="text-right"> <b class="m-r-10">Total Pembelian : </b> </td>'+
        '<td colspan="2" class="text-right"> <b class="m-r-20">Rp. '+Number((total).toFixed(1)).toLocaleString()+'</b><td>'+
        "<tr>"+
        '<input type="hidden" id="total-pembelian" value="'+total+'">';
        itemtable+=rowitem;  
        $("#list-bahan").html(itemtable);
        hitungBiaya();
    }

    function notif(tipe,msg){
        $("#notif-danger").hide();
        $("#notif-success").hide();
        if(tipe == 'error'){
            $("#error-msg").html(msg);
            $("#notif-danger").show();
        } else if(tipe == 'success'){
            $("#success-msg").html(msg);
            $("#notif-success").show();
        }
    }

    function hitungBiaya(){
        var biaya = $("#biaya").val();
        var total = parseInt($("#total-pembelian").val());
        var biaya = (biaya.replaceAll('.', ""));
        if(biaya == ''){
            biaya = 0;
        }
        var total = total + parseInt(biaya);
        $("#total").val(total.formatMoney(0,'.',','));
    }

    function tambahbahan(){
        notif('','');
        $("#bahan").prop("selectedIndex", 0);
        $("#jumlah").val("");
        $("#detail").val("");
        $("#harga").val("");
        $("#btnmodal").click();
    }
    function hapusbahan(id){
        var item = $("#input-item").val();
        if(item == ''){
            var item = []; 
        } else {
            var item = JSON.parse(item);
        }
        item.splice(id, 1);
        tampilItem(item);
    }
</script>
