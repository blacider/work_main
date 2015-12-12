<div class="form-group">
<label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
<div class="col-xs-3 col-sm-3">
<select class="form-control  chosen-select tag-input-style" id="item_type" name="type" data-placeholder="请选择类型">
<option value="0"><?php echo $item_type_dic[0];?></option>
<?php 
if(!$company_config['disable_borrow'])
{
?>
<option value="1"><?php echo $item_type_dic[1]; ?></option>
<?php
}
if(!$company_config['disable_budget'])
{
?>
<option value="2"><?php echo $item_type_dic[2]; ?></option>
<?php
}
?>
</select>
</div>
</div>
<script type="text/javascript">
	function init_item_type_module()
	{
		$('#item_type').val(item_info['prove_ahead']).prop('selected',true);
		$('#item_type').trigger('chosen:updated');
	}
	$(document).ready(function(){
		if(PAGE_TYPE != 0)
		{
			init_item_type_module();
		}
	});
</script>