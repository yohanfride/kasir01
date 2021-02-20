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
                        <option value="4" <?= ($tipe == 4)?'selected':''; ?> >Rekap Total Per Akun</option>
                        <option value="5" <?= ($tipe == 5)?'selected':''; ?> >Harian Per Akun</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label" style="margin-bottom: .75rem">Jenis Transaksi</label>
                    <select class="form-control" name="jenis" id="jenis">
                        <option value="">SEMUA</option>
                        <option value="PEMASUKAN"  <?= ($jenis == 'PEMASUKAN')?'selected':''; ?> >PEMASUKAN</option>
                        <option value="PENGELUARAN" <?= ($jenis == 'PENGELUARAN')?'selected':''; ?> >PENGELUARAN</option>
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
                <div class="col-md-3 col-sm-6 div-src" id="div-bahan">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label" style="margin-bottom: .75rem">Bahan</label>
                        <select class="select2 form-control custom-select" name="bahan" id="bahan" style="width: 100%; height:36px;" required>
                            <?php foreach ($list_akun as $d) { ?>
                            <option value="<?= $d->akun ?>" <?= ($akun==$d->akun)?'selected':''; ?> ><?= $d->akun ?></option>
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
                <h4 class="card-title" id="gtitle">Grafik Rekapitulasi <i>Cashflow</i> Harian</h4>
                <div id="morris-line-chart" class=""></div>
            </div>
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
        $("#div-bahan").css({"display":"none"});    
        $("#div-tahun").css({"display":"none"});    
        $('#bahan').select2("enable", false);
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
            $("#div-bahan").css({"display":"block"});    
            $('#bahan').select2("enable");
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
              ykeys: ['<?= implode("','", $ykeys) ?>'],
              labels: ['<?= implode("','", $yLabels) ?>'],
              gridLineColor: '#eef0f2',
              lineColors: ['<?= implode("','", $colors) ?>'],
              lineWidth: 1,
                <?php if( count($data) > 15 ){ ?>
                    xLabelAngle: 90,
                <?php } ?>
              hideHover: 'auto'
            });
            $("#gtitle").html("Grafik Rekapitulasi <i>Cashflow</i> Harian <span class='float-right mr-2'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
        <?php } ?>

        <?php if($tipe == 2){ ?>
            var line = new Morris.Line({
              element: 'morris-line-chart',
              resize: true,
              data: <?= json_encode($data)?>,
              xkey: 'minggu',
              ykeys: ['<?= implode("','", $ykeys) ?>'],
              labels: ['<?= implode("','", $yLabels) ?>'],
              gridLineColor: '#eef0f2',
              lineColors: ['<?= implode("','", $colors) ?>'],
              lineWidth: 1,
                <?php if( count($data) > 15 ){ ?>
                    xLabelAngle: 90,
                <?php } ?>
              hideHover: 'auto'
            });
            $("#gtitle").html("Grafik Rekapitulasi <i>Cashflow</i> Mingguan <span  class='float-right mr-2'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
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
                yLabels: "<i>Cashflow</i> (IDR)",
                ykeys: ['<?= implode("','", $ykeys) ?>'],
                labels: ['<?= implode("','", $yLabels) ?>'],
                barColors:['<?= implode("','", $colors) ?>'],
                hideHover: 'auto',
                gridLineColor: '#eef0f2',
                resize: true
            });
            $("#gtitle").html("Grafik Rekapitulasi <i>Cashflow</i> Bulanan <span  class='float-right mr-2'>Tahun <?= $tahun?> </span>");
        <?php } ?>

        <?php if($tipe == 4){ ?>
            var line = Morris.Bar({
                element: 'morris-line-chart',
                data: <?= json_encode($data)?>,
                xkey: 'akun',
                xLabels: "Akun",
                yLabels: "<i>Cashflow</i> (IDR)",
                ykeys: ['<?= implode("','", $ykeys) ?>'],
                labels: ['<?= implode("','", $yLabels) ?>'],
                barColors:[ '<?= implode("','", $colors) ?>'],
                hideHover: 'auto',
                gridLineColor: '#eef0f2',
                xLabelMargin:10,
                <?php if( count($data) > 15 ){ ?>
                    xLabelAngle: 90,
                <?php } ?>
                resize: true
            });

            $("#gtitle").html("Grafik Rekapitulasi Total <i>Cashflow</i> per Bahan <span class='float-right mr-2'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
        <?php } ?>

        <?php if($tipe == 5){ ?>
            var line = new Morris.Line({
              element: 'morris-line-chart',
              resize: true,
              data: <?= json_encode($data)?>,
              xkey: 'tanggal',
              ykeys: ['<?= implode("','", $ykeys) ?>'],
              labels: ['<?= implode("','", $yLabels) ?>'],
              gridLineColor: '#eef0f2',
              lineColors: ['<?= implode("','", $colors) ?>'],
              lineWidth: 1,
              hideHover: 'auto'
            });
            var bahan = $("#select2-bahan-container").html();
            $("#gtitle").html("Grafik Rekapitulasi <i>Cashflow</i> Harian Bahan: <b>"+bahan+"</b> <span class='float-right mr-2'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
        <?php } ?>

        var heightToAdd = 80;    
        var svg = $("#morris-line-chart").find("svg")[0];
        svg.height.baseVal.value += heightToAdd;
        setTimeout(function(){
        },5000);
    });
</script>
