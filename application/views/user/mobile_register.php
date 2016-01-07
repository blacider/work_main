
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

    <fieldset>
        <legend align="center">注册</legend>

    <div>
        <?php
        $placeholder = '用户名(邮箱或手机号)';
        if($name){
            $placeholder =  $name;
        }

        ?>

    <div class="col-lg-6">
        <div class="form-group">
            <label for="InputName"></label>
            <div class="input-group">
                <input type="text" name="u" class="form-control" placeholder="<?php echo $placeholder; ?>" required>
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
        <input type="submit" style="clear: left; width: 100%;  font-size: 13px;" name="submit" id="submit" value="提交" class="btn btn-info pull-right">
    </div>
    </fieldset>
</form>
