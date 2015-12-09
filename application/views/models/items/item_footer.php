<input type="hidden" id="renew" value="0" name="renew">
<div class="clearfix form-actions col-sm-8 col-xs-8">
<div class="col-md-offset-3 col-md-8">
<a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>
<a class="btn btn-white btn-default renew" data-renew="1"><i class="ace-icon fa fa-check "></i>保存再记</a>
</div>
</div>
<input type="reset" style="display:none;" id="reset">

</div>
</div>
<input type="hidden" name="images" id="images" >
<input type="hidden" name="attachments" id="files" >
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

<script type="text/javascript">
$(document).ready(function() {
    var uploader_file = WebUploader.create({
    auto:true,
    // swf文件路径
    swf: '/static/third-party/webUploader/Uploader.swf',

    // 文件接收服务端。
    server: '<?php echo base_url('items/attachment'); ?>',

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#picker',

    // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
    resize: false,
    accept: {
        title: 'Files',
        extensions: 'pdf,docx,doc,ppt,pptx,xls,xlsx',
        mimeTypes: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,application/msword,application/vnd.ms-powerpoint,application/vnd.ms-excel'
    }
});

// 当有文件添加进来的时候
uploader_file.on( 'fileQueued', function( file ) {
    var $li = $(
            '<div id="' + file.id + '" style="position:relative;float:left;border: 1px solid #ddd;border-radius: 4px;margin-right: 15px;padding: 5px;">' +
                '<img style="width:128px">' +
                '<p style="text-align: center;margin: 0;max-width: 128px;">'+file.name+'</p>'+
                '<div class="glyphicon glyphicon-trash red del-button_" style="  position: absolute;right: 10px;top: 10px;cursor: pointer;"></div>' +
                '<div class="ui-icon ace-icon fa fa-download blue download-button_" style="  position: absolute;right: 10px;bottom: 10px;cursor: pointer;"></div>' +
            '</div>'
            ),$img = $li.find('img');
    // $list为容器jQuery实例
    $('#theList').append( $li );
    var path = "/static/images/", name_ = "";
    switch(file.type) {
        case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
        case "application/vnd.ms-excel":
            name_ = "excel.png";
            break;
        case "application/vnd.openxmlformats-officedocument.presentationml.presentation":
        case "application/vnd.ms-powerpoint":
            name_ = "powerpoint.png";
            break;
        case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
        case "application/msword":
            name_ = "word.png"
            break;
        case "application/pdf":
            name_ = "pdf.png"
            break;
        default:
            name_ = "default.png";
            break;
    }
    $img.attr( 'src', path+name_);
    bind_event_file();
});
function bind_event_file(){
        $('#theList .del-button_').click(function(e) {
            var key = filesDict[this.parentNode.id];
            var images = $("input[name='attachments']").val();
            var arr_img = images.split(',');
            var result = '';
            for (var item = 0; item < arr_img.length; item++) {
                if (arr_img[item] != key) {
                    if (result == '') result += arr_img[item];
                    else result += ',' + arr_img[item];
                }
            }
            $("input[name='attachments']").val(result);
            $(this.parentNode).remove();
        });
        $('#theList .download-button_').click(function(e) {
            var url = filesUrlDict[this.parentNode.id];
            var aLink = document.createElement('a');
            aLink.href = url;
            aLink.click();
        });
}
// 文件上传过程中创建进度条实时显示。
uploader_file.on( 'uploadProgress', function( file, percentage ) {
    var $li = $( '#'+file.id ),
        $percent = $li.find('.progress span');
    // 避免重复创建
    if ( !$percent.length ) {
        $percent = $('<p class="progress"><span></span></p>')
                .appendTo( $li )
                .find('span');
    }

    $percent.css( 'width', percentage * 100 + '%' );
});

// 文件上传成功，给item添加成功class, 用样式标记上传成功。
uploader_file.on( 'uploadSuccess', function( file ) {
    var $li = $( '#'+file.id ),
        $success = $li.find('div.success');

    // 避免重复创建
    if ( !$success.length ) {
        $success = $('<div class="success blue center"></div>').appendTo( $li );
    }

    $success.text('上传成功');
});

// 文件上传失败，显示上传出错。
uploader_file.on( 'uploadError', function( file ) {
    var $li = $( '#'+file.id ),
        $error = $li.find('div.error');

    // 避免重复创建
    if ( !$error.length ) {
        $error = $('<div class="error red center"></div>').appendTo( $li );
    }

    $error.text('上传失败');
});

uploader_file.on( 'uploadAccept', function( file, response ) {
    if ( response['status'] > 0 ) {
        // 通过return false来告诉组件，此文件上传有错。
        var imageDom = $('#' + file.file.id);
        filesDict[file.file.id] = String(response['data']['id']);
        filesUrlDict[file.file.id] = String(response['data']['url']);
        if ($("input[name='attachments']").val() == '') {
            $("input[name='attachments']").val(response['data']['id']);
        } else {
            $("input[name='attachments']").val($("input[name='attachments']").val() + ',' + response['data']['id']);
        }
        return true;
    } else return false;
});

// 完成上传完了，成功或者失败，先删除进度条。
uploader_file.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find('.progress').remove();
});
});
var filesDict = {};
var filesUrlDict = {};
</script>

