<!-- ////////////////////////////////////////////////////////////////////////////-->
      <footer class="footer footer-static footer-light navbar-border navbar-shadow">
         <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
            <span class="float-md-left d-block d-md-inline-block">Copyright &copy; <?= date("Y")?>, <b><?= $toko->nama_toko?></b></span>
            <span class="float-md-right d-block d-md-inline-blockd-none d-lg-block"><i class="ft-map-pin blue"></i> <?= $toko->alamat; ?> </span>
         </p>
      </footer>
      <!-- BEGIN VENDOR JS-->
      <script src="<?= base_url()?>assets/kasir/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
      <!-- BEGIN VENDOR JS-->
      <!-- BEGIN PAGE VENDOR JS-->
      <!-- <script src="<?= base_url()?>assets/kasir/app-assets/vendors/js/charts/chart.min.js" type="text/javascript"></script> -->
      <!-- <script src="<?= base_url()?>assets/kasir/app-assets/vendors/js/charts/echarts/echarts.js" type="text/javascript"></script> -->
      <!-- END PAGE VENDOR JS-->
      <!-- BEGIN MODERN JS-->
      <script src="<?= base_url()?>assets/kasir/app-assets/js/core/app-menu.js" type="text/javascript"></script>
      <script src="<?= base_url()?>assets/kasir/app-assets/js/core/app.js" type="text/javascript"></script>
      <script src="<?= base_url()?>assets/kasir/app-assets/js/core/app.min.js" type="text/javascript"></script>
      <script src="<?= base_url()?>assets/kasir/app-assets/js/scripts/customizer.js" type="text/javascript"></script>
      <!-- END MODERN JS-->
      <!-- BEGIN PAGE LEVEL JS-->
      <script src="<?= base_url()?>assets/kasir/app-assets/js/scripts/pages/dashboard-crypto.js" type="text/javascript"></script>
      <!-- END PAGE LEVEL JS-->
      <script type="text/javascript">
         function toggleFullscreen() {
           let elem = document.querySelector("video");

           if (!document.fullscreenElement) {
             elem.requestFullscreen().catch(err => {
               alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
             });
           } else {
             document.exitFullscreen();
           }
         }
      </script>
   </body>
</html>