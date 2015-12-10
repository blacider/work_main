<div class="form-group" id="burden" <?php if(!$is_burden) echo 'hidden'?>>
<label class="col-sm-1 control-label no-padding-right">费用承担</label>
<div class="col-xs-6 col-sm-6">

<div class="col-xs-3 col-sm-3" style="margin-left:0px;padding-left:0px;">
<input type="hidden" value="" id="afford_ids" name="afford_ids" />
<select class="chosen-select tag-input-style" id="afford_type" name="afford_type" data-placeholder="请选择类型">
<option value="-1"><?php echo $profile['nickname']; ?></option>
<?php 
    $select_multi = array();
    foreach($afford as $i) { 
        $_select = '';
        if(count($i['dept']) > 0) {
            $_select = '<select class="chosen-select tag-input-style afford_detail"  multiple="multiple" data-placeholder="请选择实体" data-pid="' . $i['id'] . '" style="display:none;">';
            foreach($i['dept'] as $d) {
                $prefix = $d['name'];
                if(array_key_exists('member', $d) && count($d['member']) > 0) {
                    foreach($d['member'] as $m) {
                        $_select .= '<option value="'. $m['id']  . '"> ' . $prefix . "-" . $m['name'] . '</option>';
                    }
                } else {
                    $_select .= '<option value="'. $d['id']  . '"> ' . $prefix . '</option>';
                }
            }
            $_select .= "</select>";
        }
        if($_select) 
            array_push($select_multi, $_select);
?>

<option value="<?php echo $i['id']; ?>"><?php echo $i['name']; ?></option>
<?php } ?>
</select>
</div>

<div class="col-xs-9 col-sm-9">
<?php echo implode("", $select_multi); ?>
</div>

</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('.afford_detail').each(function(idx, item) {
        $(this).next().hide();
    });

    $('.afford_detail').hide();
    $('#afford_type').change(function(){
        var _id = $(this).val();
        $('.afford_detail').each(function(idx, item) {
            $(item).hide();
            $(item).next().hide();
            $(item).removeClass('afford_chose');
            if($(item).data('pid') == _id) {
                $(item).show();
                $(item).next().show();
                $(item).addClass('afford_chose');
            }
        });
    });
});
</script>