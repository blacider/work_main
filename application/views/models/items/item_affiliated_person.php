<div class="form-group">
    <label class="col-sm-1 control-label no-padding-right">参与人</label>
    <div class="col-xs-6 col-sm-6">
        <select class="chosen-select tag-input-style" id="member" name="uids[]" multiple="multiple" data-placeholder="请选择员工">
            <?php 
            foreach($member as $m){
                ?>
                <?php if ($m['id'] != $user) {?>
                <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname'];if($m['email']){echo "[" . $m['email'] . "]";} elseif($m['phone']){echo "[" . $m['phone'] . "]";}?></option>
                <?php } else { ?>
                <option selected value="<?php echo $m['id']; ?>"><?php echo $m['nickname'];if($m['email']){ echo "[" . $m['email'] . "]";}elseif($m['phone']){echo "[" . $m['phone'] . "]";}?></option>
                <?php } ?>
                <?php
            }
            ?>
        </select>
    </div>
    <label class="col-sm-1 control-label no-padding-right">人均:<strong id='average_affiliated_person'></strong></label>
</div>

<script type="text/javascript">
function set_average_affiliated_amount()
{
    var affiliated_count = 0;
    var affiliated_person = $('#member').val();
    var affiliated_amount = $('#amount').val();
    if(affiliated_person)
    {
        affiliated_count = affiliated_person.length;
    }
    if($('#amount').val() && affiliated_count)
    {
        $('#average_affiliated_person').text(Math.round(100*affiliated_amount)/100);
    }
    else
    {
        $('#average_affiliated_person').text('');
    }
}
    $(document).ready(function(){
        $('#amount').on('change',function(){
           set_average_affiliated_amount();
        });
        $('#member').on('change',function(){
            set_average_affiliated_amount();
        });
    });
</script>