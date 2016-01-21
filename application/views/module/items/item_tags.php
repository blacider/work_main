<div class="form-group customization_form" data-value='<?php echo htmlspecialchars(json_encode($item_customization_value));?>'>
<label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
<div class="col-xs-6 col-sm-6">
<select data-title="<?php echo $item_customization_value['title'];?>" class="form-control  chosen-select tag-input-style default_custom need_check" data-id="<?php echo $item_customization_value['id'];?>" id="item_tags" name="tags[]" multiple="multiple" data-placeholder="请选择标签">
<?php foreach($tags as $category) {?>

<option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
<?php } ?>
</select>

</div>
</div>
<script type="text/javascript">
	function init_tags_module()
	{
		var tag_list = item_info['tag_ids'].split(',');
		console.log(tag_list);
		$('#item_tags').val(tag_list).prop('selected',true);
		$('#item_tags').trigger('change');
		$('#item_tags').trigger('chosen:updated');
	}
	$(document).ready(function(){
		if(PAGE_TYPE != 0)
		{
			init_tags_module();
		}
	});
</script>