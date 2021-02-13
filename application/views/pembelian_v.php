<?php include("header.php") ?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Pembelian</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url()?>">Beranda</a></li>
            <li class="breadcrumb-item active">Pembelian</li>
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
                                <label for="body-machine">No. Faktur</label>
                                <input type="text" class="form-control" data-name="s" name="s" placeholder="Tulis nomor faktur" value="<?= $s?>" >
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
                    <h3 class="card-title">Data Pembelian </h3>
                    <a href="<?= base_url()?>pembelian/tambah" class="ml-auto"><button class="btn btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Tambah Data Pembelian
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
                                <th>Faktur Pembelian</th>
                                <th>Tanggal</th>
                                <th>Biaya Tambahan</th>
                                <th>Total Pembelian</th>
                                <th>Catatan</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = $offset; foreach ($data as $d) {  ?>
                            <tr>
                                <td class="text-nowrap"><?= ++$no; ?></td>
                                <td class="text-nowrap"><?= $d->faktur_pembelian ?></td>
                                <td><?= date_format(date_create($d->tanggal), 'd/m/Y'); ?></td>
                                <td class="text-nowrap">Rp. <?= number_format($d->biaya_tambahan,0,',','.');  ?></td>
                                <td class="text-nowrap">Rp. <?= number_format($d->total,0,',','.');  ?></td>
                                <td><?= $d->catatan ?></td>
                                <td>
                                    <div class="form-button-action">
                                        <a href="<?= base_url();?>pembelian/detail/<?= $d->idpembelian; ?>" data-toggle="tooltip" data-original-title="Detail" class="m-r-10" > <i class="fa fa-search text-secondary"></i> </a>
                                        <a href="<?= base_url();?>pembelian/delete/<?= $d->idpembelian; ?>" data-toggle="tooltip" data-original-title="Hapus" class="btn-delete"> <i class="fa fa-close text-danger"></i> </a>
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
    });

</script>
