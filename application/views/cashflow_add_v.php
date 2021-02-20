<?php include("header.php") ?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Cashflow</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url()?>">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url()?>cashflow<?= (!empty($params))?'/?'.$params:''; ?>">Cashflow</a></li>
            <li class="breadcrumb-item active">Tambah Cashflow</li>
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
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-8">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Form Tambah Data Cashflow Baru</h4>
                </div>
                <div class="card-body">
                    <form method="post" class="form-material" enctype="multipart/form-data">
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
                        <div class="form-body">
                            <div class="form-group">
                                <label for="total">Tanggal</label>
                                <input type="text" class="form-control date-format" data-name="tanggal" name="tanggal" placeholder="Masukkan Tanggal" required="required">
                            </div> 
                            <div class="form-group">
                                <label for="faktur">Faktur Transkasi</label>
                                <input type="text" class="form-control" id="faktur" name="faktur" placeholder="Masukkan No. Faktur" >
                            </div>
                            <div class="form-group">
                                <label for="category">Akun</label>
                                <div class="d-flex">
                                    <select class="form-control" id="akun" name="akun" required>
                                        <?php foreach ($list_akun as $d) { ?>
                                        <option value="<?= $d->akun ?>"><?= $d->akun ?></option>
                                        <?php } ?>
                                    </select>
                                    <button type="button" onclick="tambahakun()" class="btn btn-success m-l-10" name="save" value="save"> <i class="fa fa-plus"></i> Tambah Akun</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="jenis">Jenis</label>
                                <select class="form-control" id="jenis" name="jenis" required>
                                    <option value="PEMASUKAN"  >PEMASUKAN</option>
                                    <option value="PENGELUARAN" >PENGELUARAN</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="total">Total</label>
                                <input type="text" class="form-control uang" id="total" name="total" placeholder="Masukkan Total Cashflow" required="required">
                            </div>
                            <div class="form-group">
                                <label for="catatan">Catatan</label>
                                <textarea class="form-control" rows="3" id="catatan" name="catatan" ></textarea>
                            </div> 
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success" name="save" value="save"> <i class="fa fa-check"></i> Simpan</button>
                            <a href="<?= base_url("cashflow")?><?= (!empty($params))?'/?'.$params:''; ?>"><button type="button" class="btn btn-inverse">Batalkan</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <button id="btnmodal" alt="default" data-toggle="modal" data-target="#responsive-modal" class="model_img img-responsive" style="display: none;" ></button>
    <div id="responsive-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;"> <!-- tabindex="-1"  -->
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-akun" method="post" class="form-material" action="<?= base_url()?>akun/tambah_api">
                    <div class="modal-header">
                        <h4 id="modal-title">Tambah Akun Cashflow </h4>
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
                            <label for="message-text" class="control-label">Nama Akun</label>
                            <input type="text" class="form-control frm-ajax" id="nama_akun" name="nama_akun" placeholder="Masukkan Nama Akun" required="required" style="text-transform:uppercase">
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
<script src="<?= base_url()?>assets/js/jquery.mask.min.js"></script>
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

<script type="text/javascript">
    $(document).ready(function(){
        // Format mata uang.
        $( '.uang' ).mask('000.000.000.000.000', {reverse: true});
        $('.date-format').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
        var dateString = moment(new Date()).format('YYYY-MM-DD');
        $(".date-format").val(dateString);
        $("#form-akun").submit(function() {
            $.ajax({
                url: $(this).attr("action"),
                data: $(this).serialize(),
                type: $(this).attr("method"),
                dataType: 'html',
                beforeSend: function() {
                    $(".btn-ajax").attr("disabled", true);
                },
                complete: function() {
                    $(".frm-ajax").attr("disabled", false);
                },
                success: function(hasil) {
                    var respon = JSON.parse(hasil);
                    if(respon.status){
                        notif('success',respon.success);
                        var list_akun = respon.data;
                        var akun_baru = respon.akun_baru;
                        var text = '';
                        console.log(list_akun);
                        for (i = 0; i < list_akun.length; i++) {
                            if(akun_baru == list_akun[i].akun){
                                text += '<option value="'+list_akun[i].akun+'" selected >'+list_akun[i].akun+'</option>';
                            } else {
                                text += '<option value="'+list_akun[i].akun+'" >'+list_akun[i].akun+'</option>';
                            }
                        }
                        console.log(text);
                        $("#akun").html(text);
                        $("#btnmodal").click();
                    } else {
                        notif('error',respon.error);
                    }
                }
            });    
            return false;
        });
    });

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

    function tambahakun(){
        notif('','');
        $("#nama_akun").val("");
        $("#btnmodal").click();
    }
</script>

            
