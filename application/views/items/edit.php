<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<link rel="stylesheet" href="/static/ace/css/colorbox.css" />
<script src="/static/ace/js/jquery.colorbox-min.js"></script>

<!-- page specific plugin styles -->
<!--<script src="/static/ace/js/jquery1x.min.js"></script> -->
<script src="/static/ace/js/date-time/moment.min.js"></script>
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/jquery.json.min.js"></script>

<script src="/static/ace/js/date-time/moment.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script>

<?php
    $_config = $profile['group']['config'];
    $__config = json_decode($_config,True);
?>


<div class="page-content">
    <div class="page-content-area">
        <form role="form" action="<?php echo base_url('items/update');  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" id="mainform">
            <div class="row">
                <div class="container">
                    <div class="row">
                                


                        <div class="col-xs-12 col-sm-12">

                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>" />
                            <input type="hidden" name="uid" value="<?php echo $item['uid']; ?>" />
                            <input type="hidden" name="rid" value="<?php echo $item['rid']; ?>" />
                            <input type="hidden" name="from_report" value="<?php echo $from_report; ?>" />
                            <?php 
                                if(array_key_exists('open_exchange', $__config) && $__config['open_exchange'] == '1'){
                            ?>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right">金额</label>
                                        <div class="col-xs-6 col-sm-6">


                                            <select class="col-xs-4 col-sm-4" class="form-control  chosen-select tag-input-style" name="coin_type" id="coin_type">
                                                <option value='cny,100'>人民币</option>
                                            </select>
                                            <div class="input-group input-group">
                                                <span class="input-group-addon" id='coin_simbol'>￥</span>
                                                <input type="text" class="form-controller col-xs-12 col-sm-12" name="amount" id="amount" value="<?php echo $item['amount'];?>" placeholder="金额" required>
                                                <span class="input-group-addon" id='rate_simbol'>￥0</span>
                                            </div>

                                        </div>


                                    </div>
                                    <div class="form-group" id="rate_note">
                                        <label class="col-sm-1 control-label no-padding-right"></label>
                                        <div class="col-xs-6 col-sm-6">
                                        <small>中行实时<small id='rate_type'>现钞卖出价</small>为：<small id='rate_amount'>1.0</small></small>
                                        </div>

                                    </div>
                                    <input type='hidden' id='rate' name='rate' value='1.0'/>
                            <?php
                                }
                                else
                                {
                            ?>
                            <div class="form-group">
                              
                                <label class="col-sm-1 control-label no-padding-right">金额</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" value="<?php 
                                    if($item['currency'] == 'cny')
                                    {
                                        echo $item['amount'];
                                    }
                                    else
                                    {
                                        echo round($item['amount']*$item['rate']/100,2);
                                    } 
                                    ?>" class="form-controller col-xs-12" name="amount" placeholder="金额" id="amount">
                                </div>
                            </div>
                            <?php
                                }
                            ?>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">分类</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select class="col-xs-6 col-sm-6" name="sob" id="sobs">
                                    </select>
                                    <select name="category" id="sob_category" class="col-xs-6 col-sm-6 sob_category chosen-select-niu" data-placeholder="类目">
                                    </select>
                                    <input type="hidden" name="hidden_category" id="hidden_category" value="<?php echo $item['category']; ?>">

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">消费时间</label>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="input-group">
                                        <input id="date-timepicker1" name = 'dt1' type="text" class="form-control" value="<?php echo $item['dt']; ?>"/>
                                        <input type="hidden" name="dt" id="dt" value="<?php echo $item['dt']; ?>">
                                        <span class="input-group-addon">
                                            <i class="fa fa-clock-o bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="config_id" name="config_id" />
                            <input type="hidden" id="config_type" name="config_type"/>


                            <div class="form-group" id="endTime" style="display:none;">
                                <label class="col-sm-1 control-label no-padding-right">至</label>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="input-group">
                                        <input id="date-timepicker2" name="dt_end1" id="dt_end1" type="text" class="form-control"  value="" />
                                       <input type="hidden" name="dt_end" id="dt_end" value="">
                                      
                                        <span class="input-group-addon">
                                            <i class="fa fa-clock-o bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div disabled class="form-group" id="average"  style="display:none;">
                                <label class="col-sm-1 control-label no-padding-right">人数:</label>
                                <div class="col-xs-3 col-sm-3">
                                <div class="input-group">
                                <input type="text" id="people-nums" name="peoples">
                                </div>
                                </div>
                                <label class="col-sm-1 control-label no-padding-right">人均:</label>
                                <div class="col-xs-3 col-sm-3">
                                    <div class="input-group">
                                        <div id="average_id" name="average" type="text" class="form-control"> </div>
                                
                                </div>
                            </div>
                        </div>
