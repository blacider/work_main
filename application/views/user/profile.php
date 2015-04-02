<div class="clear box mainTable">
    <div class="clear item">
        <div class="item_hd"><span class="fl tit">我的资料</span><span class="fr btn" id="save_profile"><a href="javascript:void(0)" class="br3">保存</a></span></div>
        <div class="item_form item_form_1">
            <form id="profile_form" class="form-horizontal" role="form" method="post" action="<?php echo base_url('users/update_profile'); ?>">
            <ul>
                <li class="first"><span class="fl tit">头像</span>
                <div class="fl con">
<?php 

$user = $this->session->userdata('user');
?>
<img src="<?php echo $user['avatar'];?>" />
                </div>
                </li>
                <li><span class="fl tit">昵称</span>
                <div class="fl con">
                    <input name="nickname" type="text" class="br3 inp" placeholder="<?php echo $user['nickname']; ?>" />
                </div>
                </li>
                <li><span class="fl tit">邮箱</span>
                <div class="fl con">
<?php 
$email = $user['email']; 
if(!$email) 
    $email = '邮箱';
?>
<input name="email" type="text" class="br3 inp" placeholder="<?php echo $email; ?>" />
                </div>
                </li>
                <li><span class="fl tit">电话</span>
                <div class="fl con">
<?php 
$phone = $user['phone'];
if(!$phone) 
    $phone = '手机';
?>
<input name="phone" type="text" class="br3 inp" placeholder="<?php echo $phone; ?>" />
                </div>
                </li>
                <!--
                <li class="last"><span class="fl tit">职位</span>
                <div class="fl con">
                    <div class="br3 selectItem">
                        <select name="">
                            <option>职员</option>
                        </select>
                    </div>
                </div>
                </li>
                -->
            </ul>
        </form>
        </div>
    </div>
    <div class="clear item">
        <div class="item_hd"><span class="fl tit">我的密码</span><span class="fr btn" id="updatebtn"><a href="javascript:void(0)" class="br3">保存</a></span></div>
        <form id="password_form" class="form-horizontal" role="form" method="post" action="<?php echo base_url('users/update_password'); ?>">
        <div class="item_form item_form_2">
            <ul>
                <li><span class="fl tit">旧密码</span>
                <div class="fl con">
                    <input name="old_password" type="password" class="br3 inp" placeholder="旧密码" />
                </div>
                </li>
                <li><span class="fl tit">新密码</span>
                <div class="fl con">
                    <input name="password" type="password" class="br3 inp" placeholder="新密码" />
                </div>
                </li>
                <li><span class="fl tit">重复新密码</span>
                <div class="fl con">
                    <input name="repassword" type="password" class="br3 inp" placeholder="重复新密码" />
                </div>
                </li>
            </ul>
        </div>
    </form>
    </div>
</div>
<script language="javascript">
$(document).ready(function(){
    $('#save_profile').click(function(){
        $('#profile_form').submit();
    });
    $('#updatebtn').click(function(){
        $('#password_form').submit();
    });
});
</script>
