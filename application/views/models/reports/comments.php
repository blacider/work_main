<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">留言</label>
<div class="col-xs-10 col-sm-10">
    <table class="table table-bordered table-striped">
        <tr>
            <td>姓名</td>
            <td>留言</td>
            <td>内容</td>
       
            <!--
            <td>操作</td>
            -->
        </tr>
        <?php foreach($comments as $i){ ?>
        <tr>
   
            <td><?php echo $i['nickname']; ?></td>
            <td><?php 
            if($i['lastdt'] != '0000-00-00 00:00:00') {
                echo $i['lastdt']; 
            }
            ?></td>
            <td><?php echo $i['comment']; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
</div>
