<?php if(count($tags) > 0){ ?>
<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">标签</label>
<div class="col-xs-6 col-sm-6">
<select class="chosen-select tag-input-style" name="tags[]" multiple="multiple" data-placeholder="请选择标签">
<?php foreach($tags as $category) {?>

<option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
<?php } ?>
</select>

</div>
</div>
<?php  } ?>