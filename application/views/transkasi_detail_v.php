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
            <li class="breadcrumb-item"><a href="<?= base_url()?>transaksi">Transaksi</a></li>
            <li class="breadcrumb-item active">Detail</li>
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
        <div class="col-lg-5 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <h3 class="card-title">Detail Transkasi</h3>
                        <a href="<?= base_url()?>transaksi/cetak/<?= $transaksi->faktur?>" class="ml-auto"><button class="btn btn-primary btn-round ml-auto">
                            <i class="fa fa-print"></i>
                            Cetak Struk Transkasi
                        </button></a>
                    </div>
                    <table class="table no-border lite-padding m-t-20">
                        <tbody>
                            <tr>
                                <td>No. Faktur</td>
                                <td class="font-medium"><?= $transaksi->faktur?></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td class="font-medium"><?= date_format(date_create($transaksi->date_add), 'd-m-Y H:i'); ?></td>
                            </tr>
                            <tr>
                                <td>Kasir</td>
                                <td class="font-medium"><?= $transaksi->nama_kasir ?></td>
                            </tr>
                            <tr>
                                <td>Total Transaksi</td>
                                <td class="font-medium">Rp. <?= number_format($transaksi->total,0,',','.');  ?></td>
                            </tr>
                            <tr>
                                <td>Total Bayar</td>
                                <td class="font-medium">Rp. <?= number_format($transaksi->bayar,0,',','.');  ?></td>
                            </tr><!-- 
                            <tr>
                                <td>Status Dilayani</td>
                                <td class="font-medium">
                                    <?php if($transaksi->status_dilayani){ ?>
                                        <span class="label label-primary">Sudah</span>
                                    <?php } else {?>
                                        <span class="label label-danger">Belum</span>
                                    <?php } ?>
                                </td>
                            </tr> -->
                            <tr>
                                <td>Meja</td>
                                <td class="font-medium"><?= $transaksi->meja ?></td>
                            </tr>
                            <tr>
                                <td>Catatan</td>
                                <td class="font-medium"><?= $transaksi->catatan ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-actions">
                        <a href="<?= base_url("pembelian")?>" ><button type="button" class="btn btn-inverse">Kembali</button></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Item Transaksi</h3>
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
                        <table id="add-row" class="display table" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th colspan="2">Menu</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=0; foreach ($transaksi->item_penjualan as $transaksi) { $no++; ?>
                                <tr>
                                    <td class="text-nowrap"><?= $no; ?></td>
                                    <td style="width:64px;">
                                        <?php if($transaksi->foto){ ?>
                                            <img src="<?=base_url('').'assets/upload/menu/'.$transaksi->foto?>" alt="user" width="64">
                                        <?php } else {?>
                                        <span class="round round-success"><?= $transaksi->menu[0]?></span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-nowrap"><?= $transaksi->menu ?></td>
                                    <td class="text-nowrap"><?= $transaksi->kategori ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($transaksi->harga,0,',','.');  ?></td>
                                    <td class="text-nowrap"><?= number_format($transaksi->jumlah,0,',','.');  ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($transaksi->harga*$transaksi->jumlah,0,',','.');  ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>       
    </div>
    

<?php include("footer.php") ?>

<script>
    $(document).ready(function() {
        /*{
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        }*/
    });
    
    </script>


                