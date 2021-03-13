<?php include("header.php") ?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Identitas Toko</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url()?>">Beranda</a></li>
            <li class="breadcrumb-item active">Identitas Toko</li>
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
                    <h4 class="m-b-0 text-white">Form Ubah Identitas Toko</h4>
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
                                        <label for="nama">Nama Toko</label>
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Toko" required="required" value="<?= $data->nama_toko; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="pemilik">Nama Pemilik</label>
                                        <input type="text" class="form-control" id="pemilik" name="pemilik" placeholder="Masukkan Nama Pemilik"  value="<?= $data->nama_pemilik; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">No. Telp.</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan Nama Pemilik" required="required" value="<?= $data->no_telepon; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control" rows="3" id="alamat" name="alamat" ><?= $data->alamat; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="note">Catatan (Footer) Struk </label>
                                        <textarea class="form-control" rows="5" id="note" name="note" ><?= $data->footer_struk; ?></textarea>
                                        <span class="text-danger float-right text-right">*1 baris terdiri maksimal 30 huruf, gunakan enter untuk ke baris berikutnya.</span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="file">Logo Toko</label>
                                        <?php  
                                            if($data->logo){
                                                $foto_name = $data->logo;
                                                $foto_url = base_url().'assets/upload/toko/'.$data->logo;
                                            } else {
                                                $foto_name = '';
                                                $foto_url = '';
                                            }
                                        ?>
                                        <input type="hidden" name="logo_curr" value="<?= $foto_name?>">
                                        <input type="file" id="input-file-now-custom-1" name="logo" class="dropify" data-default-file="<?= $foto_url ?>" accept="image/*" />
                                    </div>
                                    <div class="form-group">
                                        <label for="file">Icon Website</label>
                                        <?php  
                                            if($data->icon){
                                                $foto_name = $data->icon;
                                                $foto_url = base_url().'assets/upload/toko/'.$data->icon;
                                            } else {
                                                $foto_name = '';
                                                $foto_url = '';
                                            }
                                        ?>
                                        <input type="hidden" name="icon_curr" value="<?= $foto_name?>">
                                        <input type="file" id="input-file-now-custom-1" name="icon" class="dropify" data-default-file="<?= $foto_url ?>" accept="icon/*" />
                                        <span class="text-danger ml-2 float-right text-right">*Gunakan online conveter untuk menghubah gambar menjadi .ico</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="file">Logo Struk </label>
                                        <span class="text-danger ml-2 float-right">*Tinggi gambar maksimal 400px</span>
                                        <?php  
                                            if($data->logo_struk){
                                                $foto_name = $data->logo_struk;
                                                $foto_url = base_url().'assets/upload/toko/'.$data->logo_struk;
                                            } else {
                                                $foto_name = '';
                                                $foto_url = '';
                                            }
                                        ?>
                                        <input type="hidden" name="logo_struk_curr" value="<?= $foto_name?>">
                                        <input type="file" id="input-file-now-custom-1" name="logo_struk" class="dropify" data-default-file="<?= $foto_url ?>" accept="image/*" />
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success" name="save" value="save"> <i class="fa fa-check"></i> Simpan</button>
                            <a href="<?= base_url("")?>"><button type="button" class="btn btn-inverse">Batalkan</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/plugins/dropify/dist/js/dropify.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // Basic
        $('.dropify').dropify();
    })
</script>

            
