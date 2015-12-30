<div class="form-group customization_form" data-value='<?php echo htmlspecialchars(json_encode($item_customization_value));?>'>
<label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
<div class="col-xs-6 col-sm-6">
<input data-title="<?php echo $item_customization_value['title'];?>" type="text" name="merchant" id="merchant" class="form-controller col-xs-12 default_custom need_check" data-id="<?php echo $item_customization_value['id'];?>" placeholder="消费商家">
</div>
</div>
<script type="text/javascript">
	function init_seller_module()
	{
		$('#merchant').val(item_info['merchants']);
	}
	$(document).ready(function(){
		if(PAGE_TYPE != 0)
		{
			init_seller_module();
		}
	});
</script>