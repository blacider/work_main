<?php 
	switch($item_customization_value['type'])
	{
		case 101:
?>

<div class="form-group">
    <label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
    <div class="col-xs-6 col-sm-6">
        <input type="text" data-id="<?php echo $item_customization_value['id'];?>" class="form-controller col-xs-12 customization_type" id="<?php echo htmlspecialchars('customization_' . $item_customization_value['id']);?>" placeholder="金额" required>
    </div>
</div>

<?php
		break;
		case 102:
?>
<div class="form-group">
    <label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
    <div class="col-xs-6 col-sm-6">
        <input type="number" data-id="<?php echo $item_customization_value['id'];?>" class="form-controller col-xs-12 customization_type" id="<?php echo htmlspecialchars('customization_' . $item_customization_value['id']);?>" placeholder="数字" required>
    </div>
</div>
<?php
		break;
		case 103:
?>
<div class="form-group">
    <label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
	<div class="col-xs-6 col-sm-6">
	<select class="chosen-select tag-input-style customization_type" data-id="<?php echo $item_customization_value['id'];?>" id="<?php echo htmlspecialchars('customization_' . $item_customization_value['id']);?>" <?php if($item_customization_value['extra']['multi-selectable']){echo 'multiple="multiple"';}?> data-placeholder="请选择标签">
	<?php foreach($item_customization_value['extra']['options'] as $opt) {?>

	<option value="<?php echo $opt['id']; ?>"><?php echo $opt['value']; ?></option>
	<?php } ?>
	</select>

	</div>
</div>
<?php
		break;
		case 104:
?>
<div class="form-group">
    <label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
    <div class="col-xs-6 col-sm-6">
        <input type="text" data-id="<?php echo $item_customization_value['id'];?>" class="form-controller col-xs-12 customization_type" id="<?php echo htmlspecialchars('customization_' . $item_customization_value['id']);?>" placeholder="单位金额" required>
    </div>
</div>
<?php
	}
?>