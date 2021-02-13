<?php include("header.php") ?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Profil Saya</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url()?>">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('user')?>">Pengguna</a></li>
            <li class="breadcrumb-item active">Ubah Pengguna</li>
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
        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Form Ubah Data Pengguna</h4>
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
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?= $data->username?>" readonly="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama" required="required" value="<?= $data->name?>" >
                                    </div>                  
                                    <div class="form-group">
                                        <label for="phone">No. Telp/HP</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan No. Telp / HP" required="required" value="<?= $data->phone?>"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Alamat Email</label>
                                        <input type="mail" class="form-control" id="email" name="email" placeholder="Masukkan Alamat Email" required="required" value="<?= $data->email?>"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Level Akun</label>
                                        <select class="form-control" id="role" name="role" required>
                                            <option value="admin" <?= ($data->role == 'admin')?'selected':''; ?>  >Administrator</option>
                                            <option value="pegawai" <?= ($data->role == 'pegawai')?'selected':''; ?>  >Pegawai</option>
                                            <option value="kasir" <?= ($data->role == 'kasir')?'selected':''; ?>  >Kasir</option>
                                        </select>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success" name="save" value="save"> <i class="fa fa-check"></i> Simpan</button>
                            <a href="<?= base_url()?>"><button type="button" class="btn btn-inverse">Batalkan</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include("footer.php") ?>

            
