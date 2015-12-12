<div class="form-group">
    <label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
    <div class="col-xs-4 col-sm-4">
        <select class="chosen-select tag-input-style default_custom" data-id="<?php echo $item_customization_value['id'];?>" id="member" name="uids[]" multiple="multiple" data-placeholder="请选择员工">
            <?php 
            foreach($member as $m){
                ?>
                <?php if ($m['id'] != $profile['id']) {?>
                <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname'];if($m['email']){echo "[" . $m['email'] . "]";} elseif($m['phone']){echo "[" . $m['phone'] . "]";}?></option>
                <?php } else { ?>
                <option selected value="<?php echo $m['id']; ?>"><?php echo $m['nickname'];if($m['email']){ echo "[" . $m['email'] . "]";}elseif($m['phone']){echo "[" . $m['phone'] . "]";}?></option>
                <?php } ?>
                <?php
            }
            ?>
        </select>
    </div>
    <label class="col-sm-1 control-label no-padding-right">人数:</label>
    <div class="col-xs-2 col-sm-2">
        <div id="affiliated_nums" name="affiliated_nums" type="text" class="form-control"></div>
    </div>
    <label class="col-sm-1 control-label no-padding-right">人均:</label>
    <div class="col-xs-2 col-sm-2">
        <div id="affiliated_average" name="affiliated_average" type="text" class="form-control"></div>
    </div>
</div>

<script type="text/javascript">
function init_affiliated_person_module()
{
    var person_list = item_info['relates'].split(',');
    $('#member').val(person_list).prop('selected',true);
    $('#member').trigger('change');
    $('#member').trigger('chosen:updated');
}

function set_average_affiliated_amount()
{
    var affiliated_nums = 0;
    var affiliated_person = $('#member').val();
    var affiliated_amount = $('#amount').val();
    var coin_symbol = '￥';
    var coin_rate = 100;
    var selected_icon = $('#coin_type option:selected');
    if(selected_icon.data('symbol') != undefined)
    {
        coin_symbol = selected_icon.data('symbol');
    }
    if(affiliated_person)
    {
        affiliated_nums = affiliated_person.length;
    }
    $('#affiliated_nums').text(affiliated_nums);
    if($('#amount').val() && affiliated_nums)
    {
        console.log(coin_symbol);
        console.log(affiliated_amount);
        $('#affiliated_average').text(coin_symbol + Math.round(100*affiliated_amount/affiliated_nums)/100 + "/人*" + affiliated_nums);
    }
    else
    {
        $('#affiliated_average').text('');
    }
}
    $(document).ready(function(){
        $('#amount').on('change',function(){
           set_average_affiliated_amount();
        });
        $('#member').on('change',function(){
            set_average_affiliated_amount();
        });
        $('#member').trigger('change');

        if(PAGE_TYPE != 0)
        {
            init_affiliated_person_module();
        }
    });
</script>
