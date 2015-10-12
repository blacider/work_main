
<div id="navbar" class="navbar navbar-default" style="background:#2C3E50;">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<!-- #section:basics/sidebar.mobile.toggle -->
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
					<span class="sr-only">Toggle sidebar</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
                            <div>
                                <div class="home-logo"></div>
                                <!-- 
                                <div style="
                                    float:left;vertical-align:top;min-height:25px;margin-top:2px">
                                    <img src="/static/images/logo_1.png" style="min-height:25px;height:25px;"/> 
                                </div>
                                -->
                                <div style="float:right;margin-left:10px;margin-top:5px;font-size:14px;font-weight:normal">
                                    <?php if($groupname) { echo " · &nbsp;&nbsp;" . $groupname;} ?>
                                </div>
                            </div>
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">

<?php
$user = $this->session->userdata('user');
if(!$user) redirect(base_url('login'));
$_security = 0;
if(array_key_exists('risk', $user) && $user['risk'] == 1) {
    $_security = 1;
}
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

<?php 
$path = "http://reim-avatar.oss-cn-beijing.aliyuncs.com/" . $user['apath'];
if("" == $user['apath']) {
    $path = base_url('/static/default.png');
} else {
    $path = $user['apath']; 
    //if(1 == $user['abs_path']){
    //}
}
?>
						<!-- #section:basics/navbar.user_menu -->
						<li class="light-blue" style="background:#2C3E50">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle" style="background:#2C3E50">
                                <img class="nav-user-photo" src="<?php echo $path; ?>">
								<span class="user-info" style="top:13px;">
                                    <?php echo $username; ?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
                                <a href="<?php echo base_url('users/profile'); ?>">
										<i class="ace-icon fa fa-info-circle"></i>
										个人信息
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="<?php echo base_url('login/dologout'); ?>">
										<i class="ace-icon fa fa-power-off"></i>
										退出
									</a>
								</li>
							</ul>
						</li>

						<!-- /section:basics/navbar.user_menu -->
					</ul>
				</div>

				<!-- /section:basics/navbar.dropdown -->
			</div><!-- /.navbar-container -->
		</div>
        <div class="main-container" id="main-container">
            <script type="text/javascript">
            try{ace.settings.check('main-container' , 'fixed')}catch(e){}
            </script>

<div id="sidebar" class="sidebar                  responsive">
<script type="text/javascript">
try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
</script>
<script type="text/javascript">
	var uname = "<?php echo $user['email']; ?>";
//	$.cookie("user",uname);
</script>
<!--
<div class="sidebar-shortcuts" id="sidebar-shortcuts">
    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
        <button class="btn btn-success img-circle">
            <i class="ace-icon fa fa-dashboard"></i>
        </button>

         <button class="btn btn-info" onClick="window.open('https://www.yunbaoxiao.com/help.html#one')" > 
               <i class="ace-icon fa fa-question-circle"></i>
               </button>

        <button class="btn btn-warning">
            <i class="ace-icon fa fa-comments"></i>
        </button>

        <button class="btn btn-danger" onClick="location.href='<?php echo base_url('users/profile'); ?>'">
                <i class="ace-icon fa fa-gears"></i>
        </button>

    </div>

    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
        <span class="btn btn-success"></span>

        <span class="btn btn-info"></span>

        <span class="btn btn-warning"></span>

        <span class="btn btn-danger"></span>
    </div>
</div>
-->
<ul class="nav nav-list">

    <li class="hsub" id="items" >
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-list-alt"></i>
        <span class="menu-text"> 消费 </span>

        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu nav-show" style="display: block;">
        <li class="hsub" id="newitem">
        <a href="<?php echo base_url('items/newitem'); ?>" >
            <i class="menu-icon fa fa-caret-right"></i>
            新建消费
        </a>

        <b class="arrow"></b>

        </li>
        <li class="hsub"  id="index">
        <a href="<?php echo base_url('items'); ?>">
            <i class="menu-icon fa fa-caret-right"></i>
            我的消费
        </a>

        <b class="arrow"></b>

        </li>
    </ul>
    </li>




    <li class="hsub" id="reports">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-file-text"></i>
        <span class="menu-text"> 报告 </span>

        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu nav-show" style="display: block;">
        <li class="hsub" id="newreport">

