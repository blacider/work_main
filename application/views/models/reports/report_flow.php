
<div class="form-group">
    <label class="col-sm-1 control-label no-padding-right">审批流程</label>
    <div class="col-xs-10 col-sm-10">
        <table class="table table-bordered table-striped">
            <tr>
                <td>审批人</td>
                <td>审批意见</td>
                <td>审批时间</td>
           
                <!--
                <td>操作</td>
                -->
            </tr>
            <?php foreach($flow as $i){ ?>
            <tr>
       
                <td><?php 
                    if($i['wingman']) 
                        {
                            echo $i['nickname'].'('.$i['wingman'].'代提交)';
                        }
                    else
                    {
                        echo $i['nickname'];
                    }
                 ?></td>
                <td><?php echo $i['status']; ?></td>
                <td><?php 
                    if($i['ts'] != '0000-00-00 00:00:00') {
                        echo $i['ts']; 
                    }
                    ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>