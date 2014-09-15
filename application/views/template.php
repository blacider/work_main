<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--
	<meta charset="utf-8">
	-->
    <base href="<?php echo base_url();?>">
    <!-- Le styles -->
    <link href="<?php echo base_url();?>static/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>static/css/docs3.css" rel="stylesheet">
    <script src="<?php echo base_url('static/js/jquery.min.js');?>"></script>
    <script language="javascript" src="<?php echo base_url('static/js/bootstrap.min.js'); ?>"></script> 
    <title><?php echo $title;?></title>
    <script language="javascript">
      var __BASEURL = "<?php echo base_url(); ?>";
    </script>
  </head>
  <body>


    <header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
      <div class="container">
	<div class="navbar-header">
	  <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
	    <span class="sr-only"><img src="<?php echo base_url('static/img/logo.png'); ?>"></a>Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a href="/" class="navbar-brand">如数云报销</a>
</div>
<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
</nav>
</div>
</header>


<div class="container">
  <div class="row">
    <div class="col-md-3 bs-docs-sidebar">
    </div>
<?php echo $menu; ?>
    <div class="col-md-9">
      <?php echo $body; ?>
    </div>
  </div>
</div>







<footer class="bs-footer" role="contentinfo">
      <div class="container">
	<p>版权所有 &copy; 2014 北京如数科技有限公司</p>
      </div>
    </footer>
</div><!--/.fluid-container-->
</body>
</html>
