
<form class="form-inline" role="form" method="POST" action="<?php echo base_url('register/doregister'); ?>">
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
        <?php
        $placeholder = '用户名(邮箱或手机号)';
        if($name){
            $placeholder =  $name;
        }

        ?>

    <div class="col-lg-6">
        <div class="well well-sm"><strong><span class="glyphicon glyphicon-asterisk"></span>Required Field</strong></div>
        <div class="form-group">
            <label for="InputName"></label>
            <div class="input-group">
                <input type="email" name="u" class="form-control" placeholder="<?php echo $placeholder; ?>" required>
                <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
            </div>
        </div>
        <div class="form-group">
            <label for="InputEmail"></label>
            <div class="input-group">
                <input type="password" name="p" class="form-control" placeholder="密码" required>
                <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
            </div>
        </div>

        <input type="submit" name="submit" id="submit" value="提交" class="btn btn-info pull-right">
    </div>
</form>
<!--
<div class="col-lg-5 col-md-push-1">
    <div class="col-md-12">
        <div class="alert alert-success">
            <strong><span class="glyphicon glyphicon-ok"></span> Success! Message sent.</strong>
        </div>
        <div class="alert alert-danger">
            <span class="glyphicon glyphicon-remove"></span><strong> Error! Please check all page inputs.</strong>
        </div>
    </div>
</div>
-->