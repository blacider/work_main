<div class="form-group">
    <label class="col-sm-1 control-label no-padding-right">修改记录</label>
    <div class="col-xs-9 col-sm-9">
        <table class="table table-bordered table-striped">
            <tr>
                <td>修改人</td>
                <td>修改时间</td>
                <td>操作</td>
            </tr>
            <?php foreach($flow as $i){ ?>
            <tr>
                <td><?php echo $i['operator']; ?></td>
       
                <td><?php echo $i['optdate']; ?></td>
                <td><?php echo $i['operation']; ?></td>
            </tr>
            <?php } ?>  
        </table>
    </div>
</div>

<div class="clearfix form-actions col-sm-8 col-xs-8">
    <div class="col-md-offset-3 col-md-6">
        <?php 
            if($editable == 1)
            {
            ?>
                <a class="btn btn-white btn-primary renew" href="<?php echo base_url('items/edit/' . $item['id']); ?>" data-renew="1"><i class="ace-icon fa fa-check"></i>修改</a>
            <?php
            }
            ?>
        <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>返回</a>
    </div>
</div>