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
<link rel="stylesheet" href="<?php echo base_url();?>statics/third-party/jgrowl/jquery.jgrowl.min.css">
<script language="javascript" src="<?php echo base_url('static/js/bootstrap.min.js'); ?>"></script> 
<title><?php echo $title;?></title>
<script language="javascript">
var __BASEURL = "<?php echo base_url(); ?>";
</script>
  </head>
  <body>



<nav class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">如数云科技</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right" style="margin-right:30px;">
<?php
$avatar = base_url() . "statics/img/default.avatar.png";
if($profile['avatar']){
    $avatar = $profile['avatar'];
}
?>
    <li class="dropdown">
        <a href="" style="padding-top:8px;padding-bottom:0px;" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo $avatar; ?>" alt="头像" class="img-circle"></a>
            <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo base_url('users/profile'); ?>" id="profile">个人信息</a></li>
                <li><a href="<?php echo base_url('users/avatar'); ?>" id="avatar">修改头像</a></li>
                <li><a href="<?php echo base_url('users/password'); ?>" id="avatar">修改密码</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url('users/logout'); ?>">注销</a></li>
              </ul>
</li>
          </ul>
        </div>
      </div>
    </nav>

<div class="container" style="margin-top:10px;">
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
<script src="<?php echo base_url();?>statics/third-party/jgrowl/jquery.jgrowl.min.js"></script>
<script langauge="javascript">
function show_notify(msg, life){
    if(!life || life ==undefined)
        life = 1000;
    $.jGrowl(msg, {'life' : life});
}
</script>
</body>
</html>