<?php 
    $ddt = '';
    $average = '0';
    $note_2 = '';
    $config_id = 0;
    $config_type = 0;
    if(count($item_value)){
        foreach($item_value as $_type => $_item) {
            if($_type == 2) {
                $config_id = $_item['id'];
                $config_type = $_item['type'];
                $ddt = date('Y-m-d H:i:s', $_item['value']); 
            }
            if($_type == 5) {
                $config_id = $_item['id'];
                $config_type = $_item['type'];
                $average = $_item['value'];
            }
            if($_type == 1) {
                $config_id = $_item['id'];
                $config_type = $_item['type'];
                $note_2 = $_item['value'];
            }

        }
    }
?>



<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">参与人</label>
    <div class="col-xs-6 col-sm-6">
                                    <select class="chosen-select tag-input-style" id="member" name="uids[]" multiple="multiple" data-placeholder="请选择员工">
                                    <?php 
				    $item_uids = array();
				    if(array_key_exists('relates',$item))
				    {
				    	$item_uids = explode(',',$item['relates']);
				    }

                                    foreach($member as $m){
				    	if(in_array($m['id'],$item_uids))
					{
                                    ?>
                                        
                                        <option selected value="<?php echo $m['id']; ?>"><?php echo $m['nickname'] . "[" . $m['email'] . "]"; ?></option>
				    <?php 
				    	}
				    ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname'] . "[" . $m['email'] . "]"; ?></option>
                                        
                                    <?php
                                    }
                                    ?>
                                    </select>
    </div>
</div> 

<div class="form-group" <?php if(!$is_burden) echo 'hidden'?>>
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
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">商家</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" name="merchant" class="form-controller col-xs-12" value="<?php echo $item['merchants']; ?>" placeholder="消费商家">
                                </div>
                            </div>

<?php if(count($tags) > 0){ ?>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">标签</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select class="chosen-select tag-input-style" name="tags[]" multiple="multiple" data-placeholder="请选择标签">
<?php 
                                                $_tags = explode(",", $item['tags']);
                                                foreach($tags as $category) { 
                                                    if(in_array($category['id'], $_tags)){
                                        ?>

                                        <option selected value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                        <?php 
                                                    } else {
?>
                                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
<?php 
                                        } } ?>
                                    </select>

                                </div>
                            </div>
<?php  } ?>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">类型</label>
                                <div class="col-xs-6 col-sm-6">
    <input type="hidden" value="<?php echo $item['prove_ahead']; ?>">
<?php 
                                                $_prove_dict = array('0' => '报销', '2' => '预借', '1' => '预算');
?>
    <input type="hidden" value="<?php echo $item['prove_ahead']; ?>">
                                    <select class="form-control" name="type" data-placeholder="请选择类型">
