<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url()?>assets/upload/toko/<?= $toko->icon; ?>">
    <title> <?= $title; ?> </title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Morries chart CSS -->
    <link href="<?= base_url()?>assets/plugins/morrisjs/morris.css" rel="stylesheet">
    
    
    <!-- Custom CSS -->
    <link href="<?= base_url()?>assets/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?= base_url()?>assets/css/colors/blue.css" id="theme" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url()?>assets/plugins/dropify/dist/css/dropify.min.css">
    <link href="<?= base_url()?>assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <?php if(!empty($dateform)){ ?>
    <link href="<?= base_url();?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <!-- Page plugins css -->
    <link href="<?= base_url();?>assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <!-- Color picker plugins css -->
    <link href="<?= base_url();?>assets/plugins/jquery-asColorPicker-master/css/asColorPicker.css" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="<?= base_url();?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker plugins css -->
    <link href="<?= base_url();?>assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="<?= base_url();?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <?php } ?>
    <?php if(!empty($select2)){ ?>
    <link href="<?= base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="<?= base_url();?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <?php } ?>
    <?php if(!empty($chart)){ ?>
    <link href="<?= base_url();?>assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="<?= base_url();?>assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="<?= base_url();?>assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <?php } ?>
    <!-- <link href="<?= base_url();?>assets/plugins/croppie/croppie.css" rel="stylesheet"> -->
    
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li id="navlink" class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li id="navlink2"  class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span class="round2 label-themecolor"><i class="icon-user"></i></span></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img" style="font-size: 30px;">
                                                <span class="square label-themecolor"><i class="icon-user"></i></span>
                                            </div>
                                            <div class="u-text">
                                                <h4><?= $user_now->name?></h4>
                                                <p class="text-muted"><?= $user_now->email?></p><a href="<?= base_url()?>user/myprofile" class="btn btn-rounded btn-danger btn-sm">Lihat Profil</a></div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?= base_url()?>user/myprofile"><i class="ti-user"></i> Profile Saya</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?= base_url()?>user/setting"><i class="ti-settings"></i> Ubah Password </a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?= base_url()?>auth/logout"><i class="fa fa-power-off"></i> Keluar</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <div class="user-profile">
                    <!-- User profile image -->
                    <div class="profile-img"> <img src="<?= base_url()?>assets/upload/toko/<?= $toko->logo; ?>" alt="logo"> 
                    </div>
                    <!-- User profile text-->
                    <div class="profile-text"> 
                            <h5>Halaman Administrator</h5>   
                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-small-cap">BISNIS</li>
                        <li <?php if($menu == 'dashboard'){ echo 'class="active"'; } ?>> <a class="waves-effect" href="<?= base_url()?>" ><i class="mdi mdi-gauge"></i><span class="hide-menu">Beranda</span></a></li>
                        <li <?php if($menu == 'kategori'){ echo 'class="active"'; } ?> > <a class="waves-effect" href="<?= base_url()?>kategori" ><i class="mdi mdi-grid"></i><span class="hide-menu">Kategori</span></a></li>
                        <li <?php if($menu == 'menu'){ echo 'class="active"'; } ?> > <a class="waves-effect" href="<?= base_url()?>menu" ><i class="mdi mdi-food"></i><span class="hide-menu">Menu</span></a></li>
                        <li <?php if($menu == 'bahan'){ echo 'class="active"'; } ?> > <a class="waves-effect" href="<?= base_url()?>bahan" ><i class="mdi mdi-equal-box"></i><span class="hide-menu">Stok Bahan</span></a></li>
                        <li <?php if($menu == 'transaksi'){ echo 'class="active"'; } ?> > <a class="waves-effect" href="<?= base_url()?>transaksi" ><i class="mdi mdi-cart"></i><span class="hide-menu">Transaksi</span></a></li>
                        <li <?php if($menu == 'pembelian'){ echo 'class="active"'; } ?> > <a class="waves-effect" href="<?= base_url()?>pembelian" ><i class="mdi mdi-cart-plus"></i><span class="hide-menu">Pembelian Bahan</span></a></li>
                        <li <?php if($menu == 'pengurangan'){ echo 'class="active"'; } ?> > <a class="waves-effect" href="<?= base_url()?>pengurangan" ><i class="mdi mdi-basket-unfill"></i><span class="hide-menu">Pengurangan Bahan</span></a></li>
                        <li <?php if($menu == 'cash flow'){ echo 'class="active"'; } ?> > <a class="waves-effect" href="<?= base_url()?>cashflow" ><i class="mdi mdi-cash-multiple"></i><span class="hide-menu">Cash Flow</span></a></li>
                        <li class="nav-small-cap">LAPORAN</li>
                        <li <?php if($menu == 'income chart'){ echo 'class="active"'; } ?> > <a class="waves-effect" href="<?= base_url()?>report/pemasukan" ><i class="mdi mdi-file-chart"></i><span class="hide-menu">Laporan Pemasukan</span></a></li>
                        <li <?php if($menu == 'outcome chart'){ echo 'class="active"'; } ?> > <a class="waves-effect" href="<?= base_url()?>report/pengeluaran" ><i class="mdi mdi-file-chart"></i><span class="hide-menu">Laporan Pengeluaran</span></a></li>
                        <li <?php if($menu == 'cash flow chart'){ echo 'class="active"'; } ?> > <a class="waves-effect" href="<?= base_url()?>report/cashflow" ><i class="mdi mdi-file-chart"></i><span class="hide-menu">Laporan Cash Flow</span></a></li>
                        <?php if($user_now->role != 'pegawai'){ ?>
                        <li class="nav-small-cap">ADMINISTRATOR</li>
                        <li <?php if($menu == 'user'){ echo 'class="active"'; } ?> > <a class="waves-effect" href="<?= base_url()?>user" ><i class="mdi mdi-account"></i><span class="hide-menu">Pengguna</span></a></li>
                        <li <?php if($menu == 'personal'){ echo 'class="active"'; } ?> > <a class="waves-effect" href="<?= base_url()?>personal" ><i class="mdi mdi-store"></i><span class="hide-menu">Identitas Toko</span></a></li>
                        <?php } ?>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            