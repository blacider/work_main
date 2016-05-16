<script src="/static/ace/js/jquery.colorbox-min.js"></script>

<!-- page specific plugin styles -->
<link rel="stylesheet" href="/static/ace/css/colorbox.css" />
<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<link rel="stylesheet" href="/static/ace/css/colorbox.css" />
<script src="/static/ace/js/jquery.colorbox-min.js"></script>

<!-- page specific plugin styles -->
<!--<script src="/static/ace/js/jquery1x.min.js"></script> -->
<script src="/static/ace/js/date-time/moment.min.js"></script>
<script src="/static/ace/js/chosen.jquery.min.js"></script>

<script src="/static/ace/js/date-time/moment.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script>





<div class="page-content">
    <div class="page-content-area">
        <form role="form" class="form-horizontal"  enctype="multipart/form-data" >
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                           <?php
                                $_config = '';
                                if(array_key_exists('config',$profile['group']))
                                {
                                    $_config = $profile['group']['config'];
                                }
                                $__config = json_decode($_config,True);
                            ?>
                            <?php
                                if($__config && array_key_exists('open_exchange', $__config) && $__config['open_exchange'] == 1)
                                {
                            ?>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right">金额</label>
                                        <div class="col-xs-6 col-sm-6">

                                      
                                            <select class="col-xs-4 col-sm-4" class="form-control  chosen-select tag-input-style" name="coin_type" id="coin_type" disabled>
                                                
                                            </select> 
                                      
                                            
                                            <div class="input-group input-group">
                                                <span class="input-group-addon" id='coin_simbol'>￥</span>
                                                <input type="text" class="form-controller col-xs-12 col-sm-12" name="amount" id="amount" value="<?php echo $item['amount'];?>" placeholder="金额" required disabled>
                                                <span class="input-group-addon" id='rate_simbol'>￥<?php 
                                                if($item['currency'] == 'cny')
                                                { 
                                                    echo sprintf('%.2f',round($item['amount'],2));
                                                }
                                                else
                                                {
                                                    echo sprintf('%.2f',round($item['amount'] * $item['rate']/100,2));
                                                }

                                                ?></span>
                                            </div>

                                        </div>


                                    </div>
                            <?php
                                }
                                else
                                {
                            ?>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">金额</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="amount" placeholder="金额" value=" ￥<?php 
                                        if($item['currency'] == 'cny')
                                        {
                                            echo $item['amount'];
                                        }
                                        else
                                        {
                                            echo round($item['amount']*$item['rate']/100,2);
                                        } 
                                     ?> " disabled>
                                </div>
                            </div>

                            <?php 
                                }
                            ?>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">分类</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="amount" placeholder="分类" value=" <?php echo $item['category']; ?> " disabled>
                                </div>
                            </div>

                            <div class="form-group" id="burden" <?php if(!$item['fee_afford']) echo 'hidden';?>>
                                <label class="col-sm-1 control-label no-padding-right">承担者</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="amount" placeholder="分类" value=" <?php 
                                        $afford = $item['fee_afford'];
                                        $_parts = explode("|", $afford);
                                       
                                        $final = array();
                                        foreach($_parts as $x) {
                                            array_push($final,$x);
                                        }
                                        echo implode(",", $final);
                                        ?> " disabled>
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">消费时间</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="amount" placeholder="消费时间" value=" <?php echo $item['dt']; ?> " disabled>
                                </div>
                            </div>

                             <?php
                                if(array_key_exists('2',$item_value))
                                {
                            ?>
                             <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">至</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="amount" placeholder="消费时间" value=" <?php echo date('Y-m-d H:i:s',$item_value[2]['value']); ?> " disabled>
                                </div>
                            </div>

                            <?php
                                }
                            ?>




                            <?php
                                if(array_key_exists('5',$item_value))
                                {
                            ?>
                        <div disabled class="form-group" id="average" >
                            <label class="col-sm-1 control-label no-padding-right">人数:</label>
                            <div class="col-xs-3 col-sm-3" disabled>
                                <div class="input-group" >
                                    <input disabled type="text" id="people-nums" name="peoples" value="<?php echo $item_value[5]['value']?>">
                                </div>
                            </div>
                            <label class="col-sm-1 control-label no-padding-right">人均:</label>
                            <div class="col-xs-3 col-sm-3">
                                <div class="input-group">
                                <div id="average_id" name="average" type="text" class="form-control"><?php
                                    if($item['currency'] == 'cny')
                                    { 
                                        $all_amount = round($item['amount'],2);
                                    }
                                    else
                                    {
                                        $all_amount = round($item['amount'] * $item['rate']/100,2);
                                    }
                                    if($item_value[5]['value']) 
                                    {
                                        $_ava = $all_amount/$item_value[5]['value']; 
                                    }
                                    else
                                    {
                                        $_ava = $all_amount; 
                                    }
                                    echo sprintf("%.2f", $_ava);   ?>元/人*<?php echo $item_value[5]['value']?></div>


                                </div>
                            </div>

                        </div>
                         <?php
                                }
                            ?>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">商家</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="amount" placeholder="商家" value=" <?php echo $item['merchants']; ?> " disabled>
                                </div>
                            </div>

                          

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">标签</label>
                                <div class="col-xs-6 col-sm-6">
                                <select class="chosen-select tag-input-style" name="tags[]" multiple="multiple" data-placeholder="请选择标签" disabled>
                                <?php
                                    $tags_item = explode(',',$item['tag_ids']);

                                 foreach($tags as $tag) {
                                        if(in_array($tag['id'], $tags_item))
                                        {
                                    ?>
                                     <option selected value="<?php echo $tag['id']; ?>"><?php echo $tag['name']; ?></option>
                                    <?php
                                     }else
                                     {
                                    ?>

                                    <option value="<?php echo $tag['id']; ?>"><?php echo $tag['name']; ?></option>
                                <?php
                                     } 
                                 }
                                ?>
                                </select>

                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">类型</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="amount" placeholder="标签" value=" <?php echo $item['prove_ahead']; ?> " disabled>
                                </div>
                            </div>


