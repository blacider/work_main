<div class="form-group">
<label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
<div class="col-xs-3 col-sm-3">
     <select  class="form-control  chosen-select tag-input-style" name="coin_type" id="coin_type" style="display:block">
        <option data-symbol="￥" data-rate="100" value='cny'>人民币</option>
     </select>
    
</div>
<label class="col-xs-6 col-sm-6">
        <small>中行实时<span id='rate_type'>现钞卖出价</span>为：<span id='rate_amount'>1.0</span></small>
</label>
</div>
<script type="text/javascript">

function init_coin_type()
{
    $('#coin_type').val(item_info['currency']).prop('selected',true);
    $('#coin_type').trigger('change');
    $('#coin_type').trigger('chosen:updated');
}

function get_typed_currency(is_init)
{
     $.ajax({
        url:__BASE + 'items/get_typed_currency',
        dataType:'json',
        method:'GET',
        success:function(data){
            var _h = '';
            for(var item in data)
            {
                typed_currency[item] = JSON.parse(data[item]);
                _h += '<option data-symbol="' + icon_dic[item] + '" data-rate="' + typed_currency[item]['value'] + '" value="' + item + '">' + simbol_dic[item] + '</option>';
            }
            $('#coin_type').append(_h);
            $('#coin_type').trigger('chosen:updated');
            if(is_init != 0)
            {
                init_coin_type();
            }
        },
        error:function(a,b,c){
          
        }
    });
}

$('#coin_type').change(function(){
    var coin_type_id = $('#coin_type').val();
    var selected_coin = $('#coin_type option:selected');
    var coin_symbol = selected_coin.data('symbol');
    var coin_rate = selected_coin.data('rate');
    $('#coin_simbol').text(coin_symbol);
    var _amount = $('#amount').val();
    $('#rate_simbol').text('￥' + Math.round(_amount*coin_rate)/100);
    if(coin_type_id != 'cny')
    {
        console.log(coin_type_id);
        console.log();
        if(typed_currency[coin_type_id]['type'] == 0)
        {
            $('#rate_type').text('现钞卖出价');
        }
        if(typed_currency[coin_type_id]['type'] == 2)
        {
            $('#rate_type').text('现汇卖出价');
        }
        $('#rate_amount').text(Math.round(coin_rate*10000)/1000000);
    }
    else
    {
         $('#rate_type').text('现钞卖出价');
         $('#rate_amount').text('1.0');
    }
   
    $('#amount').trigger('change');
    $('#amount').trigger('change:updated');
  
});

$(document).ready(function(){
	get_typed_currency(PAGE_TYPE);
});
</script>