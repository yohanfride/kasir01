f<?php include("header.php") ?>

    <h2 class="card-title text-center" id="gtitle">Grafik Rekapitulasi Penjualan Harian</h2>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
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
        $("#div-akun").css({"display":"none"});    
        $("#div-tahun").css({"display":"none"});    
        $('#akun').select2("enable", false);
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
            $("#div-akun").css({"display":"block"});    
            $('#akun').select2("enable");
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

            $("#gtitle").html("Grafik Rekapitulasi Total <i>Cashflow</i> per Akun <span class='float-right mr-2'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
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
            var akun = $("#select2-akun-container").html();
            $("#gtitle").html("Grafik Rekapitulasi <i>Cashflow</i> Harian Akun: <b>"+akun+"</b> <span class='float-right mr-2'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
        <?php } ?>

        var heightToAdd = 80;    
        var svg = $("#morris-line-chart").find("svg")[0];
        svg.height.baseVal.value += heightToAdd;
        window.print();
    });
</script>
