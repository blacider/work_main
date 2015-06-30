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
                <a href="#">类目设置</a>
                -->
                <a href="<?php echo base_url('login/dologout'); ?>">退出</a>
            </div>
        </div>
    </div>
</div>

<div class="clear menu_wrap">
    <div class="box menu"> 
        <a id="items" href="<?php echo base_url('items'); ?>">费用明细</a> 
        <a id="reports" href="<?php echo base_url('reports'); ?>">报告审批</a> 
        <a id="bills" href="<?php echo base_url('bills'); ?>">财务核算</a> 
        <a id="groups" href="<?php echo base_url('groups'); ?>">成员管理</a> 
        <!-- <a id="roles" href="<?php echo base_url('roles'); ?>">规则设定</a>-->
    </div>
</div>
<script language="javascript">
$(document).ready(function(){
    var _path = window.location.pathname;
    if(_path.substr(0, 8) == "/reports") {
        _path = "/reports";
    }
    $('#' + _path.substr(1)).addClass('active');
});
</script>
