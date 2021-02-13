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
            <li class="breadcrumb-item"><a href="<?= base_url()?>pembelian">Pembelian</a></li>
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
                <table class="table no-border lite-padding m-t-20">
                    <tbody>
                        <tr>
                            <td>No. Faktur Pembelian</td>
                            <td class="font-medium"><?= $pembelian->faktur_pembelian?></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td class="font-medium"><?= date_format(date_create($pembelian->tanggal), 'd-m-Y'); ?></td>
                        </tr>
                        <tr>
                            <td>Biaya Tambahan</td>
                            <td class="font-medium">Rp. <?= number_format($pembelian->biaya_tambahan,0,',','.');  ?></td>
                        </tr>
                        <tr>
                            <td>Total Transaksi</td>
                            <td class="font-medium">Rp. <?= number_format($pembelian->total,0,',','.');  ?></td>
                        </tr>
                        <tr>
                            <td>Catatan</td>
                            <td class="font-medium"><?= $pembelian->catatan ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-actions">
                    <a href="<?= base_url("pembelian")?>" ><button type="button" class="btn btn-inverse">Kembali</button></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center">
                    <h3 class="card-title">Daftar Bahan</h3>
                </div>
                <div class="table-responsive dataTables_wrapper m-t-40">                    
                    <table class="display table" >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Bahan</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody id="list-bahan">
                            <?php $no = 1; foreach ($pembelian->item as $d) {  ?>
                            <tr>
                                <td><?= $no++;?></td>
                                <td><?= $d->nama  ?> (<?= $d->satuan  ?>)</td>
                                <td><?= number_format($d->jumlah,0,',','.');  ?></td>
                                <td>Rp. <?= number_format($d->harga,0,',','.');  ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- <tr>
        <td class="text-nowrap"><?= ++$no; ?></td>
        <td class="text-nowrap"><?= $d->nama ?></td>
        <td class="text-nowrap"><?= number_format($d->jumlah,0,',','.');  ?></td>
        <td>
            <div class="form-button-action">
                <a href="<?= base_url();?>pengurangan/delete/<?= $d->idpengurangan_stok; ?>" data-toggle="tooltip" data-original-title="Hapus" class="btn-delete"> <i class="fa fa-close text-danger"></i> </a>
                <a href="<?= base_url();?>pengurangan/delete/<?= $d->idpengurangan_stok; ?>" data-toggle="tooltip" data-original-title="Hapus" class="btn-delete"> <i class="fa fa-close text-danger"></i> </a>
            </div>
        </td>
    </tr> -->

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
                            <input type="text" class="form-control uang frm-ajax" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah Pembelian" required="required">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">Harga Pembelian (Total Semua Item)</label>
                            <input type="text" class="form-control uang frm-ajax" id="harga" name="harga" placeholder="Masukkan Harga Pembelian Total" required="required">
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
    $(document).ready(function() {
        $('#date-format').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
        $( '.uang' ).mask('000.000.000.000', {reverse: true});
        $(".select2").select2();
        $('.selectpicker').selectpicker();
    });

</script>
