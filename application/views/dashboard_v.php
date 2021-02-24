<?php include("header.php") ?>
<!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Beranda</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Beranda</a></li>
                    </ol>
                </div>
                <div>
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
            <div class="container-fluid">
                
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <!-- Row -->
                                <div class="row">
                                    <div class="col-8">
                                        <h2>
                                            <?= number_format($today_transaksi->jumlah,0,',','.');  ?>
                                            <?php if($today_transaksi->jumlah >= $yesterday_transaksi->jumlah){ ?>  
                                                <i class="ti-angle-up font-14 text-success"></i>                                  
                                            <?php } else { ?>
                                                <i class="ti-angle-down font-14 text-danger"></i>
                                            <?php } ?>
                                        </h2>
                                        <h6>Transaksi Hari Ini</h6></div>
                                    <div class="col-4 align-self-center text-right  p-l-0">
                                        <h1><i class="icon-basket"></i></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <!-- Row -->
                                <div class="row">
                                    <div class="col-8"><h2 class="">
                                            Rp. <?= number_format($today_transaksi->total,0,',','.');  ?> 
                                            <?php if($today_transaksi->total >= $yesterday_transaksi->total){ ?>  
                                                <i class="ti-angle-up font-14 text-success"></i>                                  
                                            <?php } else { ?>
                                                <i class="ti-angle-down font-14 text-danger"></i>
                                            <?php } ?>
                                        </h2>
                                        <h6>Penjualan Hari Ini</h6></div>
                                    <div class="col-4 align-self-center text-right p-l-0">
                                        <h1><i class=" icon-credit-card"></i></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <!-- Row -->
                                <div class="row">
                                    <div class="col-8">
                                        <h2>Rp. <?= number_format($today_cashflow->pemasukan,0,',','.');  ?> 
                                            <?php if($today_cashflow->pemasukan >= $yesterday_cashflow->pemasukan){ ?>  
                                                <i class="ti-angle-up font-14 text-success"></i>                                  
                                            <?php } else { ?>
                                                <i class="ti-angle-down font-14 text-danger"></i>
                                            <?php } ?>
                                        </h2>
                                        <h6>Pemasukan Hari Ini</h6></div>
                                    <div class="col-4 align-self-center text-right p-l-0">
                                        <h1><i class="icon-cloud-download"></i></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <!-- Row -->
                                <div class="row">
                                    <div class="col-8">
                                        <h2>Rp. <?= number_format($today_cashflow->pengeluaran,0,',','.');  ?> 
                                            <?php if($today_cashflow->pengeluaran >= $yesterday_cashflow->pengeluaran){ ?>  
                                                <i class="ti-angle-up font-14 text-success"></i>                                  
                                            <?php } else { ?>
                                                <i class="ti-angle-down font-14 text-danger"></i>
                                            <?php } ?>
                                        </h2>
                                        <h6>Pengeluaran Hari Ini</h6></div>
                                    <div class="col-4 align-self-center text-right p-l-0">
                                        <h1><i class="icon-cloud-upload"></i></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-8 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Cashflow Terakhir</h4>
                                <h6 class="card-subtitle">Grafik Cashflow 7 hari terakhir</h6>
                                <div class="amp-pxl m-t-40" style="height: 335px;"></div>
                                <div class="text-center">
                                    <ul class="list-inline">
                                        <li>
                                            <h6 class="text-muted text-success"><i class="fa fa-circle font-10 m-r-10 "></i>Pemasukan</h6> </li>
                                        <li>
                                            <h6 class="text-danger"><i class="fa fa-circle font-10 m-r-10"></i>Pengeluaran</h6> </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card card-default">
                            <div class="card-header">
                                <div class="card-actions">
                                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                                    <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
                                </div>
                                <h4 class="card-title m-b-0">Menu Terfavorit Bulan Ini</h4>
                            </div>
                            <div class="card-body collapse show">
                                <div class="table-responsive">
                                    <table class="table product-overview">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Menu</th>
                                                <th>Gambar</th>
                                                <th>Kategori</th>
                                                <th>Harga</th>
                                                <th>Jumlah Terjual</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1; foreach ($list_favmenu as $d) { ?>
                                            <tr>
                                                <td class="text-nowrap"><?= $no++ ?></td>
                                                <td class="text-nowrap"><?= $d->menu ?></td>
                                                <td style="width:64px;">
                                                    <?php if($d->foto){ ?>
                                                        <img src="<?=base_url('').'assets/upload/menu/'.$d->foto?>" alt="user" width="64">
                                                    <?php } else {?>
                                                    <span class="round round-success"><?= $d->menu[0]?></span>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-nowrap"><?= $d->kategori ?></td>
                                                <td class="text-nowrap">Rp. <?= number_format($d->harga,0,',','.');  ?></td>
                                                <td class="text-nowrap"><?= number_format($d->jumlah,0,',','.');  ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-4 col-md-12">
                        <!-- Column -->
                        <div class="card card-default">
                            <div class="card-body ">
                                <h4 class="card-title">Transaksi per Kategori (Bulan Ini)</h4>
                                <div id="morris-donut-chart" class="ecomm-donute" style="height: 317px;"></div>
                                <ul class="list-inline m-t-20 text-center">
                                    <?php $i=0; $list_category_color = array();
                                         foreach ($list_category as $d) { ?>
                                    <li >
                                        <h6 class="text-muted"><i class="fa fa-circle" style="color: <?= $color[$i] ?>;"></i> <?= $d->kategori?></h6>
                                        <h4 class="m-b-0"><?= number_format($d->jumlah,0,',','.'); ?></h4>
                                    </li>
                                    <?php 
                                        $list_category_color[] = $color[$i];
                                        $i++;
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
               
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
<?php include("footer.php") ?>
<!-- chartist chart -->
<script src="<?= base_url(); ?>assets/plugins/chartist-js/dist/chartist.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
<!--morris JavaScript -->
<script src="<?= base_url(); ?>assets/plugins/raphael/raphael-min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/morrisjs/morris.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // ============================================================== 
        // Sales overview
        // ============================================================== 
        var chart = new Chartist.Bar('.amp-pxl', {
              labels: ['<?= implode("','", $last_cashflow->tanggal) ?>'],
              series: [
                [<?= implode(",", $last_cashflow->pemasukan) ?>],
                [<?= implode(",", $last_cashflow->pengeluaran) ?>]
              ]
            }, {
              axisX: {
                // On the x-axis start means top and end means bottom
                position: 'end',
                showGrid: false
              },
              axisY: {
                // On the y-axis start means left and end means right
                position: 'start'
                , labelInterpolationFnc: function (value) {
                    return (value / 1000) + 'k';
                }
              },
            //high:'12000',
            low: '0',
            plugins: [
                Chartist.plugins.tooltip()
            ]
        });
        

            chart.on('draw', function(ctx) {  
              if(ctx.type === 'area') {    
                ctx.element.attr({
                  x1: ctx.x1 + 0.001
                });
              }
            });

            // Create the gradient definition on created event (always after chart re-render)
            chart.on('created', function(ctx) {
              var defs = ctx.svg.elem('defs');
              defs.elem('linearGradient', {
                id: 'gradient',
                x1: 0,
                y1: 1,
                x2: 0,
                y2: 0
              }).elem('stop', {
                offset: 0,
                'stop-color': 'rgba(255, 255, 255, 1)'
              }).parent().elem('stop', {
                offset: 1,
                'stop-color': 'rgba(38, 198, 218, 1)'
              });
            });    
                
        var chart = [chart]; 

        Morris.Donut({
            element: 'morris-donut-chart',
            data: [
                <?php foreach ($list_category as $d) { ?>
                {   
                    label: "<?= $d->kategori ?>",
                    value: <?= $d->jumlah ?>,
                },
                <?php } ?>
            ],
            resize: true,
            colors:['<?= implode("','", $list_category_color) ?>']
        });  
    });
</script>