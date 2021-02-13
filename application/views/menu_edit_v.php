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
            <li class="breadcrumb-item"><a href="<?= base_url()?>menu">Menu</a></li>
            <li class="breadcrumb-item active">Ubah Menu</li>
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
        <div class="col-md-12 col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Form Ubah Menu</h4>
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
                            <div class="row">
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="menu">Menu</label>
                                        <input type="text" class="form-control" id="menu" name="menu" placeholder="Masukkan Nama Menu" required="required" value="<?= $data->menu; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Kategori</label>
                                        <select class="form-control" id="category" name="category" required>
                                            <?php foreach ($kategori as $d) { ?>
                                            <option <?= ($d->idkategori == $data->idkategori)?'selected':''; ?> value="<?= $d->idkategori ?>"><?= $d->kategori ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Harga</label>
                                        <input type="text" class="form-control uang" id="price" name="price" placeholder="Masukkan Harga Menu" required="required" value="<?= $data->harga; ?>" >
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Keterangan</label>
                                        <textarea class="form-control" rows="3" id="detail" name="detail" ><?= $data->keterangan_menu; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="1" <?= ($data->status == 1)?'selected':''; ?> >Aktif</option>
                                            <option value="0" <?= ($data->status == 0)?'selected':''; ?> >Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="file">Gambar Menu</label>
                                        <?php  
                                            if($data->foto){
                                                $foto_name = $data->foto;
                                                $foto_url = base_url().'assets/upload/menu/'.$data->foto;
                                            } else {
                                                $foto_name = '';
                                                $foto_url = '';
                                            }
                                        ?>
                                        <input type="hidden" name="img_curr" value="<?= $foto_name?>">
                                        <input type="file" id="input-file-now-custom-1" name="photo" class="dropify" data-default-file="<?= $foto_url ?>" accept="image/*" />
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success" name="save" value="save"> <i class="fa fa-check"></i> Simpan</button>
                            <a href="<?= base_url("menu")?>"><button type="button" class="btn btn-inverse">Batalkan</button></a>
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
        // Basic
        $('.dropify').dropify();
    })
</script>

            
