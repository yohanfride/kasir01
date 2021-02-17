<?php include("header.php") ?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Pengurangan Stok Bahan</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url()?>">Beranda</a></li>
            <li class="breadcrumb-item active">Pengurangan Stok Bahan</li>
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
    <div class="col-md-12">
        <form  method="get" action="" class="form-material">
            <div class="card">
                <div class="card-header" style="padding-bottom: 0px;">
                    <h3 class="card-title">Form Pencarian Data</h3>
                </div>
                <div class="card-body">
                    <!-- <h3 class="card-title">Data Pengurangan Stok Bahan</h3>
                    <h3 class="card-title mb-3">Form Pencarian Data</h3> -->

                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group">
                                <label for="body-machine">Nama Bahan</label>
                                <input type="text" class="form-control" data-name="s" name="s" placeholder="Tulis nama bahan" value="<?= $s?>" >
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group">
                                <label for="body-machine">Tanggal Mulai</label>
                                <input type="text" class="form-control date-format" data-name="str" name="str" placeholder="Enter Birth" required="required" value="<?= $str_date?>" >
                            </div>
                        </div>
                        <div class="col-md-3  col-sm-6">
                            <div class="form-group">
                                <label for="body-machine">Tanggal Akhir</label>
                                <input type="text" class="form-control date-format" data-name="end" name="end" placeholder="Enter Birth" required="required" value="<?= $end_date?>" >
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group" style="padding-top:35px;">
                                <button class="btn btn-primary" type="submit"><i class="ti-search"></i>  Cari</button>
                            </div>
                        </div>
                    </div>
                </div>                              
            </div>
        </form>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center">
                    <h3 class="card-title">Data Pengurangan Stok Bahan</h3>
                    <a href="#" class="ml-auto" onclick="reducestock()"><button class="btn btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Tambah Pengurangan Stok
                    </button></a>
                </div>
                <div class="table-responsive dataTables_wrapper m-t-40">
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
                    <table class="display table table-striped table-hover" >
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Bahan</th>
                                <th>Jumlah Pengurangan</th>
                                <th>Keterangan</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $d) { $no = $offset ?>
                            <tr>
                                <td class="text-nowrap"><?= ++$no; ?></td>
                                <td><?= date_format(date_create($d->date_add), 'd/m/Y H:i'); ?></td>
                                <td class="text-nowrap"><?= $d->nama.' ('.$d->satuan.')' ?></td>
                                <td class="text-nowrap"><?= number_format($d->jumlah,0,',','.');  ?></td>
                                <td><?= $d->keterangan ?></td>
                                <td>
                                    <div class="form-button-action">
                                        <a href="<?= base_url();?>pengurangan/delete/<?= $d->idpengurangan_stok; ?>" data-toggle="tooltip" data-original-title="Hapus" class="btn-delete"> <i class="fa fa-close text-danger"></i> </a>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?= $paginator; ?>
                </div>
            </div>
        </div>
    </div>

    <button id="btnmodal" alt="default" data-toggle="modal" data-target="#responsive-modal" class="model_img img-responsive" style="display: none;" ></button>
    <div id="responsive-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;"> <!-- tabindex="-1"  -->
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-pengurangan" method="post" class="form-material" action="<?= base_url()?>bahan/api_pengurangan">
                    <div class="modal-header">
                        <h4 id="modal-title">Pengurangan Stok : </h4>
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
                                <option value="<?= $d->idstok ?>"><?= $d->nama ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Tanggal</label>
                            <input type="text" class="form-control frm-ajax" id="date-format" name="date_add">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">Jumlah</label>
                            <input type="number" class="form-control uang frm-ajax" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah Pengurangan" required="required">
                        </div>
                        <div class="form-group">
                            <label for="name">Keterangan</label>
                            <textarea class="form-control" rows="3" id="detail" name="detail" ></textarea>
                        </div>
                        <input type="hidden" name="uid" value="<?= $user_now->user_id; ?>">
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
<script>
    $(document).ready(function() {
        $('.date-format').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
        $( '.uang' ).mask('000.000.000.000.000', {reverse: true});
        $('#date-format').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD HH:mm' });
        $(".select2").select2();
        $('.selectpicker').selectpicker();

        $("#form-pengurangan").submit(function() {
            var maxstok = parseInt($("#maxstok").val());
            var jumlah = parseInt($("#jumlah").val());
            if(jumlah>maxstok){
                notif('error','Jumlah pengurangan stok melebihi jumlah stok');
            } else {
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
                            $("#stok-"+respon.id).html(respon.stok);
                            setTimeout(function(){ location.reload(); }, 3000); 
                        } else {
                            notif('error',respon.error);
                        }
                    }
                });    
            }
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

    function reducestock(){
        var dateString = moment(new Date()).format('YYYY-MM-DD HH:mm');
        $("#date-format").val(dateString);
        notif('','');
        $("#bahan").prop("selectedIndex", 0);
        $("#jumlah").val("");
        $("#detail").val("");
        $("#btnmodal").click();
    }
</script>
