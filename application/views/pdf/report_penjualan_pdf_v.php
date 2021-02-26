<?php include("header.php") ?>

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
            $("#gtitle").html("Grafik Rekapitulasi Penjualan Harian <br/><span class='mt-1 mb-1'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
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
            $("#gtitle").html("Grafik Rekapitulasi Total Penjualan per Kategori <br/><span class='mt-1 mb-1'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
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

            $("#gtitle").html("Grafik Rekapitulasi Total Penjualan per Menu <br/><span class='mt-1 mb-1'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
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
            $("#gtitle").html("Grafik Rekapitulasi Penjualan Harian Kategori: <b>"+kategori+"</b> <br/><span class='mt-1 mb-1'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
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
            $("#gtitle").html("Grafik Rekapitulasi Penjualan Harian Menu: <b>"+menu+"</b> <br/><span class='mt-1 mb-1'>Tanggal <?= date_format(date_create($str_date), 'd - m - Y'); ?> s/d <?= date_format(date_create($end_date), 'd m Y'); ?></span>");
        <?php } ?>

        var heightToAdd = 150;    
        var svg = $("#morris-line-chart").find("svg")[0];
        svg.height.baseVal.value += heightToAdd;
        window.print();
    });
</script>
