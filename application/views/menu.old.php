     <!-- #section:basics/navbar.layout -->
     <link rel="stylesheet" href="/static/jgrowl/jquery.jgrowl.min.css"/>
<script language="javascript" src="/static/jgrowl/jquery.jgrowl.min.js"></script>
<div id="navbar" class="navbar navbar-default">
<script type="text/javascript">
    var __BASEURL = "<?php echo base_url(); ?>";
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

<!-- /section:basics/sidebar.mobile.toggle -->
<div class="navbar-header pull-left">
    <!-- #section:basics/navbar.layout.brand -->
    <a href="#" class="navbar-brand">
        <small>
            <i class="fa fa-leaf"></i>
            <?php echo $appname; ?>管理后台
        </small>
    </a>

    <!-- /section:basics/navbar.layout.brand -->

    <!-- #section:basics/navbar.toggle -->

    <!-- /section:basics/navbar.toggle -->
</div>

<!-- #section:basics/navbar.dropdown -->
<div class="navbar-buttons navbar-header pull-right" role="navigation">
<ul class="nav ace-nav">
<!--
<li class="grey">
    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
        <i class="ace-icon fa fa-tasks"></i>
        <span class="badge badge-grey">4</span>
    </a>

    <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
        <li class="dropdown-header">
            <i class="ace-icon fa fa-check"></i>
            4 Tasks to complete
        </li>

        <li>
            <a href="#">
                <div class="clearfix">
                    <span class="pull-left">Software Update</span>
                    <span class="pull-right">65%</span>
                </div>

                <div class="progress progress-mini">
                    <div style="width:65%" class="progress-bar"></div>
                </div>
            </a>
        </li>

        <li>
            <a href="#">
                <div class="clearfix">
                    <span class="pull-left">Hardware Upgrade</span>
                    <span class="pull-right">35%</span>
                </div>

                <div class="progress progress-mini">
                    <div style="width:35%" class="progress-bar progress-bar-danger"></div>
                </div>
            </a>
        </li>

        <li>
            <a href="#">
                <div class="clearfix">
                    <span class="pull-left">Unit Testing</span>
                    <span class="pull-right">15%</span>
                </div>

                <div class="progress progress-mini">
                    <div style="width:15%" class="progress-bar progress-bar-warning"></div>
                </div>
            </a>
        </li>

        <li>
            <a href="#">
                <div class="clearfix">
                    <span class="pull-left">Bug Fixes</span>
                    <span class="pull-right">90%</span>
                </div>

                <div class="progress progress-mini progress-striped active">
                    <div style="width:90%" class="progress-bar progress-bar-success"></div>
                </div>
            </a>
        </li>

        <li class="dropdown-footer">
            <a href="#">
                See tasks with details
                <i class="ace-icon fa fa-arrow-right"></i>
            </a>
        </li>
    </ul>
</li>

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

<li class="green">
    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
        <i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
        <span class="badge badge-success">5</span>
    </a>

    <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
        <li class="dropdown-header">
            <i class="ace-icon fa fa-envelope-o"></i>
            5 Messages
        </li>

        <li class="dropdown-content">
            <ul class="dropdown-menu dropdown-navbar">
                <li>
                    <a href="#">
                        <img src="/static/assets/avatars/avatar.png" class="msg-photo" alt="Alex's Avatar" />
                                                <span class="msg-body">
                                                    <span class="msg-title">
                                                        <span class="blue">Alex:</span>
                                                        Ciao sociis natoque penatibus et auctor ...
                                                    </span>

                                                    <span class="msg-time">
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span>a moment ago</span>
                                                    </span>
                                                </span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <img src="/static/assets/avatars/avatar3.png" class="msg-photo" alt="Susan's Avatar" />
                                                <span class="msg-body">
                                                    <span class="msg-title">
                                                        <span class="blue">Susan:</span>
                                                        Vestibulum id ligula porta felis euismod ...
                                                    </span>

                                                    <span class="msg-time">
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span>20 minutes ago</span>
                                                    </span>
                                                </span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <img src="/static/assets/avatars/avatar4.png" class="msg-photo" alt="Bob's Avatar" />
                                                <span class="msg-body">
                                                    <span class="msg-title">
                                                        <span class="blue">Bob:</span>
                                                        Nullam quis risus eget urna mollis ornare ...
                                                    </span>

                                                    <span class="msg-time">
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span>3:15 pm</span>
                                                    </span>
                                                </span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <img src="/static/assets/avatars/avatar2.png" class="msg-photo" alt="Kate's Avatar" />
                                                <span class="msg-body">
                                                    <span class="msg-title">
                                                        <span class="blue">Kate:</span>
                                                        Ciao sociis natoque eget urna mollis ornare ...
                                                    </span>

                                                    <span class="msg-time">
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span>1:33 pm</span>
                                                    </span>
                                                </span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <img src="/static/assets/avatars/avatar5.png" class="msg-photo" alt="Fred's Avatar" />
                                                <span class="msg-body">
                                                    <span class="msg-title">
                                                        <span class="blue">Fred:</span>
                                                        Vestibulum id penatibus et auctor  ...
                                                    </span>

                                                    <span class="msg-time">
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span>10:09 am</span>
                                                    </span>
                                                </span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="dropdown-footer">
            <a href="inbox.html">
                See all messages
                <i class="ace-icon fa fa-arrow-right"></i>
            </a>
        </li>
    </ul>
