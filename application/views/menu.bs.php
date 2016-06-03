
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
                                <div style="float:right;margin-left:10px;margin-top:5px;font-size:14px;font-weight:normal">
                                    <?php if($groupname) { echo " · &nbsp;&nbsp;" . $groupname;} ?>
                                </div>
                            </div>
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation" style="position: relative;z-index: 999">
					<ul class="nav ace-nav">
                        <?php
                        $user = $this->session->userdata('profile');
                        $pid = $this->session->userdata('uid');
                        $_security = 0;
                        if(array_key_exists('risk', $user) && $user['risk'] == 1) {
                            $_security = 1;
                        }
                        $username = $user['email'];
                        if($user['nickname']){
                            $username = $user['nickname'];
                        }
                        ?>
						<!-- #section:basics/navbar.user_menu -->
						<li class="light-blue" style="background:#2C3E50">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle" style="background:#2C3E50">
                                <img class="nav-user-photo" src="<?php echo $user['avatar_url']; ?>">
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
</script>
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
        <span class="menu-text"> 报销单 </span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu nav-show" style="display: block;">
        <li class="hsub" id="newreport">
            <?php if(count($report_templates) > 1) { ?>
            <a href="javascript:void(0)"  class="dropdown-toggle">
                <i class="menu-icon fa fa-caret-right"></i>
                新建报销单
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <?php } else if(count($report_templates) == 1) { ?>
            <a href="<?php echo base_url('reports/add/' . $report_templates[0]['id']); ?>" >
                <i class="menu-icon fa fa-caret-right"></i>
                新建报销单
            </a>
            <?php } else { ?>
            <a href="<?php echo base_url('reports/add/0'); ?>" >
                <i class="menu-icon fa fa-caret-right"></i>
                新建报销单
            </a>
            <?php } ?>
            <b class="arrow"></b>
            <?php if(count($report_templates) > 1) { ?>
            <ul class="submenu rushumenu">
            <?php foreach($report_templates as $t) { ?>
                <li class="" id="<?php echo 'report'.$t['id'];?>">
                    <a href="<?php echo base_url('reports/add/' . $t['id']); ?>"> <?php echo $t['name']; ?> </a>
                    <b class="arrow"></b>
                </li>
            <?php } ?>
            </ul>
            <?php } ?>
        </li>
        <li class="hsub" id="index">
        <a href="<?php echo base_url('reports'); ?>" >
            <i class="menu-icon fa fa-caret-right"></i>
            我的报销单
        </a>
        <b class="arrow"></b>
        </li>

        <li class="hsub" id="audit">
            <a href="#"  class="dropdown-toggle">
                <i class="menu-icon fa fa-caret-right"></i>
                收到的报销单
                <b class="arrow fa fa-angle-down"></b>
            </a>

            <ul class="submenu rushumenu">
                <li class="" id="audit_todo">
                    <a href="<?= base_url('reports/audit_todo'); ?>">
                    待处理
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="" id="audit_done">
                    <a href="<?= base_url('reports/audit_done'); ?>">
                    已处理
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
            <b class="arrow"></b>
        </li>
        <?php if (!isset($company_config['enable_report_cc']) || $company_config['enable_report_cc']) { ?>
        <li class="hsub" id="audit_cc">
        <a href="<?php echo base_url('reports/audit_cc'); ?>" >
            <i class="menu-icon fa fa-caret-right"></i>
            抄送给我的报销单
        </a>
        <b class="arrow"></b>
        </li>
        <?php } ?>

    </ul>
    </li>
