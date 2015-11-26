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
                                                                                                                                                                                        用户反馈
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
                                                                                                                                                                                                            <th>昵称</th>
                                                                                                                                                                                                            <th>联系方式</th>
                                                                                                                                                                                                            <th>邮箱</th>
                                                                                                                                                                                                            <th>留言</th>
                                                                                                                                                                                                            <th>版本</th>
                                                                                                                                                                                                            <th>工作人员反馈</th>
                                                                                                                                                                                                            <th>平台</th>
                                                                                                                                                                                                            <th class="hidden-680">
                                                                                                                                                                                                                <a href="#modal-table" role="button" class="green" data-toggle="modal">
                                                                                                                                                                                                                    <i id="add_new_btn" class="ace glyphicon glyphicon-plus-sign" ></i>
                                                                                                                                                                                                                </a>
                                                                                                                                                                                                            </th>
                                                                                                                                                                                                        </tr>
                                                                                                                                                                                                    </thead>

                                                                                                                                                                                                    <tbody>
<?php
foreach($alist as $item){
    $platform = $item['platform'] == 0 ? 'iOS' : 'Android';
    $str = '<tr>';
    $title = '<td>' . htmlentities($item['nickname']) . '</td>';
    $title .= '<td>' . htmlentities($item['contact']) . '</td>';
    $title .= '<td>' . htmlentities($item['email']) . '</td>';
    $desc = '<td>' . htmlentities($item['content']) . '</td>';
    $email = '<td>' . $item['version'] . '</td>';
    $email .= '<td>' . $item['feedback'] . '</td>';
    $email .= '<td>' . $platform . '</td>';

    $operation = '<td style="width:50px;"><a class="btn btn-xs btn-success markdone" data-id="' . $item['id'] .'">
        <i class="ace-icon fa fa-pencil bigger-120"></i>
        </a></td>';

    $str = $str . $title . $desc . $email . $operation . '</tr>';
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


<div id="modal-table" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger">回复消息</h4>
            </div>
            <form id="module_form" method="post" action="<?php echo base_url('admin/comments/add'); ?>">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-xs-12 col-sm-12">

                            <div class="space-4"></div>
                            <div class="form-group">
                                <div>
                                    <textarea class="form-control" id="msg" name="msg" placeholder=""></textarea>
                                    <input type="hidden" name="mid" value="0" id="mid">
                                </div>
                            </div>
                            <div class="space-4"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-sm" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>
                        取消
                    </button>

                    <button type="button" class="btn btn-sm btn-success" id="commit">
                        提交
                        <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
                    </button>

                </div>
            </form>
        </div>
    </div>
</div><!-- PAGE CONTENT ENDS -->







<script language="javascript">

$(document).ready(function(){
    $('.markdone').each(function(){
        $(this).click(function(){
            var _id = $(this).data('id');
            $('#mid').val(_id);
            $('#modal-table').modal();
        });
    });
    $('#commit').click(function(){
        if(confirm('确认伺候好了?')){
            $('#module_form').submit();
        }
    });

});
</script>
