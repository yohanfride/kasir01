<?php include("header.php") ?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Akun Cashflow</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url()?>">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url()?>cashflow">Cashflow</a></li>
            <li class="breadcrumb-item active">Akun</li>
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
    <div class="col-sm-12 col-md-10 col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center">
                    <h3 class="card-title">Data Akun</h3>
                    <a href="<?= base_url()?>akun/tambah/" class="ml-auto"><button class="btn btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Tambah Akun Baru
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
                                <th>Nama Akun</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $d) { ?>
                            <tr>
                                <td class="text-nowrap"><?= $d->akun ?></td>
                                <td>
                                    <?php if($d->hapus){ ?>
                                    <div class="form-button-action">
                                        <a href="<?= base_url();?>akun/edit/<?= $d->idakun; ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                        <a href="<?= base_url();?>akun/delete/<?= $d->idakun; ?>" data-toggle="tooltip" data-original-title="Hapus" class="btn-delete"> <i class="fa fa-close text-danger"></i> </a>
                                    </div>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php include("footer.php") ?>

<script>
    $(document).ready(function() {
        $('#add-row').DataTable();
    });
    
    </script>
