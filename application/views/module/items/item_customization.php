<div class="form-group customization_form" data-value='<?php echo htmlspecialchars(json_encode($item_customization_value));?>'>
<?php 
	switch($item_customization_value['type'])
	{
		case 101:
?>


    <label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
    <div class="col-xs-6 col-sm-6">
        <input data-title="<?php echo $item_customization_value['title'];?>" type="text" data-id="<?php echo $item_customization_value['id'];?>" class="form-controller col-xs-12 customization_type need_check" id="<?php echo htmlspecialchars('customization_' . $item_customization_value['id']);?>" placeholder="<?php echo htmlspecialchars($item_customization_value['description']);?>">
    </div>
</div>

<?php
		break;
		case 102:
?>

    <label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
    <div class="col-xs-6 col-sm-6">
        <input data-title="<?php echo $item_customization_value['title'];?>" type="number" data-id="<?php echo $item_customization_value['id'];?>" class="form-controller col-xs-12 customization_type need_check" id="<?php echo htmlspecialchars('customization_' . $item_customization_value['id']);?>" placeholder="<?php echo htmlspecialchars($item_customization_value['description']);?>">
    </div>
</div>
<?php
		break;
		case 103:
?>

    <label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
	<div class="col-xs-6 col-sm-6">
	<select data-title="<?php echo $item_customization_value['title'];?>" class="chosen-select tag-input-style customization_type need_check" data-id="<?php echo $item_customization_value['id'];?>" id="<?php echo htmlspecialchars('customization_' . $item_customization_value['id']);?>" <?php if($item_customization_value['extra']['multi-selectable']){echo 'multiple="multiple"';}?> data-placeholder="请选择标签">
	<?php foreach($item_customization_value['extra']['options'] as $opt) {?>

	<option value="<?php echo $opt['id']; ?>"><?php echo $opt['name']; ?></option>
	<?php } ?>
	</select>

	</div>
</div>
<?php
		break;
		case 104:
?>

    <label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
    <div class="col-xs-2 col-sm-2">
        <input data-title="<?php echo $item_customization_value['title'];?>" type="text" data-id="<?php echo $item_customization_value['id'];?>" class="form-controller col-xs-12 customization_type member_nums need_check" id="<?php echo htmlspecialchars('customization_' . $item_customization_value['id']);?>" placeholder="<?php echo htmlspecialchars($item_customization_value['description']);?>">
    </div>
    <label class="col-sm-1 control-label no-padding-right">平均:</label>
	<div class="col-xs-2 col-sm-2">
	    <div id="member_average" name="member_average" type="text" class="form-control"></div>
	</div>
</div>
<script type="text/javascript">
function set_member_average()
{
	var amount = $('#amount').val();
	var member_nums = $('.member_nums').val();
	var coin_symbol = '￥';
    var coin_rate = 100;
    var selected_icon = $('#coin_type option:selected');
    if(selected_icon.data('symbol') != undefined)
    {
        coin_symbol = selected_icon.data('symbol');
    }
    if($('#amount').val() && member_nums)
    {
        $('#member_average').text(coin_symbol + Math.round(100*amount/member_nums)/100 + "/人*" + member_nums);
    }
    else
    {
        $('#member_average').text('');
    }
}
$('.member_nums').on('change',function(){
	set_member_average();
});
$('#amount').on('change',function(){
	set_member_average();
});
$(document).ready(function(){

});
</script>

<?php
	}
?>
<script type="text/javascript">
is_init_customization_module = false;
function init_customization_module()
{
	var item_customization = $('#html_item_customization').data('value');
	var customization_id_type_dic = new Object();
	for(var j in item_customization)
	{
		customization_id_type_dic[item_customization[j]['id']] = item_customization[j]['type'];
	}
	var item_customization = $('#html_item_customization').data('value');
	var _value ='';
	var _id = '';
	for(var i in item_info['customization'])
	{
		_value = item_info['customization'][i]['value'];
		_id = item_info['customization'][i]['id'];
		$('#customization_' + _id).val(_value);
		if(customization_id_type_dic[_id] == '103')
		{
			$('#customization_' + _id).prop('selected',true);
			$('#customization_' + _id).trigger('chosen:updated');
		}
	}
	
}
$(document).ready(function(){
	if(PAGE_TYPE != 0 && !is_init_customization_module)
	{
		init_customization_module();
		is_init_customization_module = true;
	}
});
</script>