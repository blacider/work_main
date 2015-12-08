<?php
    if($company_config['open_exchange'])
    {
?>
<div class="form-group">
    <label class="col-sm-1 control-label no-padding-right">金额</label>
    <div class="col-xs-6 col-sm-6">


        <select class="col-xs-4 col-sm-4" class="form-control  chosen-select tag-input-style" name="coin_type" id="coin_type">
            <option data-symbol="￥" data-rate="100" value='cny'>人民币</option>
        </select>
        <div class="input-group input-group">
            <span class="input-group-addon" id='coin_simbol'>￥</span>
            <input type="text" class="form-controller col-xs-12 col-sm-12" name="amount" id="amount" placeholder="金额" required>
            <span class="input-group-addon" id='rate_simbol'>￥0</span>
        </div>

    </div>
</div>
<div class="form-group" id="rate_note">
    <label class="col-sm-1 control-label no-padding-right"></label>
    <div class="col-xs-6 col-sm-6">
        <small>中行实时<span id='rate_type'>现钞卖出价</span>为：<span id='rate_amount'>1.0</span></small>
    </div>

</div>
<?php
}
else
{
    ?>
    <div class="form-group" id="mul_amount">
        <label class="col-sm-1 control-label no-padding-right">金额</label>
        <div class="col-xs-6 col-sm-6">
            <input type="text" class="form-controller col-xs-12" name="amount" id="amount" placeholder="金额" required>
        </div>

    </div>

<?php
    }
?>
<script type="text/javascript">
function get_typed_currency()
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
        },
        error:function(a,b,c){
          
        }
    });
}
    $(document).ready(function(){
        $('#coin_type').change(function(){
            var coin_type_id = $('#coin_type').val();
            var selected_coin = $('#coin_type option:selected');
            var coin_symbol = selected_coin.data('symbol');
            var coin_rate = selected_coin.data('rate');
            $('#coin_simbol').text(coin_symbol);
            var _amount = $('#amount').val();
            $('#rate_simbol').text('￥' + Math.round(_amount*coin_rate)/100);
            if(coin_rate != 'cny')
            {
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