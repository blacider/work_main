<!-- /section:basics/sidebar -->
<div class="main-content">
    <!-- #section:basics/content.breadcrumbs -->
    <div class="breadcrumbs" id="breadcrumbs">
<script type="text/javascript">
try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
</script>

<!-- #section:basics/content.searchbox -->
<div class="nav-search" id="nav-search">
    <form class="form-search">
        <span class="input-icon">
            <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
            <i class="ace-icon fa fa-search nav-search-icon"></i>
        </span>
    </form>
</div><!-- /.nav-search -->

<!-- /section:basics/content.searchbox -->
                                                                                                                                                                        </div>

                                                                                                                                                                        <!-- /section:basics/content.breadcrumbs -->
                                                                                                                                                                        <div class="page-content">
                                                                                                                                                                            <!-- #section:settings.box -->
                                                                                                                                                                            <div class="ace-settings-container" id="ace-settings-container">
                                                                                                                                                                                <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                                                                                                                                                                                    <i class="ace-icon fa fa-cog bigger-150"></i>
                                                                                                                                                                                </div>

                                                                                                                                                                                <div class="ace-settings-box clearfix" id="ace-settings-box">
                                                                                                                                                                                </div><!-- /.ace-settings-box -->
                                                                                                                                                                            </div><!-- /.ace-settings-container -->

                                                                                                                                                                            <!-- /section:settings.box -->
                                                                                                                                                                            <div class="page-content-area">
                                                                                                                                                                                <div class="page-header">
                                                                                                                                                                                    <h1>
                                                                                                                                                                                        任务情况
                                                                                                                                                                                        <small>
                                                                                                                                                                                            <i class="ace-icon fa fa-angle-double-right"></i>
                                                                                                                                                                                        </small>
                                                                                                                                                                                    </h1>
                                                                                                                                                                                </div><!-- /.page-header -->

                                                                                                                                                                                <div class="row">
                                                                                                                                                                                    <div class="col-xs-12">
                                                                                                                                                                                        <!-- PAGE CONTENT BEGINS -->
                                                                                                                                                                                        <div class="row">
                                                                                                                                                                                            <div class="col-xs-12">
                                                                                                                                                                                                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                                                                                                                                                                                    <thead>
                                                                                                                                                                                                        <tr>

                                                                                                                                                                                                            <th>错误级别</th>
                                                                                                                                                                                                            <th>时间</th>
                                                                                                                                                                                                            <th>服务</th>
                                                                                                                                                                                                            <th class="hidden-480">服务器</th>
                                                                                                                                                                                                            <th>消息</th>

                                                                                                                                                                                                        </tr>
                                                                                                                                                                                                    </thead>

                                                                                                                                                                                                    <tbody>
<?php
foreach($alist as $item){
    $msg = '';
    switch($item['level']){
    case -1: $msg = '消息';break;
    case 0: $msg = '错误';break;
    case 1: $msg = '警告';break;
    case 2: $msg = '异常';break;
    case 4: $msg = '成功';break;
    }
    $_api = '';
    switch($item['api']) {
    case 'SMS' : $_api = '短信';break;
    case 'SMS Master' : $_api = '短信主通道';break;
    case 'SMS Slave' : $_api = '短信备用通道';break;
    case 'RPC' : $_api = '远程调用';break;
    case 'APNS' : $_api = '苹果推送';break;
    case 'EMAIL' : $_api = '邮件';break;
    default: $_api = $item['api'];break;
    }
    $str = '<tr>';
    $title = '<td width=60>' . $msg . '</td>';
    $desc = '<td width=150>' . substr($item['createdt'], 0, 16). '</td>';
    $desc .= '<td width=120>' . $_api . '</td>';
    $email = '<td>' . $item['host'] . '</td>';
    $role_id = '<td class="u_role_name">' . $item['msg'] . '</td>';

    $operation = '';

    $str = $str . $title . $desc . $email . $role_id . $operation . '</tr>';
    echo $str;
}
?>

</tbody>
</table>
</div><!-- /.span -->
</div><!-- /.row -->

</div><!-- /.col -->
</div><!-- /.row -->
<div class="row">
    <?php echo $pager; ?>
    </div>

</div><!-- /.page-content-area -->
</div><!-- /.page-content -->
</div><!-- /.main-content -->
<script language="javascript">

$(document).ready(function(){

});
</script>
