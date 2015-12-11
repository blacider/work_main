<div class="form-group">
<label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
<div class="col-xs-6 col-sm-6">
<select class="chosen-select tag-input-style" name="tags[]" multiple="multiple" data-placeholder="请选择标签">
<?php foreach($tags as $category) {?>

<option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
<?php } ?>
</select>

</div>
</div>
