  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.2
    </div>
    <strong>Copyright &copy; 4l All rights
    reserved.
  </footer>

  
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?= $web_url ?>/admin/assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= $web_url ?>/admin/assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Query 3 -->
<script src="<?= $web_url ?>/admin/assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- DataTables -->
<script src="<?= $web_url ?>/admin/assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= $web_url ?>/admin/assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


<!-- AdminLTE for demo purposes -->
<script src="<?= $web_url ?>/admin/assets/dist/js/demo.js"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?= $web_url ?>/admin/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?= $web_url ?>/admin/assets/bower_components/raphael/raphael.min.js"></script>
<script src="<?= $web_url ?>/admin/assets/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?= $web_url ?>/admin/assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?= $web_url ?>/admin/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= $web_url ?>/admin/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= $web_url ?>/admin/assets/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= $web_url ?>/admin/assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?= $web_url ?>/admin/assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?= $web_url ?>/admin/assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= $web_url ?>/admin/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?= $web_url ?>/admin/assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= $web_url ?>/admin/assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= $web_url ?>/admin/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= $web_url ?>/admin/assets/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= $web_url ?>/admin/assets/dist/js/demo.js"></script>

<script>

$("#send-to").change(function () {
    if ($(this).val() == '2'){
        $(".user-recipient").removeClass('hide');
        return;
    }
    $(".user-recipient").addClass('hide');
});

  $(function () {
  $('.select2').select2();
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>