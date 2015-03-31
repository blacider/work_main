<link rel="stylesheet" type="text/css" href="/static/datatables/css/jquery.dataTables.css" />
<link rel="stylesheet" type="text/css" href="/static/css/main.css" />
<link rel="stylesheet" type="text/css" href="/static/datatables/TableTools/css/dataTables.tableTools.css" />
<style>
    td {
        text-align:center;
    }
</style>
<script language="javascript" src="/static/js/jquery-ui.min.js"></script>
<script language="javascript" src="/static/slider/js/jssor.slider.min.js"></script>

<div class="clear box mainpart">
    <div class="fl mainpart_left">
        <div class="main_choose">
            <div class="main_choose_hd"><span class="fl tit">筛选</span>
                <!-- <span class="fr btn_reset"><a href="javascript:void(0)" class="br3">重置</a></span> -->
            </div>
            <div class="main_choose_bd">
                <div class="clear br3 main_choose_search">
                    <input id="search_prop" type="search" class="fl inp" placeholder="报告名、提交者、审批人" />
                    <input name="" type="button"  class="fr btn"/>
                </div>
                <div class="clear main_choose_date">
                    <input name="" type="text" class="fl br3 date date_1" id="datepicker_1" />
                    <span class="fl txt">至</span>
                    <input name="" type="text" class="fr br3 date date_2" id="datepicker_2" />
                </div>
                <div class="clear  br3 main_choose_nav main_choose_nav_1">
                    <ul>
                        <li data-pa="-1" class="pa active "><a href="javascript:void(0)">全部</a></li>
                        <li data-pa="0" class="pa"><a href="javascript:void(0)">已消费</a></li>
                        <li data-pa="1" class="pa"><a href="javascript:void(0)">预审批</a></li>
                    </ul>
                </div>

                <div class="clear  br3 main_choose_check" id="main_choose_checker">
                    <a href="javascript:void(0)" class="br3 st btn btn_0"> <input data-st="0" name="" type="checkbox" checked="checked" /> 待提交</a>
                    <a href="javascript:void(0)" class="br3 st btn btn_1"> <input data-st="1" name="" type="checkbox" checked="checked" /> 审核中</a>
                    <a href="javascript:void(0)" class="br3 st btn btn_2"> <input data-st="2" name="" type="checkbox" checked="checked"  /> 已通过</a>
                    <a href="javascript:void(0)" class="br3 st btn btn_3"> <input data-st="3" name="" type="checkbox" checked="checked"  /> 被退回</a>
                    <a href="javascript:void(0)" class="br3 st btn btn_6"> <input data-st="6" name="" type="checkbox" checked="checked"  /> 待支付</a>
                    <a href="javascript:void(0)" class="br3 st btn btn_4"> <input data-st="4" name="" type="checkbox" checked="checked"  /> 已完成</a>
                </div>
            </div>
        </div>
    </div>
    <div class="fr mainpart_right">
        <div class="main_table main_table_3" style="height:985px">
            <div class="main_table_nav"> <span class="link">
                    <a data-types="1" id="t_0" class="types active" href="<?php echo base_url('reports/index/1'); ?>">我创建的</a>&nbsp;/&nbsp;
                    <a data-types="0" id="t_1" class="types" href="<?php echo base_url('reports/index/0'); ?>">需要我审批的<i></i></a>
                    <span class="fr btn">
                        <a href="javascript:void(0)" style="display:none" class="br3 creatBtn_1">+创建报告</a>
                    </span> 
           </div>
           <div class="main_table_bd">
               <table id="data" class="display dataTable no-footer" cellspacing="0" width="100%" role="grid" style="width: 100%;">
                   <thead>
                       <tr>
                           <th></th>
                           <th style="text-align: center;">创建时间</th>
                           <th style="text-align: center;">报告名</th>
                           <th style="text-align: center;">费用条数</th>
                           <th style="width: 80px; text-align: center; line-height: 35px; overflow: hidden; ">金额总计</th>
                           <th style="display:none;">状态</th>
                           <th style="display:none;">PA</th>
                           <th style="display:none;">DT</th>
                       </tr>
                   </thead>

                   <tbody>