<?php 
                                            foreach($_prove_dict as $val => $key){
                                                if($val == $item['prove_ahead']){
?>
<option value="<?php echo $val; ?>" selected><?php echo $key; ?></option>
<?php
                                                } else {
						if($__config && $__config['disable_borrow'] == 0 && $val == 1)
						{
?>
<option value="<?php echo $val; ?>"><?php echo $key; ?></option>
<?php
					    }
					    if($__config && $__config['disable_budget'] == 0 && $val == 2)
					    {
?>
<option value="<?php echo $val; ?>"><?php echo $key; ?></option>
<?php
					    }
                        if($val == 0)
                        {
                            ?>
                            <option value="<?php echo $val; ?>"><?php echo $key; ?></option>
                            <?php
                        }

                                            }
                                            }
?>
                                    </select>
                                </div>
                            </div>

<?php
$extra = array();
foreach($item['extra'] as $i) {
    $extra[$i['id']] = $i['value'];
}
foreach($item_config as $s) {
    $_val = '';
    if(array_key_exists($s['id'], $extra)){
        $_val = $extra[$s['id']];
    }
    if(!array_key_exists($s['id'], $extra)) continue;
    if($s['cid'] == -1  && $s['type'] == 1) {
?>
<div class="form-group">
<label class="col-sm-1 control-label no-padding-right"><?php echo $s['name']; ?></label>
<div class="col-xs-6 col-sm-6">
<textarea data-type="<?php echo $s['id']; ?>" name="extra_<?php echo $s['id']; ?>" class="col-xs-12 col-sm-12  extra_textarea form-controller" ><?php echo $_val; ?></textarea>
</div>
</div>
<?php
    }
}
?>
<input type="hidden" name="hidden_extra" id="hidden_extra" value="">


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">备注</label>
                                <div class="col-xs-6 col-sm-6">
                                    <textarea name="note" id="note" class="col-xs-12 col-sm-12  form-controller" ><?php echo trim($item['note']); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">照片</label>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="col-xs-12 col-sm-12">
                                        <ul class="ace-thumbnails clearfix" id="imageList">
                                        </ul>
                                    </div>
                                    <div class="col-xs-12 col-sm-12">
                                        <a id="filePicker" >选择图片</a>
                                    </div>
                                    </div>
                            </div>
<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">附件</label>
<div class="col-xs-6 col-sm-6">
<div id="uploader-file">
    <!--用来存放文件信息-->
    <div id="theList" class="uploader-list">
    </div>
    <div class="col-xs-12 col-sm-12" style="padding-left: 0px; padding-top: 10px;">
        <div id="picker">选择附件</div>
        <span style="position: relative;top: -31px;left: 100px;">支持word,PDF,excel,PPT格式文件</span>
    </div>
</div>
</div>
</div>
<input type="hidden" name="attachments" id="files" >

                            <input type="hidden" id="renew" value="0" name="renew">
                            <input type="reset" style="display:none;" id="reset">
                            <div class="clearfix form-actions col-sm-8 col-xs-8">
                                <div class="col-md-offset-3 col-md-8">
                                    <!--
                                    <a class="btn btn-white btn-primary renew" data-renew="1"><i class="ace-icon fa fa-check"></i>提交</a>
                                    -->

                                    <a class="btn btn-white btn-default renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>

                                    <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="images" id="images"  value="<?php echo $images_ids; ?>">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!--
<script src="/static/third-party/jfu/js/vendor/jquery.ui.widget.js"></script>
<script src="/static/third-party/jfu/js/jquery.iframe-transport.js"></script> -->
<link rel="stylesheet" type="text/css" href="/static/third-party/webUploader/webuploader.css">

