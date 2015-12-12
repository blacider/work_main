<?php
    if($company_config['open_exchange'])
    {
?>
<div class="form-group">
    <label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title']?></label>
    <div class="col-xs-6 col-sm-6">
        <div class="input-group input-group">
            <span class="input-group-addon" id='coin_simbol'>￥</span>
            <input type="number" class="form-controller col-xs-12 col-sm-12" name="amount" id="amount" placeholder="金额" required>
            <span class="input-group-addon" id='rate_simbol'>￥0</span>
        </div>

    </div>
</div>
<?php
}
else
{
    ?>
    <div class="form-group" id="mul_amount">
        <label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
        <div class="col-xs-6 col-sm-6">
            <input type="text" class="form-controller col-xs-12" name="amount" id="amount" placeholder="金额" required>
        </div>

    </div>

<?php
    }
?>
<script type="text/javascript">
function init_amount(item_info)
{
    $('#amount').val(item_info['amount']);
}

function init_coin_type(item_info)
{
    $('#coin_type').val(item_info['currency']).prop('selected',true);
    $('#coin_type').trigger('change');
    $('#coin_type').trigger('chosen:updated');
}

function init_amount_module(item_info)
{
    init_amount(item_info);
    init_coin_type(item_info);
    $('#amount').trigger('change');
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
                init_amount_module(item_info);
            }
        },
        error:function(a,b,c){
          
        }
    });
}
    $(document).ready(function(){
        if(__config['open_exchange']){
            // get_currency();
            get_typed_currency(PAGE_TYPE);
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

        $('#amount').change(function(){
            var coin_type_id = $('#coin_type').val();
            var selected_coin = $('#coin_type option:selected');
            var coin_symbol = selected_coin.data('symbol');
            var coin_rate = selected_coin.data('rate');
            $('#coin_simbol').text(coin_symbol);
            var _amount = $('#amount').val();
            $('#rate_simbol').text( '￥' + Math.round(_amount*coin_rate)/100 );
        });
    });



</script>
