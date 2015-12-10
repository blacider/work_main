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

    $('#sob_category').change(function(){
            $('#endTime').hide();
            $('#average').hide();
            __multi_time = 0;
            __average_count = 0;
        var category_id = $('#sob_category').val();
        if(_item_config[category_id]!=undefined && _item_config[category_id]['type'] == 2)
        {
            __multi_time = 1;
            $('#config_id').val(_item_config[category_id]['id']);
            $('#config_type').val(_item_config[category_id]['type']);
            $('#date-timepicker2').val('');
            $('#endTime').show();
        } else  {
            if(_item_config[category_id]!=undefined && _item_config[category_id]['type'] == 5) {
                $('#config_id').val(_item_config[category_id]['id']);
                $('#config_type').val(_item_config[category_id]['type']);

                $('#amount').change(function(){
                    var all_amount = $('#amount').val();
                    var coin_symbol = '￥';
                    if(__config['open_exchange'] == '1')
                    {
                        var selected_coin = $('#coin_type option:selected');
                        coin_symbol = selected_coin.data('symbol');
                        var coin_rate = selected_coin.data('rate');
                    }
                    if (subs != '' && subs >= 0)
                        $('#average_id').text(coin_symbol + Number(all_amount/subs).toFixed(2) + '/人*' + subs);
                    else
                        $('#average_id').text("请输入正确人数");
                });
                $('#people-nums').change(function() {
                    subs = $('#people-nums').val();
                    $('#amount').change();
                });
                var all_amount = $('#amount').val();
                $('#average_id').text('￥' + Number(all_amount/subs).toFixed(2) + '/人*' + subs);
                $('#average').show();
                __average_count = 1;
            } else if(_item_config[category_id]!=undefined && _item_config[category_id]['type'] == 1) {
                $('#config_id').val(_item_config[category_id]['id']);
                $('#config_type').val(_item_config[category_id]['type']);
                $('#note_2').show();
            } else
            {
                $('#note_2').hide();
                $('#config_id').val('');
                $('#config_type').val('');
                $('#average').val('');
                $('#average').hide();
            }
        }

    });


});
</script>