<?php if(count($report_templates) > 0) { ?>
        <a href="#"  class="dropdown-toggle">
            <i class="menu-icon fa fa-caret-right"></i>
            新建报告 
        </a>
<?php } else { ?>
        <a href="<?php echo base_url('reports/newreport'); ?>" >
            <i class="menu-icon fa fa-caret-right"></i>
            新建报告
        </a>
<?php } ?>

        <b class="arrow"></b>
<?php if(count($report_templates) > 0) { ?>
<ul class="submenu rushumenu">
<?php foreach($report_templates as $r) { ?>
                                    <li class="">
                                        <a href="<?php echo base_url('reports/report_template/' . $r['id']); ?>">
<?php echo $r['name']; ?>
                                        </a>

                                        <b class="arrow"></b>
                                    </li>
<?php } ?>
</ul>

<?php } ?>
        </li>
        <li class="hsub" id="index">
        <a href="<?php echo base_url('reports'); ?>" >
            <i class="menu-icon fa fa-caret-right"></i>
            我的报告
        </a>

        <b class="arrow"></b>

        </li>
        <li class="hsub" id="audit">
        <a href="<?php echo base_url('reports/audit'); ?>" >
            <i class="menu-icon fa fa-caret-right"></i>
             收到的报告
        </a>

        <b class="arrow"></b>

        </li>
    </ul>
    </li>






<?php
$open = 1;
$close_directly = 0;
if($profile['gid'] > 0){
    $_config = $profile['group']['config'];
    if($_config) {
        $config = json_decode($_config, True);

        if(array_key_exists('private_structure', $config) && $config['private_structure'] == 1){
            $open = 0;
        }
        if(array_key_exists('close_directly', $config) && $config['close_directly'] == 1){
            $close_directly = 1;
        }
    }
}
if($open == 0 && $profile['admin'] > 0){ 
    $open = 1;
}
if($open == 1) {
?>

    <li class="hsub" id="members">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-users"></i>
        <span class="menu-text"> 员工和部门 </span>

        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu nav-show" style="display: block;">

        <li class="hsub" id="index">
        <a href="<?php echo base_url('members/index'); ?>" >
            <i class="menu-icon fa fa-caret-right"></i>
            组织结构
        </a>
        <b class="arrow"></b>
        </li>

        <li class="rsmenu" id="groups">
        <a href="<?php echo base_url('members/groups'); ?>">
            <i class="menu-icon fa fa-caret-right"></i>
            <span class="menu-text"> 公司部门 </span>
        </a>

        <b class="arrow"></b>
        </li>
<?php 
if($profile['admin'] == 1 || $profile['admin'] == 3){
?>
        <li class="hsub" id="newrank">
        <a href="<?php echo base_url('members/rank'); ?>" >
            <i class="menu-icon fa fa-caret-right"></i>
           职位设置 
        </a>

        <b class="arrow"></b>

        </li>
        <li class="hsub" id="newmember">
        <a href="<?php echo base_url('members/newmember'); ?>" >
            <i class="menu-icon fa fa-caret-right"></i>
            添加员工
        </a>

        <b class="arrow"></b>

        </li>
        <li class="hsub" id="add">
        <a href="<?php echo base_url('members/add'); ?>" >
            <i class="menu-icon fa fa-caret-right"></i>
            添加部门
        </a>

        <b class="arrow"></b>

        </li>


         <li class="hsub" id="delmembers">
        <a href="<?php echo base_url('members/delmembers'); ?>" >
            <i class="menu-icon fa fa-caret-right"></i>
            删除员工
        </a>

        <b class="arrow"></b>

        </li>



        <li class="hsub" id="batch_del">
        <a href="<?php echo base_url('members/batch_del'); ?>" >
            <i class="menu-icon fa fa-caret-right"></i>
            批量删除员工
        </a>

        <b class="arrow"></b>

        </li>

    

        <li class="hsub" id="export">
        <a href="<?php echo base_url('members/export'); ?>" >
            <i class="menu-icon fa fa-caret-right"></i>
            导入/导出员工
        </a>

        <b class="arrow"></b>

        </li>
        <?php } ?>
    </ul>
    </li>

<?php
}
?>

