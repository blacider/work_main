<div class="page-content">
    <div class="page-content-area">
        <form role="form" class="form-horizontal"  enctype="multipart/form-data" >
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">名称</label>
                                <div class="col-xs-9 col-sm-9">
                                    <label> <?php echo $report['title']; ?> </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">提交至</label>
                                <div class="col-xs-9 col-sm-9">
                                    <label> <?php echo $report['receivers']['managers']; ?> </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">抄送至</label>
                                <div class="col-xs-9 col-sm-9">
                                    <label> <?php echo $report['receivers']['cc']; ?> </label>
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
                                            <!--
                                            <td>操作</td>
                                            -->
                                        </tr>
                                        <?php foreach($report['items'] as $i){ ?>
                                        <tr>
                                            <td><?php echo strftime('%Y-%m-%d %H:%M', $i['dt']); ?></td>
                                            <td><?php echo $i['category_name']; ?></td>
                                            <td><?php echo $i['amount']; ?></td>
                                            <td><?php echo $i['prove_ahead']; ?></td>
                                            <td><?php echo $i['merchants']; ?></td>
                                            <!--
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del">
                                                    <span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="3905"></span>
                                                    <span class="ui-icon green ui-icon-pencil tedit" data-id="3905"></span>
                                                    <span class="ui-icon ui-icon-trash red  tdel" data-id="3905"></span>
                                                </div>
                                            </td>
                                            -->
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group" style="margin-bottom: 10px;min-weight:40px;">
                                <center>
                                    <button class="btn btn-success">修改</button>
                                </center>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
</script>
