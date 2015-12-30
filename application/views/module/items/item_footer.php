<input type="hidden" id="renew" value="0" name="renew">
<div class="clearfix form-actions col-sm-8 col-xs-8">
<div class="col-md-offset-3 col-md-8" >
<?php
    if(!in_array($page_type,[2,3]))
    {
?>
<a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>
<a class="btn btn-white btn-default renew" data-renew="1"><i class="ace-icon fa fa-check "></i>保存再记</a>
<?php
    }
?>
</div>
</div>
<input type="reset" style="display:none;" id="reset">

</div>
</div>
<input type="hidden" name="images" id="images" >
<input type="hidden" name="attachments" id="files" >
<input type="hidden" name="customization" id="customization">
<input type="hidden" name="default_customization" id="default_customization">
</form>
</div>
</div>

<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/date-time/moment.js"></script>
<script src="/static/ace/js/jquery.colorbox-min.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="/static/third-party/webUploader/webuploader.css">
<!--引入JS-->
<script type="text/javascript" src="/static/third-party/webUploader/webuploader.js"></script>

<script language="javascript">

var __multi_time = 0;
var __average_count = 0;
$(document).ready(function(){
    if(PAGE_TYPE == 2 || PAGE_TYPE == 3)
    {
        $('.default_custom').each(function(){
            $(this).prop('disabled',true);
            $(this).trigger('chosen:updated');
        });

        $('.customization_type').each(function(){
            $(this).prop('disabled',true);
            $(this).trigger('chosen:updated');
        });
        $('.add_attach_pic_btn').each(function(){
            $(this).prop('hidden',true);
            $(this).trigger('chosen:updated');
        });
        $('#sobs').prop('disabled',true);
        $('#sobs').trigger('chosen:udpated');
        $('.afford_chose').prop('disabled',true);
        $('.afford_chose').trigger('chosen:updated');
    }

    $("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange'></i>");
    $('.renew').click(function(){
        var customization = [];
        $('.customization_type').each(function(){
            var _id = $(this).data('id');
            var _value = $(this).val();
            if(_value instanceof Array)
            {
                _value = _value.join(',');
            }
            console.log(_value instanceof Array);
            var temp = new Object();
            temp['id'] = _id;
            temp['value'] = _value;
            customization.push(temp);
        });
        $('#customization').val(JSON.stringify(customization));

        var default_customization = [];
        $('.default_custom').each(function(){
            var _id = $(this).data('id');
            var _value = $(this).val();
            if(_value instanceof Array)
            {
                _value = _value.join(',');
            }
            console.log(_value instanceof Array);
            var temp = new Object();
            temp['id'] = _id;
            temp['val'] = _value;
            default_customization.push(temp);
        });
        $('#default_customization').val(JSON.stringify(default_customization));

        console.log(default_customization);

        var _affid = '';
        try {
            _affid = $('.afford_chose').val().join(',');
        }catch(e) {}
        $('#afford_ids').val(_affid);
        if (ifUp == 0) {
            show_notify('正在上传图片，请稍候');
            return false;
        }
        if(isNaN($('#amount').val())) {
            show_notify('请输入有效金额');
            $('#amount').val('');
            $('#amount').focus();
            return false;
        }

       

        var note = $('#note').val();
        if(__config && __config['note_compulsory'] == 1)
        {
            if(note.trim()=='')
            {

                show_notify('请输入备注');
                $('#note').focus();
                return false;
            }
        }
        if($('#sob_category').val() == null)
        {
            show_notify('请选择类别');
            return false;
        }
        if($('#config_type').val() == 5 && __average_count && $('#people-nums').val() == null && $('#people-nums').val() == 0) {
            show_notify('必须填写参与人数');
            return false;
        }

        var _extra = [];
        $('.extra_textarea').each(function(idx, item) {
            var _type_id = $(item).data('type');
            var _value = $(item).val();
            _extra.push({'id' : _type_id, 'type' : 1, 'value' : _value});
        });
        $('#hidden_extra').val($.toJSON(_extra));
        $('#renew').val($(this).data('renew'));
       // $('#itemform').submit();
    });
    $('.cancel').click(function(){
        $('#reset').click();
    });
    //initUploader();
});
var imagesDict = {};
</script>