<?php 
if($profile['admin'] > 0){
if($profile['admin'] == 1 || $profile['admin'] == 3){
?>

    <li class="hsub" id="category">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-tags"></i>
        <span class="menu-text"> 账套和标签 </span>

        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu nav-show" style="display: block;">
       <!-- <li class="hsub" id="newreport"> 
        <a href="<?php echo base_url('tags/newtags'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 新建标签 </a> 
        <b class="arrow"></b> 
        </li> -->

        <li class="hsub" id="account_set">
        <a href="<?php echo base_url('category/account_set'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 账套管理 </a>
        <b class="arrow"></b>
        </li>

        <li class="hsub" id="cexport">
        <a href="<?php echo base_url('category/cexport'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 账套导入/导出 </a>
        <b class="arrow"></b>
        </li>
<!--
        <li class="hsub" id="index">
        <a href="<?php echo base_url('category'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 分类管理 </a>
        <b class="arrow"></b>
        </li>
-->

        <li class="hsub" id="tags">
        <a href="<?php echo base_url('category/tags'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 标签管理 </a>
        <b class="arrow"></b>
        </li>
    </ul>
    </li>


    <li class="hsub" id="company">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-institution"></i>
        <span class="menu-text"> 公司设置 </span>

        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu nav-show" style="display: block;">
<!--

        <li class="hsub" id="report_settings_list">
        <a href="<?php echo base_url('company/report_settings_list'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 报告设置</a>
        <b class="arrow"></b>
        </li>

        <li class="hsub" id="approval_flow">
        <a href="<?php echo base_url('company/approval_flow'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 财务审批流</a>
        <b class="arrow"></b>
        </li>
-->
        <li class="hsub" id="broadcast_index">
        <a href="<?php echo base_url('broadcast/index'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 系统消息管理 </a>
        <b class="arrow"></b>
        </li>
        <li class="hsub" id="broadcast_create">
        <a href="<?php echo base_url('broadcast/create'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 创建系统消息</a>
        <b class="arrow"></b>
        </li>

  <li class="hsub" id="show">
        <a href="<?php echo base_url('company/show'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 提交规则 </a>
        <b class="arrow"></b>
        </li>


        <li class="hsub" id="show_approve">
        <a href="<?php echo base_url('company/show_approve'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 审批规则 </a>
          <b class="arrow"></b>
        </li> 

    </ul>
    </li>

<?php  } 
if($profile['admin'] == 1 || $profile['admin'] == 2) {
?>

    <li class="hsub" id="bills">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-copy"></i>
        <span class="menu-text"> 公司报销详情 </span>

        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu nav-show" style="display: block;">

        <li class="hsub" id="all_reports">
        <a href="<?php echo base_url('bills/all_reports'); ?>" >所有报销</a>

        <b class="arrow"></b>
        </li>

        <li class="hsub" id="in_progress">
        <a href="<?php echo base_url('bills/in_progress'); ?>" >审核中</a>

        <b class="arrow"></b>
        </li>

        <li class="hsub" id="index">
        <a href="<?php echo base_url('bills/index'); ?>" >待结算</a>

        <b class="arrow"></b>
        </li>


        <li class="hsub" id="exports">
        <a href="<?php echo base_url('bills/exports'); ?>" > 已结束</a>
        <b class="arrow"></b>
        </li>

    </ul>
    </li>

<?php  } 

if($profile['admin'] == 1 || $profile['admin'] == 2) {
?>

    <li class="hsub" id="finance">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-money"></i>
        <span class="menu-text"> 财务审批 </span>

        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu nav-show" style="display: block;">

        <li class="hsub" id="finance_flow">
        <a href="<?php echo base_url('bills/finance_flow'); ?>" >待审批</a>

        <b class="arrow"></b>
        </li>

        <li class="hsub" id="finance_done">
        <a href="<?php echo base_url('bills/finance_done'); ?>" >已审批</a>

        <b class="arrow"></b>
        </li>
    </ul>
    </li>

<?php  } 
}
?>




