<?php include("header.php") ?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Transkasi</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url()?>">Beranda</a></li>
            <li class="breadcrumb-item active">Transkasi</li>
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
    <form  method="get" action="" class="form-material row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header" style="padding-bottom: 0px;">
                <h3 class="card-title">Jenis Laporan</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <select class="form-control" name="tipe" id="tipe" onchange="formcari(this.value);">
                        <option value="1" <?= ($tipe == 1)?'selected':''; ?> >Harian</option>
                        <option value="2" <?= ($tipe == 2)?'selected':''; ?> >Mingguan</option>
                        <option value="3" <?= ($tipe == 3)?'selected':''; ?> >Bulanan</option>
                        <option value="4" <?= ($tipe == 4)?'selected':''; ?> >Rekap Total Per Kategori</option>
                        <option value="5" <?= ($tipe == 5)?'selected':''; ?> >Rekap Total Per Menu</option>
                        <option value="6" <?= ($tipe == 6)?'selected':''; ?> >Harian Per Kategori</option>
                        <option value="7" <?= ($tipe == 7)?'selected':''; ?> >Harian Per Menu</option>
                    </select>
                </div>
            </div>                              
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header" style="padding-bottom: 0px;">
                <h3 class="card-title">Form Pencarian Data</h3>
            </div>    
            <div class="card-body row">
                <div class="col-md-3 col-sm-6 div-src" id="div-kategori">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label" style="margin-bottom: .75rem">Kategori</label>
                        <select class="select2 form-control custom-select" name="kategori" id="kategori" style="width: 100%; height:36px;" required>
                            <option value="">SEMUA KATEGORI</option>
                            <?php foreach ($list_kategori as $d) { ?>
                            <option value="<?= $d->idkategori ?>" <?= ($kategori==$d->idkategori)?'selected':''; ?>  ><?= $d->kategori ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 div-src" id="div-menu">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label" style="margin-bottom: .75rem">Menu</label>
                        <select class="select2 form-control custom-select" name="menu" id="item-menu" style="width: 100%; height:36px;" required>
                            <?php foreach ($list_menu as $d) { ?>
                            <option value="<?= $d->idmenu ?>" <?= ($item_menu==$d->idmenu)?'selected':''; ?> ><?= $d->menu ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 div-src" id="div-tgl-mulai">
                    <div class="form-group">
                        <label for="body-machine">Tanggal Mulai</label>
                        <input type="text" disabled="true" id="tgl-mulai" class="form-control date-format frm-input" data-name="str" name="str" placeholder="Tulis Tanggal Mulai" required="required" value="<?= $str_date?>" >
                    </div>
                </div>    
                <div class="col-md-3  col-sm-6 div-src" id="div-tgl-akhir">
                    <div class="form-group">
                        <label for="body-machine">Tanggal Akhir</label>
                        <input type="text" id="tgl-akhir" class="form-control date-format frm-input" data-name="end" name="end" placeholder="Tulis Tanggal Akhir" required="required" value="<?= $end_date?>" >
                    </div>
                </div>
                <div class="col-md-3  col-sm-6 div-src" id="div-tahun">
                    <div class="form-group">
                        <label for="body-machine">Tahun</label>
                       <select class="form-control frm-input" name="tahun" id="tahun">
                            <?php foreach ($list_tahun as $d) { ?>
                            <option value="<?= $d->tahun?>" <?= ($tahun==$d->tahun)?'selected':''; ?> ><?= $d->tahun ?></option>
                            <?php } ?>
                        </select> 
                    </div>
                </div>
                <div class="row col-md-3 max-height">
                    <div class="form-group" style="padding-top:35px;">
                        <button class="btn btn-primary" type="submit" style="width: 120px; margin-top: -5px;"><i class="ti-search"></i>  Cari</button>
                    </div>    
                </div>
            </div>
        </div>
    </div>
    </form>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" id="gtitle">Grafik Rekapitulasi Penjualan Harian</h4>
                <div id="morris-line-chart" class=""></div>
            </div>
            <?php if($data){ ?>
            <div class="card-footer">
                <div class="mt-1 float-right">
                    <a href="<?= base_url()?>report/penjualan/cetak/?<?= $params?>" target="_BLANK">
                        <button class="btn btn-info" type="button" style="width: 120px; margin-top: -5px;"><i class="fa fa-print"></i>  Cetak</button>
                    </a>
                    <a href="<?= base_url()?>excel/penjualan/?<?= $params?>" target="_BLANK">
                        <button class="btn btn-success" type="button" style="margin-top: -5px;"><i class="fa fa-file-excel-o"></i>  Export Excel</button>
                    </a>
                </div>  
            </div>
            <?php } ?>
        </div>
    </div>

<?php include("footer.php") ?>
<!-- Plugin JavaScript -->
<script src="<?= base_url();?>assets/plugins/moment/moment.js"></script>
<script src="<?= base_url();?>assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<!-- Clock Plugin JavaScript -->
<script src="<?= base_url();?>assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
<!-- Color Picker Plugin JavaScript -->
<script src="<?= base_url();?>assets/plugins/jquery-asColorPicker-master/libs/jquery-asColor.js"></script>
<script src="<?= base_url();?>assets/plugins/jquery-asColorPicker-master/libs/jquery-asGradient.js"></script>
<script src="<?= base_url();?>assets/plugins/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
<!-- Date Picker Plugin JavaScript -->
<script src="<?= base_url();?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- Date range Plugin JavaScript -->
<script src="<?= base_url();?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?= base_url();?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url(); ?>assets/js/jquery.mask.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<!--Morris JavaScript -->
<script src="<?= base_url(); ?>assets/plugins/raphael/raphael-min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/morrisjs/morris.js"></script>

<script type="text/javascript">
    function formcari(id){
        $("#div-tgl-mulai").css({"display":"none"});    
        $("#div-tgl-akhir").css({"display":"none"});    
        $("#div-kategori").css({"display":"none"});    
        $("#div-menu").css({"display":"none"});    
        $("#div-tahun").css({"display":"none"});    
        $('#kategori').select2("enable", false);
        $('#item-menu').select2("enable", false);
        $(".frm-input").prop('disabled', true);
        if( (id != '3') ){
            $("#div-tgl-mulai").css({"display":"block"});    
            $("#div-tgl-akhir").css({"display":"block"});    
            $("#tgl-mulai").prop('disabled', false);
            $("#tgl-akhir").prop('disabled', false);
        }
        if( id == '3' ){
            $("#div-tahun").css({"display":"block"});    
            $("#tahun").prop('disabled', false);
        }
        if( id == '5' ){
            $("#div-kategori").css({"display":"block"});    
            $("#kategori").prop('required', false);
            $('#kategori').select2("enable");
        }
        if( id == '6' ){
            $("#div-kategori").css({"display":"block"});    
            $("#kategori").prop('required', true);
            $('#kategori').select2("enable");
        }
        if( id == '7' ){
            $("#div-menu").css({"display":"block"});    
            $('#item-menu').select2("enable");
        }
    }
</script>
<script>
    $(document).ready(function() {
        $('.date-format').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
        $(".select2").select2();
        $('.selectpicker').selectpicker();
        formcari('<?= $tipe; ?>');

        <?php if($tipe == 1){ ?>
            var line = new Morris.Line({
              element: 'morris-line-chart',
              resize: true,
              data: <?= json_encode($data)?>,
              xkey: 'tanggal',
              ykeys: ['total'],
              labels: ['Penjualan (IDR)'],
              gridLineColor: '#eef0f2',
              lineColors: ['#009efb'],
              lineWidth: 1,
                <?php if( count($data) > 15 ){ ?>
                    xLabelAngle: 90,
                <?php } ?>
              hideHover: 'auto'
            });
            $("#gtitle").html("Grafik Rekapitulasi Penjualan Harian <span class='float-right mr-2'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
        <?php } ?>

        <?php if($tipe == 2){ ?>
            var line = new Morris.Line({
              element: 'morris-line-chart',
              resize: true,
              data: <?= json_encode($data)?>,
              xkey: 'minggu',
              ykeys: ['total'],
              labels: ['Penjualan (IDR)'],
              gridLineColor: '#eef0f2',
              lineColors: ['#55ce63'],
              lineWidth: 1,
                <?php if( count($data) > 15 ){ ?>
                    xLabelAngle: 90,
                <?php } ?>
              hideHover: 'auto'
            });
            $("#gtitle").html("Grafik Rekapitulasi Penjualan Mingguan <span  class='float-right mr-2'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
        <?php } ?>

        <?php if($tipe == 3){ ?>
            const monthNames = ["", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
                "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
            ];
            // const monthNames = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            //     "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            // ];
            var line = Morris.Bar({
                element: 'morris-line-chart',
                data: <?= json_encode($data)?>,
                xkey: 'bulan',
                xLabelFormat: function (x) {
                    var index = parseInt(x.src.bulan);
                    return monthNames[index];
                },
                xLabels: "Bulan",
                yLabels: "Penjualan (IDR)",
                ykeys: ['item_total'],
                labels: ['Penjualan (IDR)'],
                barColors:['#55ce63', '#2f3d4a', '#009efb'],
                hideHover: 'auto',
                gridLineColor: '#eef0f2',
                resize: true
            });
            $("#gtitle").html("Grafik Rekapitulasi Penjualan Bulanan <span  class='float-right mr-2'>Tahun <?= $tahun?> </span>");
        <?php } ?>

        <?php if($tipe == 4){ ?>
            var line = Morris.Bar({
                element: 'morris-line-chart',
                data: <?= json_encode($data)?>,
                xkey: 'kategori',
                xLabels: "Kategori",
                yLabels: "Penjualan (IDR)",
                ykeys: ['total'],
                labels: ['Penjualan (IDR)'],
                barColors:[ '#009efb'],
                hideHover: 'auto',
                <?php if( count($data) > 15 ){ ?>
                    xLabelAngle: 90,
                <?php } ?>
                gridLineColor: '#eef0f2',
                resize: true
            });
            $("#gtitle").html("Grafik Rekapitulasi Total Penjualan per Kategori <span class='float-right mr-2'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
        <?php } ?>

        <?php if($tipe == 5){ ?>
            var line = Morris.Bar({
                element: 'morris-line-chart',
                data: <?= json_encode($data)?>,
                xkey: 'menu',
                xLabels: "Menu",
                yLabels: "Penjualan (IDR)",
                ykeys: ['total'],
                labels: ['Penjualan (IDR)'],
                barColors:[ '#26dad2'],
                hideHover: 'auto',
                gridLineColor: '#eef0f2',
                xLabelMargin:10,
                <?php if( count($data) > 15 ){ ?>
                    xLabelAngle: 90,
                <?php } ?>
                resize: true
            });

            $("#gtitle").html("Grafik Rekapitulasi Total Penjualan per Menu <span class='float-right mr-2'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
        <?php } ?>

        <?php if($tipe == 6){ ?>
            var line = new Morris.Line({
              element: 'morris-line-chart',
              resize: true,
              data: <?= json_encode($data)?>,
              xkey: 'tanggal',
              ykeys: ['total'],
              labels: ['Penjualan (IDR)'],
              gridLineColor: '#eef0f2',
              lineColors: ['#009efb'],
              lineWidth: 1,
                <?php if( count($data) > 15 ){ ?>
                    xLabelAngle: 90,
                <?php } ?>
              hideHover: 'auto'
            });
            var kategori = $("#select2-kategori-container").html();
            $("#gtitle").html("Grafik Rekapitulasi Penjualan Harian Kategori: <b>"+kategori+"</b> <span class='float-right mr-2'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
        <?php } ?>

        <?php if($tipe == 7){ ?>
            var line = new Morris.Line({
              element: 'morris-line-chart',
              resize: true,
              data: <?= json_encode($data)?>,
              xkey: 'tanggal',
              ykeys: ['total'],
              labels: ['Penjualan (IDR)'],
              gridLineColor: '#eef0f2',
              lineColors: ['#009efb'],
              lineWidth: 1,
                <?php if( count($data) > 15 ){ ?>
                    xLabelAngle: 90,
                <?php } ?>
              hideHover: 'auto'
            });
            var menu = $("#select2-item-menu-container").html();
            $("#gtitle").html("Grafik Rekapitulasi Penjualan Harian Menu: <b>"+menu+"</b> <span class='float-right mr-2'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
        <?php } ?>

        var heightToAdd = 80;    
        var svg = $("#morris-line-chart").find("svg")[0];
        svg.height.baseVal.value += heightToAdd;
        setTimeout(function(){
        },5000);
    });
</script>
