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
                                if(array_key_exists('open_exchange', $__config) && $__config['open_exchange'] == 1)
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
                                                    echo round($item['amount'],2);
                                                }
                                                else
                                                {
                                                    echo round($item['amount'] * $item['rate']/100,2);
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
                                <div class="col-xs-12 col-sm-12">
                                    <input type="text" class="form-controller col-xs-12" name="amount" placeholder="分类" value="<?php 
                                        $afford = $item['fee_afford'];
                                        $_parts = explode("|", $afford);
                                        $final = array();
                                        foreach ($_parts as $p) {
                                            array_push($final,$p);
                                        }
                                        echo implode(",", $final);
                                        ?> " disabled >
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
                                        <div id="average_id" name="average" type="text" class="form-control"><?php $_ava = $item['amount']/$item_value[5]['value'];  echo sprintf("%.2f", $_ava);   ?>元/人*<?php echo $item_value[5]['value']?></div>

                                    </span>
                                </div>
                            </div>
                        </div> -->


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
                                        $_ava = $item['amount'];
                                        if($item_value[5]['value'] != 0)
                                        {
                                            $_ava = $item['amount']/$item_value[5]['value'];  
                                        }
                                        echo sprintf("%.2f", $_ava);   ?>元/人*<?php echo $item_value[5]['value']?></div>


                                </div>
                            </div>

                        </div>
                         <?php
                                }
                            ?>



<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">参与人</label>
    <div class="col-xs-3 col-sm-3">
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
                                    <input type="text" class="form-controller col-xs-12" name="amount" placeholder="标签" value=" <?php echo $item['prove_ahead_name']; ?> " disabled>
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
                                        ?>
                                            <a class="btn btn-white btn-primary renew" href="<?php echo base_url('items/edit/' . $item['id']); ?>" data-renew="1"><i class="ace-icon fa fa-check"></i>修改</a>
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
var __BASE = "<?php echo $base_url; ?>";
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


$(document).ready(function(){
    $('.chosen-select').chosen({allow_single_deselect:true}); 
    $(window)
        .off('resize.chosen')
        .on('resize.chosen', function() {
            $('.chosen-select').each(function() {
                var $this = $(this);
                $this.next().css({'width': $this.parent().width()});
            })
        }).trigger('resize.chosen');
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
    $('.cancel').click(function(){
       
        history.go(-1);
    });
	var afford_type = "<?php echo $fee_afford_type;?>";
	$('#afford_type').val(afford_type).trigger('chosen:updated').trigger('change');

});
</script>