<!--引入JS-->
<script type="text/javascript" src="/static/third-party/webUploader/webuploader.js"></script>
<script src="/static/ace/js/jquery.colorbox-min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    function loadFiles() {
        for (var i = 0; i < __files.length; i++) {
            var file = __files[i];
            var $li = $(
            '<div id="FILE_' + file.id + '" style="position:relative;float:left;border: 1px solid #ddd;border-radius: 4px;margin-right: 15px;padding: 5px;">' +
                '<img style="width:128px">' +
                '<p style="text-align: center;margin: 0;max-width: 128px;">'+file.filename+'</p>'+
                '<div class="glyphicon glyphicon-trash red del-button_" style="  position: absolute;right: 10px;top: 10px;cursor: pointer;"></div>' +
                '<div class="ui-icon ace-icon fa fa-download blue download-button_" style="  position: absolute;right: 10px;bottom: 10px;cursor: pointer;"></div>' +
            '</div>'
            ),$img = $li.find('img');
            // $list为容器jQuery实例
            $('#theList').append( $li );
            var path = "/static/images/", name_ = getPngByType(file.filename);
            $img.attr( 'src', path+name_);
            bind_event_file();
            var imageDom = $('#' + file.id);
            filesDict["FILE_"+String(file.id)] = String(file.id);
            filesUrlDict["FILE_"+String(file.id)] = String(file.url);
            if ($("input[name='attachments']").val() == '') {
                $("input[name='attachments']").val(file.id);
            } else {
                $("input[name='attachments']").val($("input[name='attachments']").val() + ',' + file.id);
            }
        }
    }
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
    var path = "/static/images/", name_ = getPngByType(file.name);
    $img.attr( 'src', path+name_);
    bind_event_file();
});
function getPngByType(filename) {
    var types = filename.split('.');
    var type = types[types.length-1];
    var name_ = "";
    switch(type) {
        case "xls":
        case "xlsx":
            name_ = "excel.png";
            break;
        case "ppt":
        case "pptx":
            name_ = "powerpoint.png";
            break;
        case "docx":
        case "doc":
            name_ = "word.png"
            break;
        case "pdf":
            name_ = "pdf.png"
            break;
    }
    return name_;
}
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
            window.open(url);
            /*var aLink = document.createElement('a');
            aLink.href = url;
            aLink.click();*/
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
loadFiles();
});
var filesDict = {};
var filesUrlDict = {};
</script>
<script language="javascript">

var simbol_dic = {'cny':'人民币','usd':'美元','eur':'欧元','hkd':'港币','mop':'澳门币','twd':'新台币','jpy':'日元','ker':'韩国元',
                              'gbp':'英镑','rub':'卢布','sgd':'新加坡元','php':'菲律宾比索','idr':'印尼卢比','myr':'马来西亚元','thb':'泰铢','cad':'加拿大元',
                              'aud':'澳大利亚元','nzd':'新西兰元','chf':'瑞士法郎','dkk':'丹麦克朗','nok':'挪威克朗','sek':'瑞典克朗','brl':'巴西里亚尔'
                             }; 
var icon_dic = {'cny':'￥','usd':'$','eur':'€','hkd':'$','mop':'$','twd':'$','jpy':'￥','ker':'₩',
                              'gbp':'£','rub':'Rbs','sgd':'$','php':'₱','idr':'Rps','myr':'$','thb':'฿','cad':'$',
                              'aud':'$','nzd':'$','chf':'₣','dkk':'Kr','nok':'Kr','sek':'Kr','brl':'$'
                             }; 
var _currency = "<?php echo $item['currency'];?>";
var typed_currency = [];

var _ddt = "<?php echo $ddt; ?>";
var _average = "<?php echo $average; ?>";
var subs = "<?php echo $profile['subs'];?>";
var __item_config = '<?php echo json_encode($item_config);?>';
var __files = <?php echo json_encode($item["attachments"]);?>;
var item_config = [];

if(__item_config != '')
{
    try{
        item_config = JSON.parse(__item_config);
    }catch(e){
       
    }
}
var _item_config = new Object();
for(var i = 0 ; i < item_config.length; i++)
{
    if(item_config[i]['type']==2 || item_config[i]['type'] == 5 || item_config[i]['type'] == 1) {
        _item_config[item_config[i]['cid']] = item_config[i];
    }
}


