<div class="form-group">
	<label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
	<div class="col-xs-6 col-sm-6">
		<div class="input-group">
			<input id="end_dt" name="end_dt" type="text" class="form-control date-timepicker default_custom" data-id="<?php echo $item_customization_value['id'];?>"/>
			<span class="input-group-addon">
				<i class="fa fa-clock-o bigger-110"></i>
			</span>
		</div>
	</div>
</div>
<script type="text/javascript">
function init_time_period_module()
{
	$('end_dt').val(item_info['end_dt']);
}
$(document).ready(function(){

});
</script>