<?php include('header_v.php') ?>
<div class="navbar-container content">
   <div class="collapse navbar-collapse" id="navbar-mobile">
      <ul class="nav navbar-nav mr-auto float-left">
         <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
      </ul>
      <ul class="nav navbar-nav float-right">
         <li class="dropdown dropdown-user nav-item">
            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown" aria-expanded="false"><i class="ficon ft-user"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
               <a class="dropdown-item" href="<?= base_url()?>kasir/profil"><i class="ft-user"></i> Ganti Profil</a>
               <a class="dropdown-item" href="<?= base_url()?>kasir/setting"><i class="ft-lock"></i> Ganti Password</a>
               <div class="dropdown-divider"></div>
               <a class="dropdown-item" href="<?= base_url()?>kasir"><i class="ft-shopping-cart"></i> Kasir</a>
               <a class="dropdown-item" href="<?= base_url()?>kasir/riwayat"><i class="ft-calendar"></i> Riwayat Transkasi</a>
               <div class="dropdown-divider"></div>
               <a class="dropdown-item" href="<?= base_url()?>auth/logout"><i class="ft-power"></i> Keluar</a>
            </div>
         </li>
      </ul>
   </div>
</div>
</div>
</nav>
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow " data-scroll-to-active="true">
   <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
         <li class="navigation-header">
            <span data-i18n="nav.category.layouts">Manajemen Profil</span><i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Manajemen Profil"></i>
         </li>
         <li class="nav-item active" >
            <a href="<?= base_url();?>kasir/profil" >
            <i class="la la-user"></i><span class="menu-title" data-i18n="nav.changelog.main">Ubah Profil</span>
            </a>
         </li>
         <li class="nav-item" >
            <a href="<?= base_url();?>kasir/setting" >
            <i class="la la-lock"></i><span class="menu-title" data-i18n="nav.changelog.main">Ubah Password</span>
            </a>
         </li>
         <li class="navigation-header">
            <span data-i18n="nav.category.layouts">Manajemen Transaksi</span><i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Manajemen Transaksi"></i>
         </li>
         <li class="nav-item">
            <a href="<?= base_url();?>kasir/" >
            <i class="la la-shopping-cart"></i><span class="menu-title" data-i18n="nav.changelog.main">Kasir</span>
            </a>
         </li>
         <li class="nav-item">
            <a href="<?= base_url();?>kasir/riwayat" >
            <i class="la la-calendar"></i><span class="menu-title" data-i18n="nav.changelog.main">Riwayat Transkasi</span>
            </a>
         </li>
      </ul>
   </div>
</div>
<div class="app-content content">
   <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">Ubah Profil</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url()?>">Kasir</a>
                </li>
                <li class="breadcrumb-item active">Ubah Profil
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <a href="<?= base_url()?>"><button class="btn btn-info box-shadow-2 px-2 float-md-right"  type="button" ><i class="ft-arrow-left icon-left"></i> Kembali</button></a>
        </div>
      </div>
      <div class="content-body row">
         <div class="col-md-8 col-lg-6">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 ">Form Ubah Profil Saya</h4>
                </div>
                <div class="card-body">
                    <form method="post" class="form-material" enctype="multipart/form-data">
                        <?php if($error){ ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                            <h3 class=""><strong><i class="ft ft-alert-triangle"></i> Perhatian </strong></h3> <?= $error?>
                        </div>
                        <?php } ?>
                        <?php if($success){ ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                            <h3 ><strong><i class="ft ft-check"></i> Sukses </strong></h3> <?= $success?>
                        </div>
                        <?php } ?>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" required="required" value="<?= $data->username; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama" required="required" value="<?= $data->name; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">No. Telp/HP</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan No. Telp / HP" required="required" value="<?= $data->phone; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Alamat Email</label>
                                        <input type="mail" class="form-control" id="email" name="email" placeholder="Masukkan Alamat Email" required="required" value="<?= $data->email; ?>">
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
   </div>
</div>
<?php include('footer_v.php'); ?>