var category_name = '<?php echo $category_name; ?>';
var ifUp = 1;
var __BASE = "<?php echo $base_url; ?>";
var _images = '<?php echo $images; ?> ';    
var own_id = '<?php echo $profile['id'] ?>';
var item_user_id = '<?php echo $item['uid'] ?>';

var sob_id = <?php echo $sob_id; ?>;
var config = '<?php echo $_config?>';
if(config != '')
{
var __config = JSON.parse(config);
}

var _item_category = '<?php echo $item['category']; ?>';
var flag = 0;
var __config_id = "<?php echo $config_id; ?>";
var __config_type = "<?php echo $config_type; ?>";
function get_sobs(){
   var selectPostData = {};
   var selectDataCategory = {};
   var selectDataSobs = '';
   var _url = __BASE + "category/get_my_sob_category";
   if(own_id != item_user_id) {
   	_url = _url +  '/' + item_user_id;
   }
        $.ajax({
            url : _url,
            dataType : 'json',
            method : 'GET',
            success : function(data){
  
                var _lost_sob = 0;
                for(var item in data) {
                  
                    var _h = '';
                    if(item == sob_id) {
                        _lost_sob = 1;
                        _h = "<option selected='selected' value='" +  item + "'>"+  data[item].sob_name + " </option>";
                    } else {
                        _h = "<option value='" +  item + "'>"+  data[item].sob_name + " </option>";
                    }
                    selectDataCategory[item] = data[item]['category'];

                    selectDataSobs += _h;
      
                }
                if(_lost_sob == 0) {
                    _h = "<option selected='selected' value='" + sob_id + "'> - [原帐套] </option>";
                    selectDataSobs += _h;
                }
                //selectDataCategory[sob_id] = data[sob_id]['category'];
                //selectDataCategory[sob_id] = [{'id' : sob_id, 'category_name' : category_name}];
                //selectDataSobs = _h;
                selectPostData = data;
                updateSelectSob(selectDataSobs);
         
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {}
        });


        var _sid = 0;
        $('#sobs').change(function(){
            var s_id = $(this).val();
           
            var _h = '';
            if(selectDataCategory[s_id] != undefined)
            {
                for(var i = 0 ; i < selectDataCategory[s_id].length; i++)
                {
                    if(selectDataCategory[s_id][i].category_id == _item_category) {
                        _sid = s_id;
                        _h += "<option selected='selected' value='" +  selectDataCategory[s_id][i].category_id + "'>"+  selectDataCategory[s_id][i].category_name  + " </option>";
                    } else {
                        _h += "<option value='" +  selectDataCategory[s_id][i].category_id + "'>"+  selectDataCategory[s_id][i].category_name  + " </option>";
                    }
                    
                }
            }
            $("#sobs").attr("value", _sid);
            $(this.nextElementSibling).empty().append(_h).trigger("chosen:updated");
            $('#sob_category').trigger('change');
            $('#sob_category').trigger('change:updated');
            $('#hidden_category').val(_item_category);
           
        });
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
    pick: '#filePicker',

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
    ifUp = 0;

    // $list为容器jQuery实例
    $('#imageList').append( $li );

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

    // 避免重复创建
    if ( !$percent.length ) {
        $percent = $('<p class="progress"><span></span></p>')
                .appendTo( $li )
                .find('span');
    }
    ifUp = 0;
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
    ifUp = 1;
    $success.text('上传成功');
});


// 文件上传失败，显示上传出错。
uploader.on( 'uploadError', function( file ) {
    var $li = $( '#'+file.id ),
        $error = $li.find('div.error');
    ifUp = 1;
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
});

