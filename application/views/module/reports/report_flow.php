
    <div class="form-group">
      <label class="col-sm-1 control-label no-padding-right">审批流程</label>
      <div class="col-xs-10 col-sm-10">
        <table class="table table-bordered table-striped">
          <tr>
            <td>阶段</td>
            <td>审批人</td>
            <td>审批意见</td>
            <td>审批时间</td>
            <!--
            <td>操作</td>
            -->
          </tr>
          <?php foreach($flow as $sub_flows) { ?>
          <?php foreach ($sub_flows as $index => $i) { ?>
          <tr>
            <?php if ($index == 0) { ?>
            <td rowspan="<?php echo count($sub_flows); ?>"><?php if ($i['group'] == 0) { echo '业务阶段'; } else if ($i['group'] == 1) { echo '财务阶段'; } ?></td>
            <?php } ?>
            <td><?php
                if($i['wingman']) {
                    echo $i['nickname'].'('.$i['wingman'].'代提交)';
                } else {
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
          <?php } ?>
        </table>
      </div>
    </div>