<script language="javascript">
/*1209
var simbol_dic = {'cny':'人民币','usd':'美元','eur':'欧元','hkd':'港币','mop':'澳门币','twd':'新台币','jpy':'日元','ker':'韩国元',
                              'gbp':'英镑','rub':'卢布','sgd':'新加坡元','php':'菲律宾比索','idr':'印尼卢比','myr':'马来西亚元','thb':'泰铢','cad':'加拿大元',
                              'aud':'澳大利亚元','nzd':'新西兰元','chf':'瑞士法郎','dkk':'丹麦克朗','nok':'挪威克朗','sek':'瑞典克朗','brl':'巴西里亚尔'
                             }; 
var icon_dic = {'cny':'￥','usd':'$','eur':'€','hkd':'$','mop':'$','twd':'$','jpy':'￥','ker':'₩',
                              'gbp':'£','rub':'₽','sgd':'$','php':'₱','idr':'Rps','myr':'$','thb':'฿','cad':'$',
                              'aud':'$','nzd':'$','chf':'₣','dkk':'Kr','nok':'Kr','sek':'Kr','brl':'$'
                             }; 
var typed_currency = [];

var ifUp = 1;
var __BASE = "<?php echo $base_url; ?>";
var __config = $('#company_config').data('value');
var subs = "<?php echo $profile['subs'];?>";
var __item_config = $('#item_config').data('value');

var item_config = [];
if(__item_config)
{
    item_config = __item_config;
}

var _item_config = new Object();
for(var i = 0 ; i < item_config.length; i++)
{
    if(item_config[i]['type']==2 || item_config[i]['type'] == 5 || item_config[i]['type'] == 1) {
        _item_config[item_config[i]['cid']] = item_config[i];
    }
}
*/

