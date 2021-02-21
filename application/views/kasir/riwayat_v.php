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
         <li class="nav-item " >
            <a href="<?= base_url();?>kasir/profil" >
            <i class="la la-user"></i><span class="menu-title" data-i18n="nav.changelog.main">Ubah Profil</span>
            </a>
         </li>
         <li class="nav-item " >
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
         <li class="nav-item active">
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
          <h3 class="content-header-title">Riwayat Transaksi</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url()?>">Kasir</a>
                </li>
                <li class="breadcrumb-item active">Riwayat Transaksi
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <a href="<?= base_url()?>"><button class="btn btn-info box-shadow-2 px-2 float-md-right mb-1"  type="button" ><i class="ft-arrow-left icon-left"></i> Kembali</button></a>
        </div>
      </div>
      <div class="content-body row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-2">
                        <h3 class="card-title">Data Transkasi Penjualan</h3>
                        <a href="#" class="ml-auto customizer-toggle"><button class="btn btn-primary box-shadow-2 px-2" type="button"><i class="ft-search icon-left"></i> Pecarian</button></a>
                    </div>
                    <div class="table-responsive dataTables_wrapper m-t-40">
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
                        <table class="display table table-striped table-hover" >
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Faktur</th>
                                    <th>Meja</th>
                                    <th>Total Transkasi</th>
                                    <th>Jumlah Bayar</th>
                                    <!-- <th>Status Dilayani</th> -->
                                    <th style="width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = $offset; foreach ($data as $d) {  ?>
                                <tr>
                                    <td class="text-nowrap"><?= ++$no; ?></td>
                                    <td class="text-nowrap"><?= $d->faktur ?></td>
                                    <td><?= date_format(date_create($d->date_add), 'd/m/Y H:i'); ?></td>
                                    <td class="text-nowrap"><?= $d->meja ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->total,0,',','.');  ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->bayar,0,',','.');  ?></td>
                                    <!-- <td>
                                        <?php if($d->status_dilayani){ ?>
                                            <span class="label label-primary">Sudah</span>
                                        <?php } else {?>
                                            <span class="label label-danger">Belum</span>
                                        <?php } ?>
                                    </td> -->
                                    <td>
                                        <div class="form-button-action">
                                            <a href="<?= base_url();?>kasir/detail/<?= $d->faktur; ?>" data-toggle="tooltip" data-original-title="Detail" > 
                                              <button type="button" class="btn btn-sm btn-icon btn-secondary"><i class="ft ft-search"></i></button>
                                            </a>
                                            <a data-toggle="tooltip" data-original-title="Cetak Struk" class="m-r-10" onclick="ajax_print('<?= $d->faktur; ?>')" > 
                                              <button  type="button" class="btn btn-sm btn-icon btn-primary"><i class="ft ft-printer"></i></button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?= $paginator; ?>
                    </div>
                </div>
            </div>
        </div>

      </div>
   </div>
</div>
      <!-- BEGIN: Customizer-->
      <div class="customizer border-left-blue-grey border-left-lighten-4 ">
         <a class="customizer-close" href="#"><i class="ft-x font-medium-3"></i></a>
         <div class="customizer-content p-2">
            <h4 class="text-uppercase mb-0"><b>Pecarian Data</b></h4>
            <hr>
            <form class="form" method="get">
              <div class="form-group">
                <label for="userinput1">No. Faktur</label>
                <input type="text" class="form-control"  name="s" placeholder="Tulis nomor faktur" value="<?= $s?>"  >
              </div>
              <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="projectinput3">Tanggal Mulai</label>
                      <input type="date" class="form-control" id="date" required="required"  name="str" value="<?= $str_date?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="projectinput4">Tanggal Akhir</label>
                      <input type="date" class="form-control" id="date" required="required" name="end"  value="<?= $str_date?>">
                    </div>
                  </div>
                </div>
                <div class="form-actions right">
                  <button type="submit" class="btn btn-success mr-2" style="min-width: 150px;">
                    <i class="ft ft-search"></i> Cari Data
                  </button>
                </div>
            </form>
      </div>
      <!-- End: Customizer-->

<?php include('footer_v.php'); ?>
<script src="<?= base_url()?>assets/plugins/sweetalert/sweetalert.min.js"></script>
<script src="<?= base_url()?>assets/plugins/sweetalert/jquery.sweet-alert.custom.js"></script>
<script>
   function ajax_print(faktur) {
      var url ='<?= base_url(); ?>cetak/ajax_transkasi/'+faktur;
        swal('Proses Cetak','Sistem akan mencetak struk secara otomatis','success',{
            closeOnClickOutside: false,
            closeOnEsc: false,
            closeModal:false,
            buttons:false  
        });
        $.get(url, function (data) {
            window.location.href = data;
            setTimeout(function(){ 
              swal('Proses Cetak Berhasil','Proses percetakan berhasil dilakukan','success');
            }, 3000);
        }).fail(function () {
            swal('Proses Cetak Gagal','Proses percetakan gagal dilakukan','warning');
            alert("ajax error");
        });
    }
</script>