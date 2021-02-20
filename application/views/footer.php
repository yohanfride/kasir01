<!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Ubah Tema Tampilan <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>Dengan <i>sidebar</i> terang</b></li>
                                <li><a href="javascript:void(0)" data-theme="default" data-url="<?=base_url()?>" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-theme="green" data-url="<?=base_url()?>" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-theme="red" data-url="<?=base_url()?>" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue" data-url="<?=base_url()?>" class="blue-theme working">4</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple" data-url="<?=base_url()?>" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna" data-url="<?=base_url()?>" class="megna-theme">6</a></li>
                                <li class="d-block m-t-30"><b>Dengan <i>sidebar</i> gelap</b></li>
                                <li><a href="javascript:void(0)" data-theme="default-dark" data-url="<?=base_url()?>" class="default-dark-theme">7</a></li>
                                <li><a href="javascript:void(0)" data-theme="green-dark" data-url="<?=base_url()?>" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-theme="red-dark" data-url="<?=base_url()?>" class="red-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue-dark" data-url="<?=base_url()?>" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple-dark" data-url="<?=base_url()?>" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna-dark" cdata-url="<?=base_url()?>" lass="megna-dark-theme ">12</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                &copy; 2021 Delta Web Dev
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?= base_url()?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url()?>assets/plugins/bootstrap/js/popper.min.js"></script>

    <script src="<?= base_url()?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?= base_url()?>assets/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <!-- <script src="<?= base_url()?>assets/js/waves.js"></script> -->
    <!--Menu sidebar -->
    <!-- <script src="<?= base_url()?>assets/js/sidebarmenu.js"></script> -->
    <!--stickey kit -->
    <script src="<?= base_url()?>assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?= base_url()?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?= base_url()?>assets/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <script src="<?= base_url()?>assets/plugins/raphael/raphael-min.js"></script>
    <script src="<?= base_url()?>assets/plugins/morrisjs/morris.min.js"></script>
    <!-- sparkline chart -->
    <script src="<?= base_url()?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- This is data table -->
    <script src="<?= base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <!-- <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script> -->
    <!-- <script src="<?= base_url()?>assets/js/dashboard4.js"></script> -->
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?= base_url()?>assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    <script>
        $('.btn-delete').click(function(){
            return confirm('Apakah anda yakin menghapus item ini?');          
        });
    </script>
</body>

</html>