<?php
foreach($items as $item){
    //                        print_r($item);
?>

<tr data-id="<?php echo $item['id']; ?>" style="height: 64px">
    <td style="width:10px;padding-right:1px;">
        <?php if($item['prove_ahead']){ ?>
        <span class="icon">
            <i class="icon_yu"><img src="/static/images/icon_yu.png" /></i>
        </span>
        <?php } ?>
    </td>
    <td style="width: 66px; padding-left: 14px; overflow: hidden;">
        <?php echo date('m月d日', $item['lastdt']); ?>
    </td>
    <td style="width: 116px; padding-left: 14px; overflow: hidden;">
        <?php echo $item['title']; ?>
    </td>
    <td style="text-align: center;">
        <?php echo $item['item_count']; ?>
    </td>
    <td style="width: 60px;
        text-align: center;
        line-height: 35px;
        overflow: hidden;
        ">
        <i class="tstatus tstatus_<?php echo $item['status'];?>"></i>
        
        <strong class="price">&yen;<?php echo $item['amount']?></strong>
    </td>
    <td style="display:none;"><?php echo $item['status']; ?></td>
    <td style="display:none;"><?php echo $item['prove_ahead']; ?></td>
    <td style="display:none;"><?php echo $item['createdt']; ?></td>
</tr>


<?php
}
?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div id="darkbg" style="display:none;"></div>
<div id="report_detail"  style="display:none;" class="pop_creat pop_creat_1">
    <div class="pop_creat_hd"><span class="fl tit">报告详情</span><span class="fr close"><a href="javascript:void(0)"></a></span></div>
    <div class="pop_creat_bd" id="report_body">
        <div class="pop_creat_form">
            <ul>
                <li><span class="fl tit">报告名：</span>
                <div class="fl con">
                    <input name="" type="text" class="inp inp_1" id="reportname" value="" />
                </div>
                </li>
                <li><span class="fl tit">日期：</span>
                <div class="fl con "><i class="name"><a href="javascript:void(0)" class="br3"></a></i>
                    <input name="" type="text" id="dt" class="inp inp_1" value="" />
                </div>
                </li>
                <li><span class="fl tit">费用：</span>
                <div class="fl con "><i class="name"><a href="javascript:void(0)" class="br3"></a></i>
                    <input name="" type="text" class="inp inp_1" id="amount" value="" />
                </div>
                </li>
            </ul>
        </div>
        <div class="clear pop_creat_table">
            <div class="main_table main_table_5">
                <div class="main_table_hd"> <span class="fl n1">日期</span> <span class="fl n2">商家</span> <span class="fl n3">类别</span> <span class="fl n4">发票</span> <span class="fl n5">说明</span> <span class="fl n6">金额</span> </div>
                <div class="main_table_bd">
                    <ul id="itemlists">
                    </ul>
                </div>
                <!-- <div class="main_table_add"><a href="javascript:void(0)">+继续添加</a></div>-->
            </div>
        </div>
    </div>
    <div id="back" class=""><a href="javascript:void();" id="btn_back" class="btn">返回</a></div>
    <!-- <div class="pop_creat_ft"><a href="javascript:void(0)" class="br3 btn">提交</a></div>-->
</div>

