<?php include("header.php") ?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Stok Bahan</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url()?>">Beranda</a></li>
            <li class="breadcrumb-item active">Stok Bahan</li>
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
        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center">
                    <h3 class="card-title">Data Stok Bahan</h3>
                    <a href="<?= base_url()?>bahan/tambah/" class="ml-auto"><button class="btn btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Tambah Data Stok Bahan Baru
                    </button></a>
                </div>
                <div class="table-responsive m-t-40">
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
                    <table id="add-row" class="display table table-striped table-hover" >
                        <thead>
                            <tr>
                                <th>Nama Bahan</th>
                                <th>Jumlah Stok Bahan</th>
                                <th>Satuan Bahan</th>
                                <th>Keterangan</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $d) { ?>
                            <tr>
                                <td class="text-nowrap"><?= $d->nama ?></td>
                                <td id="stok-<?= $d->idstok; ?>"><?= number_format($d->jumlah_stok,0,',','.'); ?></td>
                                <td ><?= $d->satuan ?></td>
                                <td><?= $d->keterangan_stok ?></td>
                                <td>
                                    <div class="form-button-action">
                                        <a href="<?= base_url();?>bahan/edit/<?= $d->idstok; ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                        <a href="<?= base_url();?>bahan/delete/<?= $d->idstok; ?>" data-toggle="tooltip" data-original-title="Hapus" class="btn-delete"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                                        <a href="#" onclick="reducestock(<?= $d->idstok; ?>,'<?= $d->nama ?>','<?= $d->satuan ?>',<?= $d->jumlah_stok; ?>)"  data-original-title="Pengurangan Stok" > <i class="fa fa-minus-square"></i> </a>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <button id="btnmodal" alt="default" data-toggle="modal" data-target="#responsive-modal" class="model_img img-responsive" style="display: none;" ></button>
    <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-pengurangan" method="post" class="form-material" action="<?= base_url()?>bahan/api_pengurangan">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">Pengurangan Stok : </h4>
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
                            <label for="recipient-name" class="control-label">Tanggal</label>
                            <input type="text" class="form-control frm-ajax" id="date-format" name="date_add">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">Jumlah</label>
                            <input type="number" class="form-control uang frm-ajax" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah Pengurangan" required="required" inputmode="numeric">
                        </div>
                        <div class="form-group">
                            <label for="name">Keterangan</label>
                            <textarea class="form-control" rows="3" id="detail" name="detail" ></textarea>
                        </div>
                        <input type="hidden" id="maxstok">
                        <input type="hidden" id="bahan" name="bahan">
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
<script src="<?= base_url()?>assets/js/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {
        $('#add-row').DataTable();
        $("#notif-danger").hide();
        $("#notif-success").hide();
        $( '.uang' ).mask('000.000.000.000.000', {reverse: true});
        $('#date-format').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD HH:mm' });
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
                            setTimeout(function(){ $("#btn-close").click(); }, 3000); 
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

    function reducestock(id,nama,satuan,maxstok){
        $("#modal-title").html('Pengurangan Stok : '+nama+" ("+satuan+") ");
        var dateString = moment(new Date()).format('YYYY-MM-DD HH:mm');
        $("#date-format").val(dateString);
        $("#maxstok").val(maxstok);
        $("#bahan").val(id);
        notif('','');
        $("#jumlah").val("");
        $("#detail").val("");
        $("#btnmodal").click();

    }
    
    </script>