<!--

<li class="rsmenu" id="groups">
<a href="<?php echo base_url('groups'); ?>">
<i class="menu-icon fa fa-users"></i>
<span class="menu-text"> 用户组管理 </span>
</a>

<b class="arrow"></b>
</li>

<li class="rsmenu" id="rules">
<a href="<?php echo base_url('rules'); ?>">
<i class="menu-icon fa fa-users"></i>
<span class="menu-text"> 规则管理</span>
</a>

<b class="arrow"></b>
</li>
-->


</ul>
</li>
</ul><!-- /.nav-list -->

<!-- #section:basics/sidebar.layout.minimize -->
<!-- 
<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
</div>
-->


<!-- /section:basics/sidebar.layout.minimize -->
<script type="text/javascript">
try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
</script>

</div> 

<div class="main-content">


    <div class="breadcrumbs" id="breadcrumbs">
<script type="text/javascript">
try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
</script>

<ul class="breadcrumb" style="margin-top: 10px;">
<?php 
foreach($breadcrumbs as $b){
?>
<?php if("" == $b['url']) { ?>
    <li class="active">
    <?php } else { ?>
    <li>
    <?php } ?>
    <?php if("" != $b['class']) { ?>
    <i class="<?php echo $b['class']; ?>"></i>
    <?php  } 
    if("" != $b['url']) {
    ?>
    <a href="<?php echo $b['url']; ?>"><?php echo $b['name']; ?></a>
    <?php } else { ?>
    <?php echo $b['name']; ?>
    <?php }?>

    </li>
<?php
}
?>

</ul><!-- /.breadcrumb -->

<!-- #section:basics/content.searchbox -->
<!--
<div class="nav-search" id="nav-search">
    <form class="form-search">
        <span class="input-icon">
            <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off">
            <i class="ace-icon fa fa-search nav-search-icon"></i>
        </span>
    </form>
</div>
-->
<!-- /.nav-search -->

<!-- /section:basics/content.searchbox -->
<style type="text/css">
    .modal-body-item {
        text-align: center;
        width: 100%;
        padding: 10px 50px;
    }
    .form-line- ,.form-line-2{
        height: 45px;
    }
    .form-line- input{
        margin-left: 19px;
    width: 250px;
    height: 30px;
    border-radius: 6px !important;
    }
    .form-line-2 {
         padding-top: 12px;
          padding-left: 55px;
    }
    .form-line-2 label {
        width: 41px;
        border-top: 5px solid grey;
            margin-right: 5px;
    }
