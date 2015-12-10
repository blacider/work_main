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