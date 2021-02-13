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
            <li class="breadcrumb-item"><a href="<?= base_url()?>bahan">Stok Bahan</a></li>
            <li class="breadcrumb-item active">Tambah Stok Bahan</li>
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
        <div class="col-md-8 col-lg-6">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Form Tambah Stok Bahan Baru</h4>
                </div>
                <div class="card-body">
                    <form method="post" class="form-material">
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
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="nama">Nama Bahan</label>
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Enter Stok Bahan" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Stok Awal Bahan</label>
                                        <input type="number" class="form-control uang" id="stok_awal" name="stok_awal" placeholder="Enter Stok Bahan" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Satuan Bahan</label>
                                        <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Masukkan Satuan Bahan" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Keterangan Stok Bahan</label>
                                        <textarea class="form-control" rows="3" id="detail" name="detail" ></textarea>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success" name="save" value="save"> <i class="fa fa-check"></i> Simpan</button>
                            <a href="<?= base_url("bahan")?>"><button type="button" class="btn btn-inverse">Batalkan</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/js/jquery.mask.min.js"></script>
<script src="<?= base_url()?>assets/plugins/dropify/dist/js/dropify.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // Format mata uang.
        $( '.uang' ).mask('000.000.000.000.000', {reverse: true});
    })
</script>
            