</style>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
<div class="modal fade" id="security_dialog">
  <div class="modal-dialog" style="width: 376px;font-size: 13px;">
    <div class="modal-content" style="border-radius: 5px;padding-top: 13px;">
    

        <div class="modal-body-item">
            <img style="margin: 15px;width: 46px;" src="/static/images/Bitmap@2x.png" alt="png">
            <p style="text-align: left;">您现在的登录密码安全性较差，请修改登录密码后再进行报销。</p>    
        

        </div>
      
        <hr style="margin: 0;">
        <div class="modal-body-item">
            <p onclick="$('#security_dialog').modal('hide');$('#security_reset').modal('show');" style="cursor: pointer;text-align: center;color:red;margin:0;">好，去修改</p>
        </div>
    


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
var EMAIL = "<?php echo $user['email']?>";
var PHONE = "<?php echo $user['phone']?>";
function checkNewPassword() {
    var pwd = $("#newPassword").val();
    if (pwd == "") {
        $(".form-line-2 label").css('border-top', '5px solid grey');
        return false;
    }
    result = 0;
    if (pwd.length >= 8) result++;
    var reg = /^([a-zA-Z]+|[0-9]+)$/;
    if(!reg.test(pwd)) result++;
    var x;
    if (EMAIL != "") x = EMAIL.split('@')[0];
    else x = PHONE;
    if (x != pwd) result++;

    changePwdLevel(result-1);
    if (result == 3) {
        $('#wrong-error').css('visibility', 'hidden');
        return true;
    }
    else {
        $('#wrong-error').css('visibility', 'visible');
        return false;
    }
}
function changePwdLevel(level) {
    $(".form-line-2 label").css('border-top', '5px solid grey');
    while (level >= 0) {
        $($(".form-line-2 label")[level]).css('border-top', '5px solid green');
        level--;
    }
    
}
function resetPasswardSubmit() {
    if (checkNewPassword())
        $('#security_reset').find("input[type='submit']").click();
}
</script>
<div class="modal fade" id="security_reset">
  <div class="modal-dialog" style="width: 450px;font-size: 13px;">
    <div class="modal-content" style="border-radius: 5px;padding-top: 13px;">
        <form action='<?php echo base_url("company/create_approve/");  ?>' method="post" enctype="multipart/form-data">
        <div class="modal-body-item">
            <div class="form-line-">
                <label>原密码</label><input name="old" type="text">
            </div>
            <div class="form-line-">
                <label>新密码</label><input id="newPassword" onkeyup="checkNewPassword()" name="new" placeholder="请输入6-16位数字、字母、或常用符号" type="text">
            </div>
            <div class="form-line-2">
                <label>弱</label>
                <label>中</label>
                <label>强</label>
                <span id="wrong-error" style="color:red;visibility:hidden;width: auto;border: none;position: relative;top: -10px;left: 16px;">密码格式有误</span>
            </div>
        </div>
        <hr style="margin: 0;">
        <div class="modal-body-item">
            <input type="submit" class="hidden">
            <p onclick="resetPasswardSubmit()" style="cursor: pointer;text-align: center;color:red;margin:0;">确定</p>
        </div>
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
function show_notify(msg, life){
    if(!life || life ==undefined)
        life = 3000;
    $.jGrowl(msg, {'life' : life});
}
var _security = <?php echo $_security; ?>;
$(document).ready(function(){
    if(_security == 1) {
        $('#security_dialog').modal({
            'keyboard' : false
                ,'backdrop' : false
        });
        $('#security_reset').modal({
            'keyboard' : false
                ,'backdrop' : false
        });
    }
    try{
    var _path = window.location.pathname;
    var buf = _path.split("/");
    buf.shift();
    var _controller = 'items';
    var _method = 'index';
    if(buf.length > 0) {
        _controller = buf[0];
    }
    if(buf.length > 1) {
        _method = buf[1];
    }
    
    // 导入导出有步骤，合并在一起
    if(_controller == 'broadcast') {
        _controller = 'company';
        _method = 'broadcast_' + _method;
    }
    if(_controller == "members" && _method == "imports"){
        _method = "export";
    }
    if(_controller == "members" && _method == "editmember"){
    	_method = "newmember";
	}
    if(_controller == "members" && _method == "editgroup"){
    	_method = "groups";
	}
    if(_controller == "bills" && _method == "finance_done"){
    	_controller = "finance";
	}
    if(_controller == "bills" && _method == "finance_flow"){
    	_controller = "finance";
	}
    if(_controller == "category" && _method == "sob_update")
    {
        _method = "account_set";
    }
    $('.hsub').each(function(){
        $(this).removeClass('active open');
    });
    $('.submenu').each(function(){
        $(this).hide();
    });
    if(_controller != '') {
        $('#' + _controller).addClass('active open');
        $('#' + _controller).children().each(function(){
            $(this).removeClass('active');
        });
        $($('#' + _controller).find('.submenu').get(0)).show();
        $($('#' + _controller).find('#' + _method).get(0)).addClass('active');
        if (_method == 'search' && _controller == 'members')
            $($('#' + _controller).find('#' + 'index').get(0)).addClass('active');
        if (_method == 'common' && _controller == 'company') {
            $($('#' + _controller).find('#' + 'submit').get(0)).addClass('active');
        }
    }
    /*
    if(_path.substr(0, 8) == "/reports") {
        _path = "/reports";
    }
    $('#' + _path.substr(1)).addClass('active');
     */
    }catch(e){}
});
</script>