</li>
-->
<!-- #section:basics/navbar.user_menu -->
<li class="light-blue">
    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
        <!-- <img class="nav-user-photo" src="/static/assets/avatars/user.jpg" alt="Jason's Photo" /> -->
                                <span class="user-info">
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

                                    <small>欢迎,</small>
<?php
echo $username;
?>
                                </span>

        <i class="ace-icon fa fa-caret-down"></i>
    </a>

    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
        <!--
        <li>
            <a href="#">
                <i class="ace-icon fa fa-cog"></i>
                Settings
            </a>
        </li>
        -->

        <li>
        <a href="<?php echo base_url('users/profile'); ?>">
                <i class="ace-icon fa fa-user"></i>
                个人信息
            </a>
        </li>

        <li class="divider"></li>

        <li>
            <a href="<?php echo base_url('login/dologout'); ?>">
                <i class="ace-icon fa fa-power-off"></i>
               登出
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





<!-- Side bar -->


<!-- /section:basics/navbar.layout -->
<div class="main-container" id="main-container">
<script type="text/javascript">
try{ace.settings.check('main-container' , 'fixed')}catch(e){}
</script>

<!-- #section:basics/sidebar -->
<div id="sidebar" class="sidebar  responsive">
<script type="text/javascript">
try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
</script>

<!--
<div class="sidebar-shortcuts" id="sidebar-shortcuts">
    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
        <button class="btn btn-success">
            <i class="ace-icon fa fa-signal"></i>
        </button>

        <button class="btn btn-info">
            <i class="ace-icon fa fa-pencil"></i>
        </button>

        <button class="btn btn-warning">
            <i class="ace-icon fa fa-users"></i>
        </button>

        <button class="btn btn-danger">
            <i class="ace-icon fa fa-cogs"></i>
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
<!-- /.sidebar-shortcuts -->

<ul class="nav nav-list">

<?php
$menu_html = '';
$idx = 0;
foreach($menu as $_menu){

?>


<?php
    if($_menu->type == 'group'){
?>
        <li class="hsub">
<?php
        if($idx == 0) {
            $idx = 1;
?>
    <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-desktop"></i>
        <span class="menu-text"> <?php echo $_menu->title; ?> </span>

        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>

    <ul class="submenu">
<?php
        } else {
?>

</ul>
        </li>
    <li class="hsub">
<a href="#" class="dropdown-toggle">
    <i class="menu-icon fa fa-desktop"></i>
    <span class="menu-text"> <?php echo $_menu->title; ?> </span>

    <b class="arrow fa fa-angle-down"></b>
</a>
<b class="arrow"></b>

<ul class="submenu">
<?php
        }
    }
    else{
        $path = base_url() . $_menu->path;
        if($_menu->active == true){
?>
            <li class="active">
                <a href="<?php echo $path; ?>">
                    <i class="menu-icon fa fa-caret-right"></i>
                    <?php echo $_menu->title; ?>
                </a>

                <b class="arrow"></b>
            </li>
<?php

        }
        else{

?>
            <li class="">
                <a href="<?php echo $path; ?>">
                    <i class="menu-icon fa fa-caret-right"></i>
                    <?php echo $_menu->title; ?>
                </a>

                <b class="arrow"></b>
            </li>
<?php
        }
    }
}

?>
    </li>
</ul>



<script>
function show_notify(msg, life){
    if(!life || life ==undefined)
        life = 1000;
    $.jGrowl(msg, {'life' : life});
}
$(document).ready(function(){
    var parent = $('li .active').parents('li').get(0);
    var dp = $($(parent).find('.submenu').get(0));
    $(dp).removeClass('nav-hide').addClass('nav-show');
    $(dp).show();
    $(parent).addClass('open');
});
</script>
</div>

