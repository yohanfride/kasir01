<div class="card-body">
    <h3 class="card-title text-themecolor m-b-20">Faktur : <?= $transaksi->faktur?> </h3>
    <div class="table-responsive" id="cart">
        <table class="table m-b-0">
            <thead>
                <tr class="text-center">
                    <th>Menu</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                if(isset($transaksi->item_penjualan))
                foreach ($transaksi->item_penjualan as $key => $value) {
                    $value = (object) $value;
                    $total+= ( $value->harga * $value->jumlah );
                 ?>
                <tr>
                    <td><b><?= $value->nama ?></b> <br/> Rp. <?= number_format($value->harga,0,',','.');  ?></td>
                    <td style="font-size: 20px;" class="text-center">
                        <?php if($value->jumlah == 1){ ?>
                        <a href="#" onclick="kurangi_menu(<?= $key; ?>)" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-minus-square text-danger"></i> </a> 
                        <?php } else { ?>
                        <a href="#" onclick="kurangi_menu(<?= $key; ?>)" data-toggle="tooltip" data-original-title="Kurangi"> <i class="fa fa-minus-square text-inverse"></i> </a> 
                        <?php } ?>       
                        <span class="m-l-3 m-r-4" style="width: 20px;"><b><?= number_format($value->jumlah,0,',','.');  ?></b></span>     
                        <a href="#" onclick="tambah_menu(<?= $key; ?>)" data-toggle="tooltip" data-original-title="Tambah"> <i class="fa fa-plus-square text-inverse m-r-10"></i> </a>
                    </td>
                    <td class="text-right">
                        <?= number_format($value->harga * $value->jumlah,0,',','.');  ?>                                    
                    </td>
                </tr>
                <?php } ?>   
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-12"><hr style="margin-top: 0.5rem; border-top: 2px solid rgba(0,0,0,.1); "></div>                    
        <h4 class="col-7 text-center"><b>Total</b></h4>
        <h4 class="col-5 text-right"><b>Rp. <span id="total"><?= number_format($total,0,',','.');  ?></span></b></h4>
    </div>
</div>