<script language="javascript" src="/static/js/jquery.cookie.js"></script>
<script language="javascript" src="/static/datatables/js/jquery.dataTables.js"></script>
<script language="javascript" src="/static/datatables/TableTools/js/dataTables.tableTools.js"></script>
<script language="javascript">
Date.prototype.Format = function(fmt)   
{ //author: meizz   
    var o = {   
        "M+" : this.getMonth()+1,                 //月份   
            "d+" : this.getDate(),                    //日   
            "h+" : this.getHours(),                   //小时   
            "m+" : this.getMinutes(),                 //分   
            "s+" : this.getSeconds(),                 //秒   
            "q+" : Math.floor((this.getMonth()+3)/3), //季度   
            "S"  : this.getMilliseconds()             //毫秒   
    };   
    if(/(y+)/.test(fmt))   
        fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));   
    for(var k in o)   
        if(new RegExp("("+ k +")").test(fmt))   
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));   
    return fmt;   
}
var _LAST = '';
        var _TITLE = '';
        var _AMOUNT = '';
        var _DT = '';
    var _BASE = "<?php echo base_url(); ?>";
    var _type = "<?php echo $type; ?>";
    $(document).ready(function(){
        $('#report_detail').hide();
        $('#darkbg').hide();
        $('#btn_back').click(function(){
            if(_LAST){
                var _l = $('#report_body').html();
                $('#report_body').html(_LAST);
                _LAST =  _l;
                $('#back').hide();
                $($('#reportname').get(0)).val(_TITLE);
                $($('#dt').get(0)).val(_DT);
                $($('#amount').get(0)).val(_AMOUNT);
                $('.invoice').click(function(){
                    $('#back').show();
                    var _imgs = $(this).data('img').split(",");
                    var _sbuf = '' 
                        + '<div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 600px; height: 300px;">'
                        + '<div u="slides" style="cursor: move; position: absolute; overflow: hidden; left: 0px; top: 0px; width: 600px; height: 300px;">';
                    for(var i = 0; i < _imgs.length; i++){

                        _sbuf +=  '<div><img u="image" src="http://reim-avatar.oss-cn-beijing.aliyuncs.com/' + _imgs[i] + '" /></div>'
                    }
                    + '</div><div class="">返回</div>'
                        + '</div>';
                    _LAST = $('#report_body').html();
                    $('#report_body').html(_sbuf);
                    var options = { 
                        $AutoCenter: 1,
                        $FillMode: 1,
                        $AutoPlay: 1,
                        $BulletNavigatorOptions: {
                            $Class: $JssorBulletNavigator$,
                                $ChanceToShow: 2
                        }
                    };
                    var jssor_slider1 = new $JssorSlider$('slider1_container', options);
                });
            }
        });

    $('#data tbody').on('click', 'tr', function (e, data) {
        _LAST = null;
        var id = $(this).data('id');
        if(_LAST) {
                var _l = $('#report_body').html();
            $('#darkbg').show();
            $('#report_detail').show();
            $('#report_body').html(_LAST);
            $('#back').hide();
            _LAST = _l;
                $('.invoice').click(function(){
                    $('#back').show();
                    var _imgs = $(this).data('img').split(",");
                    var _sbuf = '' 
                        + '<div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 600px; height: 300px;">'
                        + '<div u="slides" style="cursor: move; position: absolute; overflow: hidden; left: 0px; top: 0px; width: 600px; height: 300px;">';
                    for(var i = 0; i < _imgs.length; i++){

                        _sbuf +=  '<div><img u="image" src="http://reim-avatar.oss-cn-beijing.aliyuncs.com/' + _imgs[i] + '" /></div>'
                    }
                    + '</div><div class="">返回</div>'
                        + '</div>';
                    _LAST = $('#report_body').html();
                    $('#report_body').html(_sbuf);
                    var options = { 
                        $AutoCenter: 1,
                        $FillMode: 1,
                        $BulletNavigatorOptions: {
                            $Class: $JssorBulletNavigator$,
                                $ChanceToShow: 2
                        }
                    };
                    var jssor_slider1 = new $JssorSlider$('slider1_container', options);
                });
                $($('#reportname').get(0)).val(_TITLE);
                $($('#dt').get(0)).val(_DT);
                $($('#amount').get(0)).val(_AMOUNT);
            return;
         }
            
        $.getJSON(_BASE + "reports/detail/" + id).success(function(data){
            if(data.status > 0){
                    $('#itemlists').html('');
            $('#back').hide();
                    _AMOUNT 
                var _amount = 0;
                var _data = data['data'];
                $('#reportname').val(_data['title']);
                _TITLE = _data['title'];
                _dt = new Date(_data['createdt'] * 1000).format("yyyy-MM-dd hh:mm:ss")
                $('#dt').val(_dt);
                _DT = _dt;
                var items = _data['items'];
                for(var i = 0; i < items.length; i++){
                    var o = items[i];
                    _amount += (1 * o['amount']);
                    var _ims = '    <span class="fl n4"><i class="br3"> 没有发票 </i></span> '

                    if(o['image_paths']){
                        _ims = '    <span class="fl n4"><i class="br3"> <a href="javascript:void(0);" class="invoice" data-img="' +  o['image_paths']+ '">发票</a> </i></span> ';
                    }
                    var _str = "" 
                        +"<li>" ;
                    if(o['prove_ahead'] > 0){
                        _str += '    <span class="icon"> <i class="icon_yu"><img src="/static/images/icon_yu.png" /></i></span> ';
                    }
                        _str += '    <span class="fl n1">' + new Date(o['dt'] * 1000).format("yyyy-MM-dd hh:mm:ss") + ' </span> '
                        +'    <span class="fl n2">&nbsp;' + o['merchants'] + '</span> '
                        +'    <span class="fl n3">' +  o['category_name'] + '</span> '
                        + _ims
                        +'    <span class="fl n5"> &nbsp;' + o['note'] + '</span> '
                        +'    <span class="fl n6"><strong class="price">&yen;' + o['amount'] + '</strong></span> '
                        +'</li>';
                    $('#itemlists').append(_str);
                }
                $('.invoice').click(function(){

                    $('#back').show();
                    var _imgs = $(this).data('img').split(",");
                    var _sbuf = '' 
                        + '<div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 600px; height: 300px;">'
                        + '<div u="slides" style="cursor: move; position: absolute; overflow: hidden; left: 0px; top: 0px; width: 600px; height: 300px;">';
                    for(var i = 0; i < _imgs.length; i++){
                        _sbuf +=  '<div><img u="image" src="http://reim-avatar.oss-cn-beijing.aliyuncs.com/' + _imgs[i] + '" /></div>'
                    }
                    + '</div>'
                        + '</div>'
                        + '<div class="back">返回</div>'
                        ;
                    _LAST = $('#report_body').html();
                    $('#report_body').html(_sbuf);
            $('#back').show();
                    var options = { 
                        $AutoPlay: true,
                        $AutoCenter: 1,
                        $FillMode: 1,
                        $BulletNavigatorOptions: {
                            $Class: $JssorBulletNavigator$,
                                $ChanceToShow: 2
                        }
                    };
                    var jssor_slider1 = new $JssorSlider$('slider1_container', options);
                });
                $('#amount').val(_amount);
                _AMOUNT = _amount;
                $($('#reportname').get(0)).val(_TITLE);
                $($('#dt').get(0)).val(_DT);
                $($('#amount').get(0)).val(_AMOUNT);
        $('#darkbg').show();
        $('#report_detail').show();
            }
        }).error(function(data){});;
        // show loading
    } );
        //if(!_type) _type = 1;
        $('.types').each(function(){
                $(this).removeClass('active');
            if($(this).data('types') == _type){
                $(this).addClass('active');
            }
        });
        //var _url = "<?php echo base_url(); ?>" + "reports/get_suborinate/" + _type;
        var table = $('#data').DataTable({
            //'ajax' : _url,
            'info' : false,
            //"serverSide": true,
            'ordering' : false,
            'pagingType' : 'full_numbers',
            'searching' : true,
            "language": {
                "lengthMenu": "每页展示: _MENU_ 条",
                "zeroRecords": "没有满足要求的数据",
                "info": "_PAGE_ / _PAGES_",
                "infoEmpty": "没有数据",
                "infoFiltered": "(从 _MAX_ 中过滤到)",
                "paginate" :  {
                    "first"  : '第一页',
                    "last"  : '末页',
                    "next"  : '下一页',
                    "previous"  : '上一页',
                },
            },
            "processing": true,
            'initComplete' : function () {
                var api = this.api();
                $('.pa').each(function(){
                    $(this).click(function(){
                        var _pa = $(this).data('pa');
                        var column = api.column(6);
                        if(_pa > -1){
                            column.search('' + _pa).draw();
                        } else {
                            column.search('').draw();
                        }

                    });
                });
            }
        });
        $('.st').each(function(){
            $(this).click(function(){
                var _st = '';
                var _an = $(this).children("input:checkbox").data('st');
                if($(this).children("input:checkbox").attr('checked')){
                    _st = '';
                } else {
                    _st = _an + "|";
                }
                $("#main_choose_checker input:checkbox").each(function () {
                    var __st = $(this).data('st');
                    if (__st != _an && $(this).attr("checked")) {
                        _st += __st + "|";
                    }
                });
                _st = _st.substr(0, _st.length-1);
                if(_st)
                    $('#data').DataTable().column(5).search(_st, true, false).draw();
                else
                    $('#data').DataTable().column(5).search('').draw();
            });
        });
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var min = strDate2Timestamp($('#datepicker_1').val() + " 00:00:00");
                var max = strDate2Timestamp($('#datepicker_2').val() + " 00:00:00");
                var age = parseFloat(data[7] ) * 1000 || 0; // use data for the age column

                if ( ( isNaN( min ) && isNaN( max ) ) ||
                    ( isNaN( min ) && age <= max ) ||
                    ( min <= age   && isNaN( max ) ) ||
                    ( min <= age   && age <= max ) )
                {
                    return true;
                }
                return false;
            }
        );
        $('#search_prop').on('keyup', function(){
            var _key = $(this).val();
            $('#data').DataTable().search(_key).draw();
        });
        var _today = new Date().format('yyyy-MM-dd');
        var _start = strDate2Timestamp(_today + " 00:00:00");
        _start = new Date(_start - 86400 * 1000 * 90).format('yyyy-MM-dd');
        $('#datepicker_1').datepicker({onSelect:function(){table.draw();}});
        $('#datepicker_2').datepicker({onSelect:function(){table.draw();}});
        $('#datepicker_1').val(_start);
        $('#datepicker_2').val(_today);
        $('.types').click(function(){
            var _me = $(this).data('types');
            $.cookie('report_type', _me);
             location.replace(location.href);
        });
    });
</script>
