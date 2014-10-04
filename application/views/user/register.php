<style type="text/css">
     body {
     padding-top: 40px;
     padding-bottom: 40px;
     background-color: #f5f5f5;
 }

     .form-signin {
         text-align:center;
         max-width: 350px;
 padding: 19px 29px 29px;
 margin: 0 auto 20px;
     background-color: #fff;
 border: 1px solid #e5e5e5;
     -webkit-border-radius: 5px;
     -moz-border-radius: 5px;
     border-radius: 5px;
     -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
     -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
     box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
     .form-signin .form-signin-heading,
     .form-signin .checkbox {
         margin-bottom: 10px;
      }
     .form-signin input[type="text"],
     .form-signin input[type="password"] {
         font-size: 16px;
 height: auto;
     margin-bottom: 15px;
 padding: 7px 9px;
      }

     .line {
         text-align: center;
 margin: 15px 0 10px 0;
 background: url('<?php echo base_url("/static/img/line.gif"); ?>') center repeat-x;
     margin-bottom : 20px;
      }
     h2 span {
     background: #FFF;
     color: #0067cc;
     padding: 0 20px;
     }

</style>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
     <!--[if lt IE 9]>
<script src="../assets/js/html5shiv.js"></script>
<![endif]-->


<div class="container">
<form class="form-signin" method="POST" action="<?php echo base_url('register/doregister'); ?>">
<?php
if(isset($errors) && !empty($errors)){
?>

    <div class="alert alert-block alert-error fade in">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>出错啦!</strong>
        <?php echo $errors; ?>
        </div>
<?php
}
?>
<h2 class="form-signin-heading line">
    <span>注册</span>
    </h2>
    <div>
    <input type="text" name='u' class="form-control" placeholder="用户名(邮箱或手机号)">
    <input type="password" name='p' class="form-control" placeholder="密码">
    <div align = "left" >
    </div>
    <button class="btn btn-success" type="submit">注册</button>
    <?php /*<a href="<?php echo base_url();?>/user/register" class="btn  btn-primary">注册</a> */?>
    </div>
    </form>

    </div> <!-- /container -->
