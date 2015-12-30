<input type="hidden" name="hidden_extra" id="hidden_extra" value="">
<div class="form-group customization_form" data-value='<?php echo htmlspecialchars(json_encode($item_customization_value));?>'>
<label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
<div class="col-xs-6 col-sm-6">
<textarea name="note" id="note" data-id="<?php echo $item_customization_value['id'];?>" class="col-xs-12 col-sm-12 form-controller default_custom need_check" ></textarea>
</div>

</div>
<script type="text/javascript">
	function init_notes_module()
	{
		$('#note').val(item_info['note']);
	}
	$(document).ready(function(){
		if(PAGE_TYPE != 0)
		{
			init_notes_module();
		}
	});
</script>