<?php echo get_html_container($item_customization_value,'html_item_customization_period',true); ?>
<div class="form-group customization_form" data-value='<?php echo htmlspecialchars(json_encode($item_customization_value));?>'>
	<label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
	<div class="col-xs-4 col-sm-4">
		<div class="input-group">
			<input id="end_dt" name="end_dt" type="text" class="form-control date-timepicker default_custom" data-id="<?php echo $item_customization_value['id'];?>"/>
			<span class="input-group-addon">
				<i class="fa fa-clock-o bigger-110"></i>
			</span>
		</div>
	</div>
	<?php
		if($item_customization_value['extra']['show_calculation'])
		{
	?>
	<label class="col-sm-1 control-label no-padding-right">天数:</label>
    <div class="col-xs-2 col-sm-2">
        <div id="days" name="days" type="text" class="form-control"></div>
    </div>
	<label class="col-sm-1 control-label no-padding-right">日均:</label>
    <div class="col-xs-2 col-sm-2">
        <div id="average_day" name="average_day" type="text" class="form-control"></div>
    </div>
    <?php
    	}
    ?>
</div>
<script type="text/javascript">
function stringToDate(str)
{
	str = str.replace(/-/g,"/");
	var date = new Date(str );
	return date;
}
function init_time_period_module()
{
	$('#end_dt').val(item_info['end_dt']);
	set_day_average();
}

function set_day_average()
{
	var amount = $('#amount').val();
	var start_day = $('#date-timepicker1').val();
	var start_date = stringToDate(start_day);
	var end_day = $('#end_dt').val();
	var end_date = stringToDate(end_day);
	var days = Math.ceil((end_date - start_date)/(1000*24*3600));
	if(days > 0)
	{
		$('#days').text(days);
	}
	else if(days <= 0)
	{
		show_notify('结束时间小于开始时间');
		$('#days').text('');
	}
	else
	{
		$('#days').text('');
	}

	if(amount == '')
	{
		$('#average_day').text('');
		return ;
	}

	var coin_symbol = '￥';
    var coin_rate = 100;
    var selected_icon = $('#coin_type option:selected');
    if(selected_icon.data('symbol') != undefined)
    {
        coin_symbol = selected_icon.data('symbol');
    }

   

    if($('#amount').val() && days > 0)
    {
        $('#average_day').text(coin_symbol + Math.round(100*amount/days)/100);
    }
    else
    {
        $('#average_day').text('');
    }

}

function init_timepicker()
{
	$('.date-timepicker').each(function(){
		$(this).val(' ');
	});
}

$('.date-timepicker').each(function(){
	$(this).on('change',function(){
		set_day_average();
	});
});

$('.date-timepicker').each(function(){
	$(this).on('click',function(){
		$(this).trigger('change');
	});
});

$('#amount').on('change',function(){
	set_day_average();
});


$(document).ready(function(){
	var item_customization_value = $('#html_item_customization_period').data('value');
	$('#time_label').text(item_customization_value['extra']['title_start']);
	//init_timepicker();
	if(PAGE_TYPE != 0)
	{
		init_time_period_module();
	}
});
</script>