var not_auto_note = "";
var flag = 0;
function initUploader() {
    if (flag == 1) {
        return;
    } else {
        flag =1;
    }
var uploader = WebUploader.create({
    // 选完文件后，是否自动上传。
    auto: true,
    // swf文件路径
    swf: '/static/third-party/webUploader/Uploader.swf',
    // 文件接收服务端。
    server: '<?php echo base_url('items/images'); ?>',
    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '.filePicker',
    // 只允许选择图片文件。
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/*'
    }
});
// 当有文件添加进来的时候
uploader.on( 'fileQueued', function( file ) {
    var $li = $(
            '<div id="' + file.id + '" style="position:relative;float:left;border: 1px solid #ddd;border-radius: 4px;margin-right: 15px;padding: 5px;">' +
                '<img>' +
                '<div class="glyphicon glyphicon-trash red del-button" style="  position: absolute;right: 10px;top: 10px;cursor: pointer;"></div>' +
            '</div>'
            ),
        $img = $li.find('img');
    // $list为容器jQuery实例
    $('#imageList').append( $li );
    ifUp = 0;
    // 创建缩略图
    // 如果为非图片文件，可以不用调用此方法。
    // thumbnailWidth x thumbnailHeight 为 100 x 100
    uploader.makeThumb( file, function( error, src ) {
        if ( error ) {
            $img.replaceWith('<span>不能预览</span>');
            return;
        }

        $img.attr( 'src', src );
        bind_event();
    }, 150, 150 );
});

// 文件上传过程中创建进度条实时显示。
uploader.on( 'uploadProgress', function( file, percentage ) {
    var $li = $( '#'+file.id ),
        $percent = $li.find('.progress span');
        ifUp = 0;
    // 避免重复创建
    if ( !$percent.length ) {
        $percent = $('<p class="progress"><span></span></p>')
                .appendTo( $li )
                .find('span');
    }

    $percent.css( 'width', percentage * 100 + '%' );
});

// 文件上传成功，给item添加成功class, 用样式标记上传成功。
uploader.on( 'uploadSuccess', function( file ) {
    var $li = $( '#'+file.id ),
        $success = $li.find('div.success');

    // 避免重复创建
    if ( !$success.length ) {
        $success = $('<div class="success blue center"></div>').appendTo( $li );
    }

    $success.text('上传成功');
});

// 文件上传失败，显示上传出错。
uploader.on( 'uploadError', function( file ) {
    var $li = $( '#'+file.id ),
        $error = $li.find('div.error');

    // 避免重复创建
    if ( !$error.length ) {
        $error = $('<div class="error red center"></div>').appendTo( $li );
    }

    $error.text('上传失败');
});

uploader.on( 'uploadAccept', function( file, response ) {
    if ( response['status'] > 0 ) {
        // 通过return false来告诉组件，此文件上传有错。
        var imageDom = $('#' + file.file.id);
        imagesDict[file.file.id] = 'WU_FILE_' + String(response['data']['id']);
        if ($("input[name='images']").val() == '') {
            $("input[name='images']").val(response['data']['id']);
        } else {
            $("input[name='images']").val($("input[name='images']").val() + ',' + response['data']['id']);
        }
        return true;
    } else return false;
});

// 完成上传完了，成功或者失败，先删除进度条。
uploader.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find('.progress').remove();
    ifUp = 1;
});
}
function bind_event(){
        $('.del-button').click(function(e) {
            var key = imagesDict[this.parentNode.id].split("WU_FILE_")[1];
            var images = $("input[name='images']").val();
            var arr_img = images.split(',');
            var result = '';
            for (var item = 0; item < arr_img.length; item++) {
                if (arr_img[item] != key) {
                    if (result == '') result += arr_img[item];
                    else result += ',' + arr_img[item];
                }
            }
            $("input[name='images']").val(result);
            $(this.parentNode).remove();
        });
}

/*
    function updateSelectSob(data) {
                                $("#sobs").empty();
                                $("#sobs").append(data);
                                $("#sobs").trigger('change');
                                $("#sobs").trigger("chosen:updated");
                            }
function get_sobs(){
   var selectPostData = {};
   var selectDataCategory = {};
   var selectDataSobs = '';
        $.ajax({
            url : __BASE + "category/get_my_sob_category",
            dataType : 'json',
            method : 'GET',
            success : function(data){
                console.log(data);
                for(var item in data) {
                    var _h = "<option value='" +  item + "'>"+  data[item].sob_name + " </option>";
                    selectDataCategory[item] = data[item]['category'];
                    selectDataSobs += _h;
                }
                selectPostData = data;
                updateSelectSob(selectDataSobs);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
                console.log(textStatus);
                console.log(errorThrownr);
            }
        });


        $('#sobs').change(function(){
            var s_id = $(this).val();
            var _h = '';
            if(selectDataCategory[s_id] != undefined)
            {
                for(var i = 0 ; i < selectDataCategory[s_id].length; i++)
                {
                    var parent_name = '';
                    if(selectDataCategory[s_id][i]['children']!=undefined)
                    {
                        parent_name = selectDataCategory[s_id][i]['category_name'];
                        _h+="<optgroup style='font-style: normal;' label='"+ parent_name +"'>"
                        for(var j = 0 ; j < selectDataCategory[s_id][i]['children'].length; j++)
                        {
                            _h+="<option data-parent='" + parent_name + "' data-name='" + selectDataCategory[s_id][i]['children'][j]['category_name'] + "' value='" +  selectDataCategory[s_id][i]['children'][j]['id'] + "'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + selectDataCategory[s_id][i]['children'][j]['category_name'] + " </option>";
                        }
                        _h+="</optgroup>";
                    }
                    else
                    {
                        _h += "<option data-parent='' data-name='" + selectDataCategory[s_id][i].category_name + "' value='" +  selectDataCategory[s_id][i].id + "'>" +selectDataCategory[s_id][i].category_name + " </option>";
                    }   
                }
            }
            var selectDom = this.parentNode.nextElementSibling.children[0]
            $(selectDom).empty().append(_h).trigger("chosen:updated");
            $('#sob_category').trigger('change');
            $('#sob_category').trigger('change:updated');
        });
    
        $('#sob_category').each(function(){
            $(this).change(function(){
                var pre_cate = $('.cate_selected',$(this));
                var pre_parent = pre_cate.data('parent');
                var pre_name = pre_cate.data('name');
                if(pre_parent)
                {
                    pre_cate.html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + pre_name);
                }
                $('.cate_selected',$(this)).removeClass('cate_selected');
                var selected_cate = $('option:selected',$(this));
                var selected_cate_parent = selected_cate.data('parent');
                var selected_cate_name = selected_cate.data('name');
                selected_cate.prop('class','cate_selected').trigger('chosen:updated');
                if(selected_cate_parent)
                {
                    $(this).next().find('span').text(selected_cate_parent+'-'+selected_cate_name);
                }

            });
        });
}
*/
/*1208
$('#coin_type').change(function(){
    var temp = $('#coin_type').val();
    var coin_list = temp.split(',');
    $('#coin_simbol').text(icon_dic[coin_list[0]]);
    var _amount = $('#amount').val();
    $('#rate_simbol').text('￥' + Math.round(_amount*coin_list[1])/100);
    if(coin_list[0] != 'cny')
    {
        if(typed_currency[coin_list[0]]['type'] == 0)
        {
            $('#rate_type').text('现钞卖出价');
        }
        if(typed_currency[coin_list[0]]['type'] == 2)
        {
            $('#rate_type').text('现汇卖出价');
        }
        $('#rate_amount').text(Math.round(coin_list[1]*10000)/1000000);
    }
    else
    {
         $('#rate_type').text('现钞卖出价');
         $('#rate_amount').text('1.0');
    }
   
    $('#amount').trigger('change');
    $('#amount').trigger('change:updated');
  
});
*/

/*1208
$('#amount').change(function(){
    var temp = $('#coin_type').val();
    var coin_list = temp.split(',');
    $('#coin_simbol').text(icon_dic[coin_list[0]]);
    var _amount = $('#amount').val();
    $('#rate_simbol').text( '￥' + Math.round(_amount*coin_list[1])/100 );
});
*/

/* 不包含汇率种类的实现
function get_currency()
{
    $.ajax({
        url:__BASE + 'items/get_currency',
        dataType:'json',
        method:'GET',
        success:function(data){
          
            
            var _h = '';
            for(var item in data)
            {
                _h += '<option value="' + item + ',' + data[item] +'">' + simbol_dic[item] + '</option>';
            }
            $('#coin_type').append(_h);
        },
        error:function(a,b,c){
          
        }
    });
}
*/

/*1208
function get_typed_currency()
{
     $.ajax({
        url:__BASE + 'items/get_typed_currency',
        dataType:'json',
        method:'GET',
        success:function(data){
            var _h = '';
            for(var item in data)
            {
                typed_currency[item] = JSON.parse(data[item]);
                _h += '<option value="' + item + ',' + typed_currency[item]['value'] +'">' + simbol_dic[item] + '</option>';
            }
            $('#coin_type').append(_h);
        },
        error:function(a,b,c){
          
        }
    });
}
*/

var __multi_time = 0;
var __average_count = 0;
$(document).ready(function(){

    //$('#mul_amount').empty();
    /*1209
    if(__config['open_exchange']){
       // get_currency();
       get_typed_currency();
    }
    */
    /*1209
    get_sobs();
    */
    /*1209
    $('#date-timepicker1').datetimepicker({
        language: 'zh-cn',
            useCurrent: true,
            format: 'YYYY-MM-DD HH:mm:ss',
            linkField: "dt",
            linkFormat: "YYYY-MM-DD HH:mm:ss",
            sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });

    $('#date-timepicker2').datetimepicker({
        language: 'zh-cn',
            useCurrent: true,
            format: 'YYYY-MM-DD HH:mm:ss',
            linkField: "dt_end",
            linkFormat: "YYYY-MM-DD HH:mm:ss",
            sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });
    */

    /*1209
    $('.chosen-select').chosen({allow_single_deselect:true}); 
    $(window)
        .off('resize.chosen')
        .on('resize.chosen', function() {
            $('.chosen-select').each(function() {
                var $this = $(this);
                $this.next().css({'width': $this.parent().width()});
            })
        }).trigger('resize.chosen');
        */

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
    $("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange'></i>");
    $('#sob_category').change(function(){
            $('#endTime').hide();
            $('#average').hide();
            __multi_time = 0;
            __average_count = 0;
        var category_id = $('#sob_category').val();
        if(_item_config[category_id]!=undefined && _item_config[category_id]['type'] == 2)
        {
            __multi_time = 1;
            $('#config_id').val(_item_config[category_id]['id']);
            $('#config_type').val(_item_config[category_id]['type']);
            $('#date-timepicker2').val('');
            $('#endTime').show();
        } else  {
            if(_item_config[category_id]!=undefined && _item_config[category_id]['type'] == 5) {
                $('#config_id').val(_item_config[category_id]['id']);
                $('#config_type').val(_item_config[category_id]['type']);

                $('#amount').change(function(){
                    var all_amount = $('#amount').val();
                    var coin_symbol = '￥';
                    if(__config['open_exchange'] == '1')
                    {
                        var selected_coin = $('#coin_type option:selected');
                        coin_symbol = selected_coin.data('symbol');
                        var coin_rate = selected_coin.data('rate');
                    }
                    if (subs != '' && subs >= 0)
                        $('#average_id').text(coin_symbol + Number(all_amount/subs).toFixed(2) + '/人*' + subs);
                    else
                        $('#average_id').text("请输入正确人数");
                });
                $('#people-nums').change(function() {
                    subs = $('#people-nums').val();
                    $('#amount').change();
                });
                var all_amount = $('#amount').val();
                $('#average_id').text('￥' + Number(all_amount/subs).toFixed(2) + '/人*' + subs);
                $('#average').show();
                __average_count = 1;
            } else if(_item_config[category_id]!=undefined && _item_config[category_id]['type'] == 1) {
                $('#config_id').val(_item_config[category_id]['id']);
                $('#config_type').val(_item_config[category_id]['type']);
                $('#note_2').show();
            } else
            {
                $('#note_2').hide();
                $('#config_id').val('');
                $('#config_type').val('');
                $('#average').val('');
                $('#average').hide();
            }
        }

    });

    $('.renew').click(function(){

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

         var dateTime = $('#date-timepicker1').val()
         var dateTime = dateTime.replace(/(^\s*)|(\s*$)/g,'');
        if(__config && __config['not_auto_time'] == 1)
        {
            if(dateTime == '')
            {
                show_notify('请填写时间');
                //$('#date-timepicker1').focus();
                return false;
            }
        }

         var dateTime2 = $('#date-timepicker2').val();
         dateTime2 = dateTime2.replace(/(^\s*)|(\s*$)/g,'');
        if(__config && __config['not_auto_time'] == 1)
        {
            if(dateTime2 == '' && __multi_time)
            {
                show_notify('请填写结束时间');
                return false;
            }
            if((dateTime2>'0') && (dateTime2 < dateTime))
            {
                show_notify('结束时间应该大于开始时间');
                return false;
            }
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
        $('#itemform').submit();
    });
    $('.cancel').click(function(){
        $('#reset').click();
    });
    initUploader();
});
var imagesDict = {};
</script>
