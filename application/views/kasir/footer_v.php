<!-- ////////////////////////////////////////////////////////////////////////////-->
      <button class="btn btn-info btn-lg float-right mb-1" type="button" id="fs-doc-button"  style="display: none;" >FullScreen</button>
      <button class="btn btn-info btn-lg float-right mb-1" type="button" id="fs-exit-doc-button" style="display: none;"  >Exit FullScreen</button>

      <footer class="footer footer-static footer-light navbar-border navbar-shadow">
         <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
            <span class="float-md-left d-block d-md-inline-block">Copyright &copy; <?= date("Y")?>, <b><?= $toko->nama_toko?></b></span>
            <span class="float-md-right d-block d-md-inline-blockd-none d-lg-block"><i class="ft-map-pin blue"></i> <?= $toko->alamat; ?> </span>
         </p>
      </footer>
      <!-- BEGIN VENDOR JS-->
      <script src="<?= base_url()?>assets/kasir/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
      <script type="text/javascript">
        var requestFullscreen = function (ele) {
          if (ele.requestFullscreen) {
            ele.requestFullscreen();
          } else if (ele.webkitRequestFullscreen) {
            ele.webkitRequestFullscreen();
          } else if (ele.mozRequestFullScreen) {
            ele.mozRequestFullScreen();
          } else if (ele.msRequestFullscreen) {
            ele.msRequestFullscreen();
          } else {
            console.log('Fullscreen API is not supported.');
          }
        };

        var exitFullscreen = function () {
          if (document.exitFullscreen) {
            document.exitFullscreen();
          } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
          } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
          } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
          } else {
            console.log('Fullscreen API is not supported.');
          }
        };

        var fsDocButton = document.getElementById('fs-doc-button');
        var fsExitDocButton = document.getElementById('fs-exit-doc-button');

        fsDocButton.addEventListener('click', function(e) {
          e.preventDefault();
          requestFullscreen(document.documentElement);
        });

        fsExitDocButton.addEventListener('click', function(e) {
          e.preventDefault();
          exitFullscreen();
        });

        setTimeout( function(){ $("#fs-doc-button").click(); }, 3000 );


        // jQuery.event.special.touchstart = {
        //   setup: function( _, ns, handle ){
        //     if ( ns.includes("noPreventDefault") ) {
        //       this.addEventListener("touchstart", handle, { passive: false });
        //     } else {
        //       this.addEventListener("touchstart", handle, { passive: true });
        //     }
        //   }
        // };
      </script>
      <!-- BEGIN VENDOR JS-->
      <!-- BEGIN PAGE VENDOR JS-->
      <!-- <script src="<?= base_url()?>assets/kasir/app-assets/vendors/js/charts/chart.min.js" type="text/javascript"></script> -->
      <!-- <script src="<?= base_url()?>assets/kasir/app-assets/vendors/js/charts/echarts/echarts.js" type="text/javascript"></script> -->
      <!-- END PAGE VENDOR JS-->
      <!-- BEGIN MODERN JS-->
      <script src="<?= base_url()?>assets/kasir/app-assets/js/core/app-menu.js" type="text/javascript"></script>
      <script src="<?= base_url()?>assets/kasir/app-assets/js/core/app.js" type="text/javascript"></script>
      <script src="<?= base_url()?>assets/kasir/app-assets/js/scripts/customizer.js" type="text/javascript"></script>
      <!-- END MODERN JS-->
      <!-- BEGIN PAGE LEVEL JS-->
      <!-- <script src="<?= base_url()?>assets/kasir/app-assets/js/scripts/pages/dashboard-crypto.js" type="text/javascript"></script> -->
      <!-- END PAGE LEVEL JS-->
   </body>
</html>