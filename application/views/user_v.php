<?php include("header.php") ?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Pengguna</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url()?>">Beranda</a></li>
            <li class="breadcrumb-item active">Pengguna</li>
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
                    <h3 class="card-title">Data Pengguna</h3>
                    <a href="<?= base_url()?>user/tambah/" class="ml-auto"><button class="btn btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Tambah Pengguna Baru
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
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Level</th>
                                <th>Email</th>
                                <th>No. Telp/HP</th>
                                <th>Status</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $d) { 
                                $id=$d->user_id; 
                                if($d->role == 'sishouadmin'){
                                    continue;
                                } ?>
                            <tr>
                                <td><?= $d->name ?></td>
                                <td><?= $d->username ?></td>
                                <td><?= $d->email ?></td>
                                <td><?= $d->phone ?></td>
                                <td>
                                    <?php if($d->role == 'admin'){ ?>
                                    <span class="label label-primary">Administrator</span>
                                    <?php } else if($d->role == 'pegawai'){ ?>
                                    <span class="label label-primary">Pegawai</span>
                                    <?php } else { ?>
                                    <span class="label label-primary">Kasir</span> 
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if($d->status == 0){ ?>
                                    <span class="label label-warning">Not Verification</span>
                                    <?php } else if($d->status == 1){ ?>
                                    <span class="label label-success pl-3">Active</span>
                                    <?php } else { ?>
                                    <span class="label label-danger pl-3">Suspend</span> 
                                    <?php } ?>
                                </td>
                                <td>
                                <div class="form-button-action" style="margin-left: -20px;">
                                    <?php if($d->user_id != $user_now->user_id){ ?>
                                    <div class="form-button-action">
                                        <?php if($d->status == 0){ ?>
                                        <a href="<?= base_url();?>user/active/<?= $id; ?>" data-toggle="tooltip" data-original-title="Verifikasi">
                                            <i class="fa fa-check text-success m-r-10"></i>
                                        </a>
                                        <?php } else if($d->status == 1){ ?>
                                        <a href="<?= base_url();?>user/nonactive/<?= $id; ?>" data-toggle="tooltip" data-original-title="Suspend Akun" >
                                            <i class="fa fa-ban text-warning m-r-10"></i>
                                        </a>
                                        <?php } else { ?>
                                        <a href="<?= base_url();?>user/active/<?= $id; ?>" data-toggle="tooltip" data-original-title="Aktivasi Akun">
                                            <i class="fa fa-check text-success m-r-10"></i>
                                        </a> 
                                        <?php } ?>
                                        <a href="<?= base_url();?>user/edit/<?= $id; ?>" data-toggle="tooltip" data-original-title="Edit"> 
                                            <i class="fa fa-pencil text-inverse m-r-10"></i>
                                        </a>
                                        <a href="<?= base_url();?>user/delete/<?= $id; ?>" data-toggle="tooltip" data-original-title="Close" class="btn-delete">
                                            <i class="fa fa-close text-danger m-r-10"></i>
                                        </a>
                                         <a href="<?= base_url();?>user/reset_pass/<?= $id; ?>" data-toggle="tooltip" data-original-title="Reset Password"> 
                                            <i class="fa fa-lock text-primary m-r-10"></i>
                                        </a>
                                    </div>
                                    <?php } ?>
                                </div>
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
        /*{
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        }*/
    });
    
    </script>
