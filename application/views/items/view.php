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
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">金额</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="amount" placeholder="金额" value=" ￥<?php echo $item['amount']; ?> " disabled>
                                </div>
                            </div>
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
                         <!--   <div disabled class="form-group" id="average" >
                                <label class="col-sm-1 control-label no-padding-right">人均:</label>
                                <div class="col-xs-3 col-sm-3">
                                    <div class="input-group">
                                        <div id="average_id" name="average" type="text" class="form-control"><?php $_eva = $item['amount']/$item_value[5]['value']; echo sprintf("%.2f", $_eva);   ?>元/人*<?php echo $item_value[5]['value']?></div>

                                    </span>
                                </div>
                            </div>
                        </div> 
                        -->

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
                                   if($item_value[5]['value']) 
                                   {
                                       $_ava = $item['amount']/$item_value[5]['value']; 
                                   }
                                   else
                                   {
                                      $_ava = $item['amount']; 
                                   }
                                     echo sprintf("%.2f", $_ava);   ?>元/人*<?php echo $item_value[5]['value']?></div>


                                </div>
                            </div>

                        </div>
                         <?php
                                }
                            ?>


                            <!--

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">参与人</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select disabled class="chosen-select tag-input-style" id="member" name="uids[]" multiple="multiple" data-placeholder="请选择员工">
                
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
                            -->


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">商家</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="amount" placeholder="商家" value=" <?php echo $item['merchants']; ?> " disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">标签</label>
                                <div class="col-xs-6 col-sm-6">

                                    <input type="text" class="form-controller col-xs-12" name="amount" placeholder="标签" value=" <?php echo $item['tags']; ?> " disabled>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">类型</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="amount" placeholder="标签" value=" <?php echo $item['prove_ahead']; ?> " disabled>
                                </div>
                            </div>

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
                '<p style="text-align: center;margin: 0;max-width: 128px;">'+file.filename+'</p>'+
                '<div class="ui-icon ace-icon fa fa-download blue download-button_" style="  position: absolute;right: 10px;top: 10px;cursor: pointer;"></div>' +
            '</div>'
            ),$img = $li.find('img');
            // $list为容器jQuery实例
            $('#theList').append( $li );
            var path = "/static/images/", name_ = getPngByType(file.mime);
            $img.attr( 'src', path+name_);
            filesUrlDict["FILE_"+String(file.id)] = String(file.url);
        }
        bind_event_file();
    }
    function getPngByType(type) {
    var name_ = "";
    switch(type) {
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
    }
    return name_;
}
function bind_event_file(){
        $('#theList .download-button_').click(function(e) {
            var url = filesUrlDict[this.parentNode.id];
            var aLink = document.createElement('a');
            aLink.href = url;
            aLink.click();
        });
}
var __BASE = "<?php echo $base_url; ?>";
var _error = "<?php echo $error ; ?>";

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
