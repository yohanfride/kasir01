<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"> -->
      <title> <?= $title; ?> </title>
      <link rel="icon" type="image/png" href="<?= base_url()?>assets/upload/toko/<?= $toko->icon; ?>">
      <link href="<?= base_url()?>assets/kasir/assets/font.css" rel="stylesheet">
      <link href="<?= base_url()?>assets/kasir/app-assets/fonts/line-awesome/css/line-awesome.css" rel="stylesheet">
      <!-- BEGIN VENDOR CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/kasir/app-assets/css/vendors.css">
      <!-- END VENDOR CSS-->
      <!-- BEGIN MODERN CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/kasir/app-assets/css/app.css">
      <!-- END MODERN CSS-->
      <!-- BEGIN Page Level CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/kasir/app-assets/css/core/menu/menu-types/vertical-menu.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/kasir/app-assets/css/core/colors/palette-gradient.css">
      <!-- <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/kasir/app-assets/vendors/css/cryptocoins/cryptocoins.css"> -->
      <!-- END Page Level CSS-->
      <!-- BEGIN Custom CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/kasir/assets/css/style.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/kasir/assets/css/ecommerce-shop.min.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/kasir/assets/css/ecommerce-cart.min.css">
      <link href="<?= base_url()?>assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
      <!-- END Custom CSS-->
   </head>
   <body class="vertical-layout vertical-menu 2-columns pace-done menu-collapsed fixed-navbar"
      data-open="click" data-menu="vertical-menu" data-col="2-columns">
      <!-- fixed-top-->
      <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light bg-info navbar-shadow">
         <div class="navbar-wrapper">
            <div class="navbar-header">
               <ul class="nav navbar-nav flex-row">
                  <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                  <li class="nav-item">
                     <a class="navbar-brand" href="<?= base_url()?>">
                        <img class="brand-logo" alt="modern admin logo" src="<?= base_url()?>assets/upload/toko/<?= $toko->logo; ?>">
                        <h3 class="brand-text"><?= $toko->nama_toko; ?></h3>
                     </a>
                  </li>
                  <li class="nav-item d-md-none">
                     <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
                  </li>
               </ul>
            </div>