<div class="header_wrap">
    <div class="box header">
        <div class="fl header_logo"><a href="/"><img src="/static/images/logo.png" /></a></div>
<?php
$user = $this->session->userdata('user');
if(!$user) redirect(base_url('login'));
if(is_array($user)){
    $username = $user['email'];
if($user['nickname']){
    $username = $user['nickname'];
}
} else {
$username = $user->username;
if($user->nickname){
    $username = $user->nickname;
}
}
?>
        <div class="fr header_user"> 

            <span class="fl header_user_face"><img src="<?php echo $user['avatar']; ?>" /><i></i></span> 
            <span class="fl header_user_mail">
<?php
echo $username;
?>
                </span>
            <div class="br3 header_user_pop">
                <a href="<?php echo base_url('users/profile'); ?>">个人资料</a>
                <!--
                <a href="#">支付设置</a>
                <a href="#">类别设置</a>
                -->
                <a href="<?php echo base_url('login/dologout'); ?>">退出</a>
            </div>
        </div>
    </div>
</div>

<div class="clear menu_wrap">
    <div class="box menu"> 
        <a id="users_profile" href="<?php echo base_url('users/profile'); ?>">个人资料</a> 
    </div>
</div>
<script language="javascript">
$(document).ready(function(){
    var _path = window.location.pathname;
    var _id = _path.substr(1).replace("/", "_");
    $('#' + _id).addClass('active');
});
</script>