function updateSelectSob(data) {
    $("#sobs").empty();
    $("#sobs").append(data);
    $("#sobs").trigger('change');
    $("#sobs").trigger("chosen:updated");
}
function bind_event(){
    $('.del-button').click(function(e) {
            var key = imagesDict[this.parentNode.id].split("WU_FILE_")[1];
            var images = $("input[name='images']").val();
            var arr_img = images.split(',');
            var result = '';
            for (var item = 0; item < arr_img.length; item++) {
                if (arr_img[item] != key) {
                    if (item == 0) result += arr_img[item];
                    else result += ',' + arr_img[item];
                }
            }
            $("input[name='images']").val(result);
            $(this.parentNode).remove();
        });
}
function load_exists(){
    var images = eval("(" + _images + ")");
    $('#imageList').empty();
    var result = '', flag_ = 0;
    $(images).each(function(idx, item) {
        if (flag_ == 0) {
            result = String(item.id);
            flag_ = 1;
        }   else {
            result += ',' + String(item.id);
        }
        imagesDict['WU_FILE_'+String(item.id)] = 'WU_FILE_'+String(item.id);
        var $li = $(
            '<div id="WU_FILE_' + item.id + '" style="position:relative;float:left;border: 1px solid #ddd;border-radius: 4px;margin-right: 15px;padding: 5px;">' +
                '<img style="width:150px;height:150px;">' +
                '<div class="glyphicon glyphicon-trash red del-button" style="  position: absolute;right: 10px;top: 10px;cursor: pointer;"></div>' +
            '</div>'
            ),$img = $li.find('img');
    // $list为容器jQuery实例
    $('#imageList').append( $li );

    // 创建缩略图
    // 如果为非图片文件，可以不用调用此方法。
    // thumbnailWidth x thumbnailHeight 为 100 x 100

        $img.attr('src', item['url']);
    });
    $('input[name="images"]').val(result);
    bind_event();
}

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
        $('#rate').val(Math.round(coin_list[1]*10000)/1000000);
    }
    else
    {
         $('#rate_type').text('现钞卖出价');
         $('#rate_amount').text('1.0');
         $('#rate').val('1.0');
    }
    
    $('#amount').trigger('change');
    $('#amount').trigger('change:updated');
    
});

$('#amount').change(function(){
    var temp = $('#coin_type').val();
    var coin_list = temp.split(',');
    $('#coin_simbol').text(icon_dic[coin_list[0]]);
    var _amount = $('#amount').val();
    $('#rate_simbol').text('￥' + Math.round(_amount*coin_list[1])/100);
});

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

            if(_currency != 'cny')
            {
                $('#coin_type').val(_currency+','+data[_currency]).prop('selected',true).trigger('chosen:updated');
            }
            else
            {
                $('#coin_type').val(_currency+','+'100').prop('selected',true).trigger('chosen:updated');
            }
            $('#coin_type').trigger('change');
            $('#coin_type').trigger('chosen:updated');
        },
        error:function(a,b,c){
        
        }
    });
}
*/


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



            var _h = '';
            for(var item in data)
            {
                typed_currency[item] = JSON.parse(data[item]);
                _h += '<option value="' + item + ',' + typed_currency[item]['value'] +'">' + simbol_dic[item] + '</option>';
            }
            $('#coin_type').append(_h);

            if(_currency != 'cny')
            {
                $('#coin_type').val(_currency+','+typed_currency[_currency]['value']).prop('selected',true).trigger('chosen:updated');
            }
            else
            {
                $('#coin_type').val(_currency+','+'100').prop('selected',true).trigger('chosen:updated');
            }
            $('#coin_type').trigger('change');
            $('#coin_type').trigger('chosen:updated');
        },
        error:function(a,b,c){
          
        }
    });
}


var __multi_time = 0;

