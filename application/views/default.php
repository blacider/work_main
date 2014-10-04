<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--
    <meta charset="utf-8">
    -->
    <base href="<?php echo base_url();?>">
    <!-- Le styles -->
    <link href="<?php echo base_url();?>statics/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/docs3.css" rel="stylesheet">
    <script src="<?php echo base_url('statics/js/jquery.min.js');?>"></script>
    <script language="javascript" src="<?php echo base_url('statics/js/bootstrap.min.js'); ?>"></script>
    <title><?php echo $title;?></title>
    <script language="javascript">
    var __BASEURL = "<?php echo base_url(); ?>";
    </script>
  </head>
  <body>



<div class="container">
  <div class="row">
      <?php echo $body; ?>
  </div>
</div>







<footer class="bs-footer" role="contentinfo">
      <div class="container">
    <p>版权所有 &copy; 2014 北京如数云科技有限公司</p>
      </div>
    </footer>
</div><!--/.fluid-container-->
</body>
</html>
