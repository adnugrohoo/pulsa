
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
    <?php $this->load->view('template/v_header') ?>
</head>
<body>
    <div id="wrapper">
        <?php $this->load->view('template/v_top_nav')?>
        <?php $this->load->view('template/v_main_nav')?>
        <?php $this->load->view($body)?>
        <?php $this->load->view('template/v_control_sidebar')?>
        
        <footer class="main-footer">
            <?php $this->load->view('template/v_footer')?>
        </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
</body>
</html>