var __average_count = 0;
$(document).ready(function(){
    if(__config['open_exchange']){
       // get_currency();
       get_typed_currency();
    }

    get_sobs();
    var _dt = $('#dt').val();
    var images = eval("(" + _images + ")");
    $('#people-nums').val(_average);
   
    $('#date-timepicker1').datetimepicker({
        language: 'zh-cn',
        defaultDate: _dt,
        format: 'YYYY-MM-DD HH:mm:ss',
        linkField: "dt1",
    }).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
    
    $('#config_id').val(__config_id);
    $('#config_type').val(__config_type);

    try{
        //var _ddt = $('#dt_end').val();
        $('#date-timepicker2').val(_ddt);
            $('#date-timepicker2').datetimepicker({
                language: 'zh-cn',
                defaultDate: _ddt,
                format: 'YYYY-MM-DD HH:mm:ss',
                linkField: "dt_end1",
                }).next().on(ace.click_event, function(){
                    $(this).prev().focus();
                });
    }catch(e) {
    }

    $('.chosen-select').chosen({allow_single_deselect:true}); 
    $(window)
        .off('resize.chosen')
        .on('resize.chosen', function() {
            $('.chosen-select').each(function() {
                var $this = $(this);
                $this.next().css({'width': $this.parent().width()});
            })
        }).trigger('resize.chosen');
    load_exists();

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


$('#sob_category').change(function(){
            __multi_time = 0;
            __average_count = 0;
            $('#endTime').hide();
            $('#average').hide();
      
       var category_id = $('#sob_category').val();
    
    $('#hidden_category').val(category_id);
        if(_item_config[category_id]!=undefined && _item_config[category_id]['type'] == 2)
        {
            __multi_time = 1;
            $('#config_id').val(_item_config[category_id]['id']);
            $('#config_type').val(_item_config[category_id]['type']);
            $('#date-timepicker2').val(_ddt);
            $('#endTime').show();
        }
        else if(_item_config[category_id]!=undefined && _item_config[category_id]['type'] == 5)
        {
               $('#config_id').val(_item_config[category_id]['id']);
                $('#config_type').val(_item_config[category_id]['type']);
                $('#amount').change(function(){
                    var all_amount = $('#amount').val();
                    var rates = $('#coin_type').val().split(',')[1];
                    all_amount *= rates/100;
                    if (subs != '' && subs >= 0)
                        $('#average_id').text(Number(all_amount/subs).toFixed(2) +'元/人');
                    else
                        $('#average_id').text("请输入正确人数");
                });
                $('#people-nums').change(function() {
                    subs = $('#people-nums').val();
                    $('#amount').change();
                });
                $('#people-nums').trigger('change');
                $('#people-nums').trigger('change:updated');
                var all_amount = $('#amount').val();
                var rates = $('#coin_type').val().split(',')[1];
                all_amount *= rates/100;
                $('#average_id').text(Number(all_amount/subs).toFixed(2) +'元/人');
                $('#average').show();
        } else if(_item_config[category_id]!=undefined && _item_config[category_id]['type'] == 1) {
            $('#config_id').val(_item_config[category_id]['id']);
            $('#config_type').val(_item_config[category_id]['type']);
            $('#note_2').show();
        } else {
            $('#config_id').val('');
            $('#config_type').val('');
            $('#date-timepicker2').val(_ddt);
            $('#endTime').hide();
        }
        
    });

	var afford_type = "<?php echo $fee_afford_type;?>";
	var af_ids = "<?php echo $fee_afford_ids;?>";
	var _af_ids = af_ids.split(',');
	$('#afford_type').val(afford_type).trigger('chosen:updated').trigger('change');
	$('.afford_chose').val(_af_ids).trigger('chosen:updated').trigger('change');

    $('.renew').click(function(){
        var _affid = '';
        try {
            _affid = $('.afford_chose').val().join(',');
        }catch(e) {}
        $('#afford_ids').val(_affid);

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
                //$('#date-timepicker1').focus();
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
        if (ifUp == 0) {
            show_notify('正在上传图片，请稍候');
            return false;
        }
        if(__average_count && $('#config_type').val()==5 && $('#people-num').val() == null && $('#people-nums').val() == 0) {
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
        $('#mainform').submit();
    });
    $('.cancel').click(function(){
        history.go(-1);
        //$('#reset').click();
    });
    //initUploader();
});
var imagesDict = {};
</script>
