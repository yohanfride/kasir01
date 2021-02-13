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
            <li class="breadcrumb-item active">Menu</li>
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
                    <h3 class="card-title">Data Menu</h3>
                    <a href="<?= base_url()?>menu/tambah/" class="ml-auto"><button class="btn btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Tambah Menu Baru
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
                            <tr class="text-center">
                                <th>Gambar</th>
                                <th>Menu</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $d) { ?>
                            <tr>
                                <td style="width:64px;">
                                    <?php if($d->foto){ ?>
                                        <img src="<?=base_url('').'assets/upload/menu/'.$d->foto?>" alt="user" width="64">
                                    <?php } else {?>
                                    <span class="round round-success"><?= $d->menu[0]?></span>
                                    <?php } ?>
                                </td>
                                <td class="text-nowrap"><?= $d->menu ?></td>
                                <td class="text-nowrap"><?= $d->kategori ?></td>
                                <td class="text-nowrap"><?= number_format($d->harga,0,',','.');  ?></td>

                                <td>
                                    <?php if($d->status){ ?>
                                        <span class="label label-primary">Aktif</span>
                                    <?php } else {?>
                                        <span class="label label-danger">Tidak Aktif</span>
                                    <?php } ?>
                                </td>
                                <td><?= $d->keterangan_kategori ?></td>
                                <td>
                                    <div class="form-button-action">
                                        <a href="<?= base_url();?>menu/edit/<?= $d->idmenu; ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                        <a href="<?= base_url();?>menu/delete/<?= $d->idmenu; ?>" data-toggle="tooltip" data-original-title="Hapus" class="btn-delete"> <i class="fa fa-close text-danger"></i> </a>
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