<?php
$extra = array();
foreach($item['extra'] as $i) {
    $extra[$i['id']] = $i['value'];
}
foreach($item_config as $s) {
    $val = '';
    if(array_key_exists($s['id'], $extra)){
        $val = $extra[$s['id']];
    }
    if(!array_key_exists($s['id'], $extra)) continue;
    if($s['cid'] == -1  && $s['type'] == 1) {
?>
<div class="form-group">
<label class="col-sm-1 control-label no-padding-right"><?php echo $s['name']; ?></label>
<div class="col-xs-6 col-sm-6">
<input type="text" class="form-controller col-xs-12" name="amount" placeholder="标签" value=" <?php echo $val; ?> " disabled>
</div>
</div>
<?php
    }
}
?>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">备注</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="amount" placeholder="标签" value=" <?php echo $item['note']; ?> " disabled>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">照片</label>
                                <div class="col-xs-6 col-sm-6 ">
                                    <div class="fallback">
                                        <?php foreach($item['images'] as $i){ ?>
                                        <div class="col-xs-6 col-md-3">
                                            <a href="<?php echo $i['path']; ?>" class="thumbnail" data-rel="colorbox">
                                                <img src="<?php echo $i['path']; ?>" >
                                            </a>
                                        </div>
                                        <?php  } ?>
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
</div>
</div>
</div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">修改记录</label>
                                <div class="col-xs-9 col-sm-9">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td>修改人</td>
                                            <td>修改时间</td>
                                            <td>操作</td>
                                        </tr>
                                        <?php foreach($flow as $i){ ?>
                                        <tr>
                                            <td><?php echo $i['operator']; ?></td>
                                   
                                            <td><?php echo $i['optdate']; ?></td>
                                            <td><?php echo $i['operation']; ?></td>
                                        </tr>
                                        <?php } ?>  
                                    </table>
                                </div>
                            </div>

                            <div class="clearfix form-actions col-sm-8 col-xs-8">
                                <div class="col-md-offset-3 col-md-6">
                                    <?php
                                    if($editable == 1)
                                    {
					$_from_report = 0;
					if (isset($from_report))
					    $_from_report = $from_report;
					
                                        ?>
                                            <a class="btn btn-white btn-primary renew" href="<?php echo base_url('items/edit/' . $item['id'] . "/" . $_from_report); ?>" data-renew="1"><i class="ace-icon fa fa-check"></i>修改</a>
                                        <?php
                                        }
                                        ?>
                                    <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>返回</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script language="javascript">
