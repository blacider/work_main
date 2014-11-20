<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--
    <meta charset="utf-8">
    -->
    <base href="<?php echo base_url();?>">
    <!-- Le styles -->
    <!-- <link href="<?php echo base_url();?>res/css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- jQuery -->
    <script src="res/js/jquery.js"></script>
    <!-- Bootstrap Core CSS -->
    <link href="res/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="res/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="res/css/plugins/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="res/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="res/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="res/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<link rel="stylesheet" href="<?php echo base_url();?>res/third-party/jgrowl/jquery.jgrowl.min.css">

<!--
<script src="<?php echo base_url('res/js/jquery.js');?>"></script>
<script language="javascript" src="<?php echo base_url('res/js/bootstrap.min.js'); ?>"></script> 
-->
<title><?php echo $title;?></title>
<script language="javascript">
var __BASEURL = "<?php echo base_url(); ?>";
</script>
  </head>
  <body>


 <div id="wrapper">
    <?php echo $nav; ?>
    <div id="page-wrapper" style="min-height: 754px;">
      <div class="row">
        <div class="col-lg-12">
              <?php echo $body; ?>
        </div>
      </div>
    </div>

</div>







<footer class="bs-footer" role="contentinfo">
      <div class="container">
    <p>版权所有 &copy; 2014 北京如数科技有限公司</p>
      </div>
    </footer>
</div><!--/.fluid-container-->


    <!-- Bootstrap Core JavaScript -->
    <script src="res/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="res/js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="res/js/plugins/morris/raphael.min.js"></script>
    <script src="res/js/plugins/morris/morris.min.js"></script>
    <script src="res/js/plugins/morris/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="res/js/sb-admin-2.js"></script>
<script src="<?php echo base_url();?>res/third-party/jgrowl/jquery.jgrowl.min.js"></script>
<script langauge="javascript">
function show_notify(msg, life){
    if(!life || life ==undefined)
        life = 1000;
    $.jGrowl(msg, {'life' : life});
}
</script>
</body>
</html>
