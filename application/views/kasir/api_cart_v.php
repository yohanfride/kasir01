              <div class="table-responsive">
                  <table class="table table-borderless mb-0">
                     <thead>
                        <tr class="text-center">
                           <th>No.</th>
                           <th>Menu</th>
                           <th>Jumlah</th>
                           <th>Total</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                         $total = 0;
                         $jumlah = 0;
                         $diskon = 0;
                         $no = 1;
                         if(isset($transaksi->item_penjualan))
                         foreach ($transaksi->item_penjualan as $key => $value) {
                             $value = (object) $value;
                             $total+= ( $value->harga * $value->jumlah );
                             $jumlah+=$value->jumlah;
                             $item_diskon = ( $value->harga * $value->jumlah ) * ($value->diskon / 100);
                             $diskon+=$item_diskon;
                        ?>
                        <tr>
                           <td class="text-center list-no"><?= $no++; ?></td>
                           <td >
                              <div class="product-title"><?= $value->nama ?></div>
                              <div class="product-color"><strong>Rp. <?= number_format($value->harga,0,',','.');  ?></strong> </div>
                           </td>
                           <td  class="list-qty">
                              <div class="input-group bootstrap-touchspin">
                                 <?php if($value->jumlah == 1){ ?>
                                 <span onclick="kurangi_menu(<?= $key; ?>)" class="input-group-btn input-group-prepend bootstrap-touchspin-injected"><button class="btn btn-danger bootstrap-touchspin-down" type="button"><i class="la la-trash"></i></button></span>
                                 <?php } else { ?>
                                 <span onclick="kurangi_menu(<?= $key; ?>)" class="input-group-btn input-group-prepend bootstrap-touchspin-injected"><button class="btn btn-primary bootstrap-touchspin-down" type="button"><i class="la la-minus"></i></button></span>
                                 <?php } ?>  
                                 <input type="text" class="text-center count touchspin form-control" value="<?= number_format($value->jumlah,0,',','.');  ?>">

                                 <span onclick="tambah_menu(<?= $key; ?>)" class="input-group-btn input-group-append bootstrap-touchspin-injected"><button class="btn btn-primary bootstrap-touchspin-up" type="button"><i class="la la-plus"></i></button></span>
                              </div>
                           </td >
                           <td class="text-right text-middle list-price">
                              <div class="total-price"><b>Rp. <?= number_format($value->harga * $value->jumlah,0,',','.');  ?>  </b></div>
                              <?php if($item_diskon > 0){ ?>
                              <div class="product-color text-danger"><b>(- Rp. <?= number_format($item_diskon,0,',','.');  ?> )</b></div>
                              <?php } ?>
                           </td>
                        </tr>
                        <?php } ?>   
                     </tbody>
                  </table>
               </div>
               <div class="row">
                 <div class="col-12"><hr style="margin-top: 0.5rem; border-top: 2px solid rgba(0,0,0,.1); "></div>                    
                 <h5 class="col-7 "><b>Sub Total</b></h4>
                 <h5 class="col-5 text-right"><b>Rp. <span id="subtotal" class="mr-1"><span id="subtotal"><?= number_format($total,0,',','.');  ?></span></b></h4>
                 <h5 class="col-7 "><b>Diskon</b></h4>
                 <h5 class="col-5 text-right text-danger"><b>- Rp. <span id="diskon" class="mr-1"><span id="diskon"> <?= number_format($diskon,0,',','.');  ?></span></b></h4>
               </div>
               <div class="row">
                 <div class="col-12"><hr style="margin-top: 0.5rem; border-top: 2px solid rgba(0,0,0,.1); "></div>                    
                 <h4 class="col-7 text-center"><b>Total</b></h4>
                 <h4 class="col-5 text-right"><b>Rp. <span id="total" class="mr-1"><span id="total"><?= number_format($total-$diskon,0,',','.');  ?></span></b></h4>
               </div>
               <script type="text/javascript">
                  $("#cart-count").html('<?= $jumlah; ?>');  
               </script>