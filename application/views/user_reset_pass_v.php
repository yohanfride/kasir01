<?php include("header.php") ?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Ubah Password</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url()?>">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('user')?>">Pengguna</a></li>
            <li class="breadcrumb-item active">Reset Password Pengguna Baru</li>
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
                    <h4 class="m-b-0 text-white">Form Reset Password</h4>
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?= $data->username?>" readonly="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name" readonly="true" value="<?= $data->name?>" >
                                    </div>  
                                    <div class="form-group">
                                        <label for="role">Level Pengguna</label>
                                        <input type="text" class="form-control" id="role" readonly="true" value="<?php 
                                            if($data->role == 'sishouadmin'){ 
                                                echo 'Sishou Administrator'; 
                                            } elseif($data->role == 'admin'){ 
                                                echo 'Administrator'; 
                                            } else if($data->role == 'pegawai'){ 
                                                echo 'Pegawai'; 
                                            } else {
                                                echo 'Kasir'; 
                                            }
                                        ?>" readonly="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="password" style="width: 100%;">Password Baru</label>
                                        <input type="text" class="form-control col-6 col-md-8" id="password" name="password" placeholder="Masukkan Password Baru" required="required"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Harus berisi setidaknya satu angka dan satu huruf besar dan kecil, dan setidaknya 6 karakter atau lebih">
                                        <button type="button" onclick="reset_pass();" class="btn btn-primary ml-2" name="save" value="save"> <i class="fa fa-refresh"></i> Ganti Password</button>
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
<script type="text/javascript">
    function makeid(length) {
       var result           = '';
       var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
       var charactersLength = characters.length;
       for ( var i = 0; i < length; i++ ) {
          result += characters.charAt(Math.floor(Math.random() * charactersLength));
       }
       return result;
    }
    function reset_pass(){
        $("#password").val(makeid(6));
    }
    reset_pass();
</script>
            