<?php
$open = 1;
$close_directly = 0;
if($user['gid'] > 0){
    $_config = $user['group']['config'];
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
if($open == 0 && $user['admin'] > 0){
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
<?php
if($user['admin'] == 1 || $user['admin'] == 3){
?>

        <li class="hsub" id="export">
        <a href="<?php echo base_url('members/export'); ?>" >
            <i class="menu-icon fa fa-caret-right"></i>
            导入/导出员工
        </a>

        <b class="arrow"></b>

        </li>

        <li class="hsub" id="newrank">
        <a href="<?php echo base_url('members/rank'); ?>" >
            <i class="menu-icon fa fa-caret-right"></i>
           级别职位设置
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
if($user['admin'] > 0){
if($user['admin'] == 1 || $user['admin'] == 3){
?>

    <li class="hsub" id="category">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-tags"></i>
        <span class="menu-text"> 账套设置 </span>

        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu nav-show" style="display: block;">
        <li class="hsub" id="account_set">
        <a href="<?php echo base_url('category/account_set'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 账套管理 </a>
        <b class="arrow"></b>
        </li>

        <li class="hsub" id="cexport">
        <a href="<?php echo base_url('category/cexport'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 导入账套 </a>
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

        <li class="hsub" id="approval_flow">
        <a href="<?php echo base_url('company/approval_flow'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 财务审批流</a>
        <b class="arrow"></b>
        </li>

        <li class="hsub" id="submit">
        <a href="<?php echo base_url('company/common'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 通用规则 </a>
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
        <li class="hsub" id="item_customization">
        <a href="<?php echo base_url('company/item_customization'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 消费设置 </a>
          <b class="arrow"></b>
        </li>
        <li class="hsub" id="report_template_list">
        <a href="<?php echo base_url('company/report_template_list'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 报销单模板 </a>
          <b class="arrow"></b>
        </li>

        <li class="hsub" id="broadcast_index">
        <a href="<?php echo base_url('broadcast/index'); ?>" ><i class="menu-icon fa fa-caret-right"></i> 公司消息 </a>
        <b class="arrow"></b>
        </li>
    </ul>
    </li>

<?php  }
if(in_array($user['admin'], [1,2,4])) {
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


        <li class="hsub" id="finished">
        <a href="<?php echo base_url('bills/finished'); ?>" > 已完成</a>
        <b class="arrow"></b>
        </li>

    </ul>
    </li>

<?php  }

if($user['admin'] == 1 || $user['admin'] == 2) {
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

        <!-- 财务查询微信支付 -->
        <?php if($company_pay_data['switch']['can_pay']==1) { ?>
        <li class="hsub" id="payflow">
            <a href="/bills/payflow" >流水查询</a>
            <b class="arrow"></b>
        </li>
        <?php } ?>
    </ul>
    </li>

<?php  }
}
?>




</ul>
</li>
</ul><!-- /.nav-list -->

<!-- #section:basics/sidebar.layout.minimize -->

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
    width: 260px;
    height: 30px;
    border-radius: 6px !important;
    }
    .form-line-2 {
          text-align: left;
    margin-left: 76px;
    }
    .form-line-2 label {
        width: 41px;
        border-top: 5px solid grey;
            margin-right: 5px;
    }
</style>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
<div class="modal fade" id="security_dialog" style="top:150px">
  <div class="modal-dialog" style="width: 376px;font-size: 13px;">
    <div class="modal-content" style="border-radius: 5px;padding-top: 13px;">


        <div class="modal-body-item">
            <img style="margin: 15px;width: 46px;" src="/static/images/Bitmap@2x.png" alt="png">
            <p style="text-align: left;">您现在的登录密码安全性较差，请修改登录密码后再进行报销。</p>


        </div>

        <hr style="margin: 0;">
        <div class="modal-body-item">
            <p onclick="$('#security_dialog').modal('hide');$('#security_reset').modal({'keyboard': false , 'backdrop':'static'});" style="cursor: pointer;text-align: center;color:red;margin:0;">好，去修改</p>
        </div>



    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
var __BASE = "<?php echo base_url();?>";
var EMAIL = "<?php echo $user['email']?>";
var PHONE = "<?php echo $user['phone']?>";
var is_click_submit = 0;
function checkNewPassword() {
    var pwd = $("#newPassword").val();
    if (pwd == "") {
        $(".form-line-2 label").css('border-top', '5px solid grey');
        return false;
    }
    result = 0;
    streth = -1;
    types = 0 ;
    if (pwd.length >= 8) result++;
    var reg = /^([a-zA-Z]+|[0-9]+)$/;
    var reg1 = /^(.*[a-z]+.*)$/;
    var reg2 = /^(.*[A-Z]+.*)$/;
    var reg3 = /^(.*[0-9]+.*)$/;
    var reg4 = /^(.*[^\w\s]+.*)$/;
    if(!reg.test(pwd)) result++;
    var x;
    if (EMAIL != "") x = EMAIL.split('@')[0];
    else x = PHONE;
    if (x != pwd) {
        result++;
    }

    if(pwd.length >= 8 && !reg.test(pwd)) streth = 0;
    if(pwd.length >= 10 && !reg.test(pwd)) streth = 1;

    if(reg1.test(pwd)) types++;
    if(reg2.test(pwd)) types++;
    if(reg3.test(pwd)) types++;
    if(reg4.test(pwd)) types++;

    if(streth >=0 && types >= 3) streth = 2;

    changePwdLevel(streth);
    if (result == 3) {
        $('#wrong-error').css('display', 'none');
        if ($("#old_password").val() == pwd) {
            if(is_click_submit)
            {
                $('#wrong-error').css('display', 'block').text("新密码不能与旧密码相同");
            }
            is_click_submit = 0;
            return false;
        }
        if ($("#reNewPassword").val() != pwd) {
            if(is_click_submit)
            {
                $('#wrong-error').css('display', 'block').text("两次输入不一致");
            }
            is_click_submit = 0;
            return false;
        }
        if ($("#old_password").val() == "") {
            if(is_click_submit)
            {
                $('#wrong-error').css('display', 'block').text("请输入原密码");
            }
            is_click_submit = 0;
            return false;
        }
        return true;
    }
    else {
        if(is_click_submit)
        {
            $('#wrong-error').css('display', 'block').text("至少8个字符，不可以是纯数字或纯字母");
        }
        is_click_submit = 0;
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
    is_click_submit = 1;
    if (checkNewPassword()) {
        $.ajax({
            url:__BASE + '/users/force_update_password',
            method:'post',
            dataType:'json',
            data:{'old_password':$('#old_password').val(),'password':$('#newPassword').val(),'repassword':$('#reNewPassword').val(),'pid':$('#pid').val()},
            success:function(data){
                if(data.status <= 0) {
                    $('#wrong-error').css('display', 'block').text(data.msg);
                } else {
                    window.location.reload();
                }
            },
            error:function(a,b,c){
            }
        });
    }
}
</script>
<div class="modal fade" id="security_reset" style="top:150px">
  <div class="modal-dialog" style="width: 450px;font-size: 13px;">
    <div class="modal-content" style="border-radius: 5px;padding-top: 13px;">
        <form role="form" method="post" action="<?php echo base_url('users/update_password'); ?>">
        <div class="modal-body-item">
            <div class="form-line-">
                <label>原密码</label><input onkeyup="checkNewPassword()" id="old_password" name="old_password" type="password">
            </div>
            <div class="form-line-">
                <label>新密码</label><input type="password" name="password" id="newPassword" onkeyup="checkNewPassword()" name="new" placeholder="至少8个字符，不可以是纯数字或纯字母">
            </div>
            <div class="form-line-">
                <label style="position: relative;left: -12px;">重复密码</label><input style="margin-left: 6px;" onkeyup="checkNewPassword()" name="repassword" id="reNewPassword" type="password" placeholder="重复新密码">
            </div>
            <div class="form-line-2">
                <label>弱</label>
                <label>中</label>
                <label>强</label>
	    </div>
	    <div style="text-align: left;margin-left: 76px;">
                <p id="wrong-error" style="display:none;color:red">密码格式有误</p>
            </div>
        </div>
            <input type="hidden" name="pid" value="<?php echo $pid;?>">
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
                ,'backdrop' : 'static'
        });
        /*
        $('#security_reset').modal({
            'keyboard' : false
                ,'backdrop' : false
        });
        */
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
    if(buf.length > 2)
    {
        _report_id = buf[2];
    }

    // 导入导出有步骤，合并在一起

    if(_method == "create_report_template" || _method == "update_report_template"){
        _method = "report_template_list";
    }
    if(_controller == "broadcast" && _method == "index"){
        _method = "broadcast_index";
        _controller = "company";
    }
    if(_controller == "broadcast" && _method == "update_info"){
        _method = "broadcast_index";
        _controller = "company";
    }
    if(_controller == "broadcast" && _method == "create"){
        _method = "broadcast_index";
        _controller = "company";
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
    if(_controller == "bills" && _method == "payflow"){
        _controller = "finance";
    }

    if(_controller == "category" && _method == "sob_update")
    {
        _method = "account_set";
    }
     if(_controller == "category" && _method == "update_expense")
    {
        _method = "show_expense";
    }
    $('.hsub').each(function(){
        $(this).removeClass('active open');
    });
    $('.submenu').each(function(){
        $(this).hide();
    });
    if(_method == "report_template")
    {
        _controller = '';
        $('#reports').addClass('open');
        $($('#reports').find('.submenu').get(0)).show();
        $($('.rushumenu')[0]).show();
        $('#report' + _report_id).addClass('active');
    }
    if(_method == "get_item_type_name")
    {
        $('#company').addClass('open');
        $('#company').find('.submenu_custom').show();
    }
    if(_method == "custom_item" || "custom_item_create" == _method)
    {
        $('#company').addClass('open');
        $('#company').find('.submenu_custom').show();
        $("#custom_item").addClass('active');
    }


    if(_method == "audit_todo" || _method == "audit_done") {
        $('#audit').addClass('open');
        $('#audit').find('.submenu').show();
    }

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
