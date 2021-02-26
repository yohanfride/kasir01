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
    <link href="<?= base_url();?>assets/plugins/morrisjs/morris.css" rel="stylesheet">
    <link href="<?= base_url();?>assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="<?= base_url();?>assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="<?= base_url();?>assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <link href="<?= base_url();?>assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="<?= base_url();?>assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="<?= base_url();?>assets/plugins/morrisjs/morris.css" rel="stylesheet">
    <?php } ?>
    <!-- <link href="<?= base_url();?>assets/plugins/croppie/croppie.css" rel="stylesheet"> -->
    <style type="text/css" media="print">
        @page { 
            size: landscape;
        }
    </style>
</head>

<body >
   
    <div id="main-wrapper">
            