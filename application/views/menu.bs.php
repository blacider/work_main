
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
                <!--
						<li class="purple">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-bell icon-animated-bell"></i>
								<span class="badge badge-important">8</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-exclamation-triangle"></i>
									8 Notifications
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
												New Comments
											</span>
											<span class="pull-right badge badge-info">+12</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<i class="btn btn-xs btn-primary fa fa-user"></i>
										Bob just signed up as an editor ...
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-success fa fa-shopping-cart"></i>
												New Orders
											</span>
											<span class="pull-right badge badge-success">+8</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-info fa fa-twitter"></i>
												Followers
											</span>
											<span class="pull-right badge badge-info">+11</span>
										</div>
									</a>
								</li>

								<li class="dropdown-footer">
									<a href="#">
										See all notifications
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>
                        -->

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
        <a href="<?php echo base_url('reports/newreport'); ?>" >
            <i class="menu-icon fa fa-caret-right"></i>
            新建报告
        </a>

        <b class="arrow"></b>

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







    <li class="hsub" id="members">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-users"></i>
        <span class="menu-text"> 员工&部门 </span>

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
if($profile['admin'] == 1){
?>
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
if($profile['admin'] == 1){
?>

    <li class="hsub" id="category">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-tags"></i>
        <span class="menu-text"> 标签和分类 </span>

        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu nav-show" style="display: block;">
       <!-- <li class="hsub" id="newreport"> 
        <a href="<?php echo base_url('tags/newtags'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 新建标签 </a> 
        <b class="arrow"></b> 
        </li> -->

        <li class="hsub" id="tags">
        <a href="<?php echo base_url('category/tags'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 标签管理 </a>
        <b class="arrow"></b>
        </li>


        <li class="hsub" id="index">
        <a href="<?php echo base_url('category'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 分类管理 </a>
        <b class="arrow"></b>
        </li>

        
    </ul>
    </li>


    <li class="hsub" id="company">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-rocket"></i>
        <span class="menu-text"> 公司设置 </span>

        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu nav-show" style="display: block;">

        <li class="hsub" id="submit">
        <a href="<?php echo base_url('company/submit'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 提交规则 </a>
        <b class="arrow"></b>
        </li>

        <li class="hsub" id="common">
        <a href="<?php echo base_url('company/common'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 通用规则 </a>
        <b class="arrow"></b>
        </li>

         <li class="hsub" id="review">
        <a href="<?php echo base_url('company/review'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 审核规则 </a>
        <b class="arrow"></b>
        </li>

        <li class="hsub" id="setting">
        <a href="<?php echo base_url('company/setting'); ?>" > <i class="menu-icon fa fa-caret-right"></i> 公司通用设置 </a>
        <b class="arrow"></b>
        </li>

    </ul>
    </li>


    <li class="hsub" id="bills">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-money"></i>
        <span class="menu-text"> 财务和核算</span>

        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu nav-show" style="display: block;">

        <li class="hsub" id="index">
        <a href="<?php echo base_url('bills/index'); ?>" > 财务</a>

        <b class="arrow"></b>
        </li>

        <li class="hsub" id="exports">
        <a href="<?php echo base_url('bills/exports'); ?>" > 核算</a>
        <b class="arrow"></b>
        </li>

    </ul>
    </li>


<?php 
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>



<script>
function show_notify(msg, life){
    if(!life || life ==undefined)
        life = 1000;
    $.jGrowl(msg, {'life' : life});
}
$(document).ready(function(){
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
    if(_controller == "members" && _method == "imports"){
        _method = "export";
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
