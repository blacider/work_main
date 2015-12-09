<div class="form-group">
	<label class="col-sm-1 control-label no-padding-right">消费时间</label>
	<div class="col-xs-6 col-sm-6">
		<div class="input-group">
			<input id="date-timepicker1" name="dt" type="text" class="form-control date-timepicker" />
			<span class="input-group-addon">
				<i class="fa fa-clock-o bigger-110"></i>
			</span>
		</div>
	</div>
</div>

<div class="form-group" id="endTime" hidden>
	<label class="col-sm-1 control-label no-padding-right">至</label>
	<div class="col-xs-6 col-sm-6">
		<div class="input-group">
			<input id="date-timepicker2" name="dt_end" type="text" class="form-control date-timepicker" />
			<span class="input-group-addon">
				<i class="fa fa-clock-o bigger-110"></i>
			</span>
		</div>
	</div>
</div>

<input type="hidden" id="config_id" name="config_id" />

<input type="hidden" id="config_type" name="config_type"/>

<div disabled class="form-group" id="average" hidden>
	<label class="col-sm-1 control-label no-padding-right">人数:</label>
	<div class="col-xs-3 col-sm-3">
		<div class="input-group">
			<input type="text" id="people-nums" name="peoples">
		</div>
	</div>

	<label class="col-sm-1 control-label no-padding-right">人均:</label>
	<div class="col-xs-3 col-sm-3">
		<div class="input-group">
			<div id="average_id" name="average" type="text" class="form-control"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
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
});
</script>