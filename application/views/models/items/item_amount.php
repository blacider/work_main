<?php
    if($company_config['open_exchange'])
    {
?>
<div class="form-group">
    <label class="col-sm-1 control-label no-padding-right">金额</label>
    <div class="col-xs-6 col-sm-6">


        <select class="col-xs-4 col-sm-4" class="form-control  chosen-select tag-input-style" name="coin_type" id="coin_type">
            <option value='cny,100'>人民币</option>
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