<div class="page-content">
    <div class="page-content-area">
        <form role="form" class="form-horizontal"  enctype="multipart/form-data" >
            <div class="row">
            <div class="container col-xs-11 col-sm-11">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">名称</label>
                                <div class="col-xs-9 col-sm-9">
                                    <input type="text" class="form-controller col-xs-12" name="title" placeholder="名称" value="<?php echo $report['title']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">提交至</label>
                                <div class="col-xs-9 col-sm-9">
                                    <input type="text" class="form-controller col-xs-12" name="title" placeholder="名称" value="<?php echo $report['receivers']['managers']; ?>" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">抄送至</label>
                                <div class="col-xs-9 col-sm-9">
                                    <input type="text" class="form-controller col-xs-12" name="title" placeholder="名称" value="<?php echo $report['receivers']['cc']; ?>" disabled>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">消费列表</label>
                                <div class="col-xs-9 col-sm-9">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td>消费时间</td>
                                            <td>类别</td>
                                            <td>金额</td>
                                            <td>类型</td>
                                            <td>商家</td>
                                            <td>详情</td>
                                            <!--
                                            <td>操作</td>
                                            -->
                                        </tr>
                                        <?php foreach($report['items'] as $i){ ?>
                                        <tr>
                                            <td><?php echo strftime('%Y-%m-%d %H:%M', $i['dt']); ?></td>
                                            <td><?php 
                                                $buf = '';
switch($i['prove_ahead']) {
case 0 : $buf = '报销';break;
case 1 : $buf = '借款';break;
case 2 : $buf = '预算';break;
} 
echo $buf;


?></td>
                                            <td><?php echo $i['amount']; ?></td>
                                            <td><?php echo $i['category_name']; ?></td>
                                            <td><?php echo $i['merchants']; ?></td>
                                            <td><?php $link = base_url('items/show/' . $i['id']); ?><a href="<?php echo $link; ?>">详情</a></td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>

<div class="clearfix form-actions col-sm-10 col-xs-10">
                                <div class="col-md-offset-3 col-md-6">

                                    <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>返回</a>
                                </div>
                            </div>
                            <!--
                            <div class="form-group" style="margin-bottom: 10px;min-weight:40px;">
                                <center>
                                    <button class="btn btn-success">修改</button>
                                </center>
                            </div>
                            -->
                        </div>
                    </div>
                    </div>
        </form>
    </div>
</div>

<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
$(document).ready(function(){
    $('.cancel').click(function(){
        history.go(-1);
    });
});
</script>