var filesUrlDict = {};
var __files = <?php echo json_encode($item["attachments"]);?>;
function loadFiles() {
        for (var i = 0; i < __files.length; i++) {
            var file = __files[i];
            var $li = $(
            '<div id="FILE_' + file.id + '" style="position:relative;float:left;border: 1px solid #ddd;border-radius: 4px;margin-right: 15px;padding: 5px;">' +
                '<img style="width:128px">' +
                '<p style="text-align: center;margin: 0;max-width: 128px;">'+decodeURIComponent(file.filename)+'</p>'+
                '<div class="ui-icon ace-icon fa fa-download blue download-button_" style="  position: absolute;right: 10px;top: 10px;cursor: pointer;"></div>' +
            '</div>'
            ),$img = $li.find('img');
            // $list为容器jQuery实例
            $('#theList').append( $li );
            var path = "/static/images/", name_ = getPngByType(file.filename);
            $img.attr( 'src', path+name_);
            filesUrlDict["FILE_"+String(file.id)] = String(file.url);
        }
        bind_event_file();
    }
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
        default:
            name_ = "default.png"
            break;
    }
    return name_;
}
function bind_event_file(){
        $('#theList .download-button_').click(function(e) {
            var url = filesUrlDict[this.parentNode.id];
            window.open(url);
        });
}
var __BASE = "<?php echo $base_url; ?>";
var _error = "<?php echo $error ; ?>";
var _coin_type = "<?php echo $item['currency'];?>";


var simbol_dic = {'cny':'人民币','usd':'美元','eur':'欧元','hkd':'港币','mop':'澳门币','twd':'新台币','jpy':'日元','ker':'韩国元',
                              'gbp':'英镑','rub':'卢布','sgd':'新加坡元','php':'菲律宾比索','idr':'印尼卢比','myr':'马来西亚元','thb':'泰铢','cad':'加拿大元',
                              'aud':'澳大利亚元','nzd':'新西兰元','chf':'瑞士法郎','dkk':'丹麦克朗','nok':'挪威克朗','sek':'瑞典克朗','brl':'巴西里亚尔'
                             }; 
var icon_dic = {'cny':'￥','usd':'$','eur':'€','hkd':'$','mop':'$','twd':'$','jpy':'￥','ker':'₩',
                              'gbp':'£','rub':'₽','sgd':'$','php':'₱','idr':'Rps','myr':'$','thb':'฿','cad':'$',
                              'aud':'$','nzd':'$','chf':'₣','dkk':'Kr','nok':'Kr','sek':'Kr','brl':'$'
                             }; 

$('#coin_type').append("<option selected>" + simbol_dic[_coin_type] + "</option>");
$('#coin_simbol').text(icon_dic[_coin_type]);

if(_error)
{
	show_notify(_error);
}
$(document).ready(function(){

loadFiles();

$('.chosen-select').chosen({allow_single_deselect:true}); 
    $(window)
        .off('resize.chosen')
        .on('resize.chosen', function() {
            $('.chosen-select').each(function() {
                var $this = $(this);
                $this.next().css({'width': $this.parent().width()});
            })
        }).trigger('resize.chosen');


    var $overflow = '';
    var colorbox_params = {
        rel: 'colorbox',
            reposition:true,
            scalePhotos:true,
            scrolling:false,
            previous:'<i class="ace-icon fa fa-arrow-left"></i>',
            next:'<i class="ace-icon fa fa-arrow-right"></i>',
            close:'&times;',
            current:'{current} of {total}',
            maxWidth:'100%',
            maxHeight:'100%',
            onOpen:function(){
                $overflow = document.body.style.overflow;
                document.body.style.overflow = 'hidden';
            },
                onClosed:function(){
                    document.body.style.overflow = $overflow;
                },
                    onComplete:function(){
                        $.colorbox.resize();
                    }
    };

    $('.fallback [data-rel="colorbox"]').colorbox(colorbox_params);
    $('.cancel').click(function() {
<?php if (!isset($previous_url)) { $previous_url = FALSE; } ?>
<?php if ($previous_url) { ?>
        location.href = "<?php echo $previous_url; ?>";
<?php } else { ?>
        history.go(-1);
<?php } ?>
    });
});

</script>
