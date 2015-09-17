<!-- /section:basics/sidebar -->
<div class="main-content">
    <!-- #section:basics/content.breadcrumbs -->
    <div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
Date.prototype.format = function(fmt)
{ //author: meizz
    var o = {
        "M+" : this.getMonth()+1,                 //月份
            "d+" : this.getDate(),                    //日
            "h+" : this.getHours(),                   //小时
            "m+" : this.getMinutes(),                 //分
            "s+" : this.getSeconds(),                 //秒
            "q+" : Math.floor((this.getMonth()+3)/3), //季度
            "S"  : this.getMilliseconds()             //毫秒
    };
    if(/(y+)/.test(fmt))
        fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
    for(var k in o)
        if(new RegExp("("+ k +")").test(fmt))
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
    return fmt;
}
    try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>
</div>
<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
    <!-- #section:settings.box -->

    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                发票管理
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                </small>
            </h1>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12" id="row_center">
                <form method="post" class="form-horizontal" role="form" action="<?php echo base_url('invoice/search'); ?>">
                    <input type="text" class="col-xs-5" name="pinfo" placeholder="用户名称" id="username" />
                    &nbsp;
                        <button class="btn btn-info btn-sm" type="button" id="search_btn">
                            <i class="ace-icon fa fa-check"></i> 给我搜
                        </button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12" id="row_center">
                <table id="report_table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>报表编号</th>
                            <th>报表名称</th>
                            <th>报表总额</th>
                            <th>条目个数</th>
                            <th>创建时间</th>
                            <th>最后修改时间</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="detailform" class="modal" tabindex="-1" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="blue bigger">Please fill the following form fields</h4>
            </div>
        
            <div class="modal-body">
                <div class="row">
                    <table id="items_table" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>条目编号</th>
                                <th>条目金额</th>
                                <th>条目分类</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary" data-dismiss="modal">
                    <i class="ace-icon fa fa-check"></i> 确认
                </button>
            </div>
        </div>
    </div>
</div>











<script language="javascript">
$(document).ready(function(){
    $('#search_btn').click(function(){
        var _name = $('#username').val();
        $('#report_table').html(' <thead> <tr> <th>报表编号</th> <th>报表名称</th> <th>报表总额</th> <th>条目个数</th> <th>创建时间</th> <th>最后修改时间</th></tr> </thead>');
                            
        $.ajax(__BASEURL + "invoice/search", {
            'method' : 'POST'
                ,'dataType' : 'JSON'
            ,'data' : {'name' : _name}
            }).success(function(data){
                if(data.status == 1){
                    var reports = data.data.report;
                    $(reports).each(function(){
                        var item = $(this).get(0);
                        var _buf = '<tr class="report" data-id="'+ item.id + '">'
                            + '<td>' 
                            + item.id
                            + '</td>' 
                            + '<td>' 
                            + item.title
                            + '</td>' 
                            + '<td>' 
                            + item.amount
                            + '</td>' 
                            + '<td>' 
                            + item.item_count
                            + '</td>' 
                            + '<td>' 
                            + new Date(item.createdt*1000).format("yyyy-MM-dd hh:mm:ss")
                            + '</td>' 
                            + '<td>' 
                            + new Date(item.lastdt*1000).format("yyyy-MM-dd hh:mm:ss")
                            + '</td>' 
                            + '</tr>';
                            $('#report_table').append(_buf);
                    });
                    $('.report').each(function(){
                        $(this).click(function(){
                            var _rid = $(this).data('id');
                            //location.href = __BASEURL + '/invoice/detail/' + _rid;
                        });
                    });
                }
            });
    });
});
</script>

<style>
    .report {
        cursor:pointer;
    }

</style>
