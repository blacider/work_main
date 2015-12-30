<div class="form-group">
	<label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
	<div class="col-xs-4 col-sm-4">
		<div class="input-group">
			<input id="date-timepicker1" name="dt" type="text" class="form-control date-timepicker default_custom" data-id="<?php echo $item_customization_value['id'];?>"/>
			<span class="input-group-addon">
				<i class="fa fa-clock-o bigger-110"></i>
			</span>
		</div>
	</div>
</div>

<script type="text/javascript">
function init_time_module()
{
	$('#date-timepicker1').val(item_info['dt']);
}

$(document).ready(function(){
	$('.date-timepicker').datetimepicker({
        language: 'zh-cn',
            useCurrent: true,
            format: 'YYYY-MM-DD HH:mm:ss',
            linkField: "dt",
            linkFormat: "YYYY-MM-DD HH:mm:ss",
            sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });

    if(PAGE_TYPE !=0)
    {
    	init_time_module();
    }
});

</script>