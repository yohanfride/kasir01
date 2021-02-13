<?php include("header.php") ?>
            <div class="page-inner">
                    <div class="page-header">
                        <h4 class="page-title">Daily Tank of Each-Car</h4>
                        <ul class="breadcrumbs">
                            <li class="nav-home">
                                <a href="<?= base_url()?>statistic">
                                    <i class="link-icon icon-chart"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Volumes on Daily Tank of Each-Car</a>
                            </li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Car/Truck Data List</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="add-row" class="display table table-striped table-hover" >
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Vehicle Number</th>
                                                    <th>Owner</th>
                                                    <th>STNK</th>
                                                    <th>Capacity</th>
                                                    <th style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Vehicle Number</th>
                                                    <th>Owner</th>
                                                    <th>STNK</th>
                                                    <th>Capacity</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach ($data as $d) { $id=number_format($d->car_id,0,'',''); ?>
                                                <tr>
                                                    <td><?= $id ?></td>
                                                    <td><?= $d->vehicle_number ?></td>
                                                    <td><?= $d->owner ?></td>
                                                    <td><?= $d->stnk ?></td>
                                                    <td><?= number_format($d->capacity,0,',','.') ?></td>
                                                    <td>
                                                        <div class="form-button-action">
                                                            <button type="button" data-toggle="tooltip" data-placement="top" title="" class="btn btn-link btn-danger" data-original-title="Daily Tank of Each-Car"  style="padding: .375rem .75rem;">
                                                                <a href="<?= base_url();?>statistic/dailytankcar/<?= $id; ?>" >
                                                                <i class="fas fa-chart-bar"></i>
                                                                </a>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php include("footer.php") ?>
    
    <script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip({
           container: 'body'
        });
        //Notify
        <?php if($success){ ?>
        $.notify({
            icon: 'flaticon-success',
            title: 'Success',
            message: "<?= $success; ?>",
        },{
            type: 'success',
            placement: {
                from: "bottom",
                align: "right"
            },
            time: 3000,
        }); 
        <?php } 
         if($error){ ?>
        $.notify({
            icon: 'flaticon-error',
            title: 'Failed',
            message: "<?= $error; ?>",
        },{
            type: 'danger',
            placement: {
                from: "bottom",
                align: "right"
            },
            time: 3000,
        }); 
        <?php } ?>
    });
</script>