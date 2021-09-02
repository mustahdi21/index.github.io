            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->
            <!--Start of Tawk.to Script-->

            <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <?php echo date("Y"); ?> © <?php echo $cfg_webname; ?>.
                    </div>
                </div>
            </div>
        </footer>
            <!-- Footer Ends -->



        </section>
        <!-- Main Content Ends -->
        


        <!-- js placed at the end of the document so the pages load faster -->
        <script src="<?php echo $cfg_baseurl; ?>js/jquery.js"></script>
        <!-- jQuery  -->
        <script src="<?php echo $cfg_baseurl; ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/js/popper.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/js/waves.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/js/jquery.slimscroll.js"></script>

        <!-- Counter number -->
        <script src="<?php echo $cfg_baseurl; ?>assets/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/counterup/jquery.counterup.min.js"></script>

        <!-- Chart JS -->
        <script src="<?php echo $cfg_baseurl; ?>assets/chart.js/chart.bundle.js"></script>

        <!-- init dashboard -->
        <script src="<?php echo $cfg_baseurl; ?>assets/pages/jquery.dashboard.init.js"></script>


        <!-- App js -->
        <script src="<?php echo $cfg_baseurl; ?>assets/js/jquery.core.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/js/jquery.app.js"></script>


        <script type="text/javascript">
        /* ==============================================
             Counter Up
             =============================================== */
            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });
            });
        </script>
        <script>
  $(function () {
    "use strict";

    // LINE CHART
    var line = new Morris.Line({
      element: 'line-chart',
      resize: true,
      data: [
        {y: '<?php echo $today; ?>', x: <?php echo mysqli_num_rows($check_order_today); ?>, z: <?php echo mysqli_num_rows($check_orderp_today); ?>},
        {y: '<?php echo $oneday_ago; ?>', x: <?php echo mysqli_num_rows($check_order_oneday_ago); ?>, z: <?php echo mysqli_num_rows($check_orderp_oneday_ago); ?>},
        {y: '<?php echo $twodays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_twodays_ago); ?>,z: <?php echo mysqli_num_rows($check_orderp_twodays_ago); ?>},
        {y: '<?php echo $threedays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_threedays_ago); ?>,z: <?php echo mysqli_num_rows($check_orderp_threedays_ago); ?>},
        {y: '<?php echo $fourdays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_fourdays_ago); ?>, z: <?php echo mysqli_num_rows($check_orderp_fourdays_ago); ?>},
        {y: '<?php echo $fivedays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_fivedays_ago ); ?> ,z: <?php echo mysqli_num_rows($check_orderp_fivedays_ago ); ?>},
        {y: '<?php echo $sixdays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_sixdays_ago); ?>, z: <?php echo mysqli_num_rows($check_orderp_sixdays_ago); ?>},
        {y: '<?php echo $sevendays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_sevendays_ago); ?>, z: <?php echo mysqli_num_rows($check_orderp_sevendays_ago); ?>}           
      ],
      xkey: 'y',
      ykeys: ['x','z'],
      labels: ['Total Pembelian Sosmed','Total Pembelian Pulsa'],
      lineColors: ['#f8ac59','#0000FF'],
      hideHover: 'auto'
    });
  });
</script>
<script src='https://code.responsivevoice.org/responsivevoice.js'></script>
<script>
var say = '<?php echo $berita3; ?>';
var voice = 'Indonesian Female';
setTimeout(responsiveVoice.speak(say, voice),5000);
</script>
</body>
</html>
<!--
//#################################################
//# Created : Muhammad Ripal Nugraha - Se7Code
//# Rilis   : 10 - 10 - 2018
//# ©        HARAP TIDAK MERUBAH         ©
//# ©        HARAP HARGAI SAYA :)        ©
//# -        UU Nomor 28 Tahun 2014      -
//#################################################
-->    