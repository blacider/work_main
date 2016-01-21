<div class="form-group">
    <label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title']?></label>
    <div class="col-xs-6 col-sm-6">
        <div class="input-group input-group">
            <span class="input-group-addon" id='coin_simbol'>￥</span>
            <input type="number" class="form-controller col-xs-12 col-sm-12 default_custom" data-id="<?php echo $item_customization_value['id'];?>" name="amount" id="amount" placeholder="金额" required>
            <span class="input-group-addon" id='rate_simbol'>￥0</span>
      
        </div>

    </div>
</div>

<script type="text/javascript">
function init_amount()
{
    $('#amount').val(item_info['amount']);
}

function init_amount_module()
{
    init_amount(item_info);
    init_coin_type(item_info);
    $('#amount').trigger('change');
}

$(document).ready(function(){
    $('#amount').change(function(){
        var coin_type_id = 'cny';
        var coin_symbol = '￥';
        var coin_rate = 100;
        if($('#coin_type').val() != undefined)
        {
            coin_type_id = $('#coin_type').val();
            var selected_coin = $('#coin_type option:selected');
            coin_symbol = selected_coin.data('symbol');
            coin_rate = selected_coin.data('rate');
            $('#coin_simbol').text(coin_symbol);
        }
        var _amount = $('#amount').val();
        $('#rate_simbol').text( '￥' + Math.round(_amount*coin_rate)/100 );
    });

    if(PAGE_TYPE != 0)
    {
        init_amount();
    }
});



</script>
