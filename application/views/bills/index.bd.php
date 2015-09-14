<link rel="stylesheet" type="text/css" href="/static/datatables/css/jquery.dataTables.css" />
<link rel="stylesheet" type="text/css" href="/static/datatables/TableTools/css/dataTables.tableTools.css" />
<script language="javascript" src="/static/js/jquery-ui.min.js"></script>
<script language="javascript" src="/static/slider/js/jssor.slider.min.js"></script>
<div class="clear box mainpart">
    <div class="fl mainpart_left">
        <div class="main_choose">
            <div class="main_choose_hd"><span class="fl tit">筛选</span><!-- <span class="fr btn_reset"><a href="javascript:void(0)" class="br3">重置</a></span>--></div>
            <div class="main_choose_bd">
                <div class="clear br3 main_choose_search">
                    <input id="search_prop" type="search"  class="fl inp" value="报告名、提交者、总额" />
                    <input name="" type="button"  class="fr btn"/>
                </div>
                <div class="clear main_choose_date">
                    <input name="" type="text" class="fl br3 date date_1" value="2014-12-01" id="datepicker_1" />
                    <span class="fl txt">至</span>
                    <input name="" type="text" class="fr br3 date date_2" value="2015-01-01" id="datepicker_2" />
                </div>
                <div class="clear  br3 main_choose_nav main_choose_nav_2">
                    <ul>
                        <li data-pa="-1" class="pa active"><a href="javascript:void(0)">全部</a></li>
                        <li data-pa="2"  class="pa " ><a href="javascript:void(0)">待支付</a></li>
                        <li data-pa="7"  class="pa " ><a href="javascript:void(0)">已结算</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="fr mainpart_right">
        <div class="main_table" style="height:905px">
            <div class="main_table_nav"> 
                <span class="fl link"><i class="tit">核算列表</i></span>
                <span class="fr btn" id="master">
                    <a id="markdown" href="javascript:void(0)" class="br3">+去支付</a></span> 
                    <!--
                    <a href="javascript:void(0)" class="br3">+导出CSV</a>
                -->
            </div>
            <!--
            <div class="main_table_hd"> 
                <span class="fl n1">创建时间</span> 
                <span class="fl n2">报告名</span> 
                <span class="fl n3">费用条数</span> 
                <span class="fl n4">提交者</span> 
                <span class="fl n5">历史审批人</span> 
                <span class="fl n6">金额总计</span> 
            </div>
            -->
            <div class="main_table_bd">
            <table id="data" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="sall"></th>
                        <th></th>
                        <th>日期</th>
                        <th>报告名</th>
                        <th>费用条目</th>
                        <th>提交者</th>
                        <th>金额</th>
                        <th style="display:none;">状态</th>
                        <th style="display:none;">创建时间</th>
                        <th style="display:none;">昵称</th>
                        <th style="display:none;">邮件</th>
                        <th style="display:none;">预申请</th>
                        <th style="display:none;">序号</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach($reports as $item){
                    ?>

                    <tr data-id="<?php echo $item['id']; ?>">
                        <td style="width:20px">
                            <input type="checkbox" class="chb" data-id="<?php echo $item['id']; ?>">
                        </td>
                        <td>
                            <?php if($item['prove_ahead']){ ?>
                            <span class="icon">
                                <i class="icon_yu"><img src="/static/images/icon_yu.png" /></i>
                            </span> 
                            <?php } ?>
                            </td>
                        <td style="width: 116px; padding-left: 14px; overflow: hidden;text-align:center;">
                            <?php echo date('m月d日', $item['createdt'])  ?></td>
                        <td style="width: 90px;
                            text-align: center;
                            overflow: hidden;
                            "><?php echo $item['title']; ?></td>
                        <td style="width: 80px;
                            text-align: center;
                            overflow: hidden;"><?php 
                            echo $item['item_count'];
?></td>
                        <td style="
                            width: 110px;
                            text-align: center;
                            overflow: hidden;
                            "> 
<?php 

                            echo  $item['nickname'] ;
?></td>
                        <td style="width: 80px;
                            text-align: right;
                            line-height: 35px;
                            overflow: hidden;"> 
                            <i class="tstatus tstatus_<?php echo $item['status']; ?>"></i>
                             <strong class="price">&nbsp;&nbsp;&nbsp;&nbsp;&yen;<?php echo $item['amount']; ?> </strong>
                            
                        <td style="display:none;"><?php echo $item['status']; ?></td>
                        <td style="display:none;"><?php echo $item['createdt']; ?></td>
                        <td style="display:none;"><?php echo $item['nickname']; ?></td>
                        <td style="display:none;"><?php echo $item['email']; ?></td>
                        <td style="display:none;"><?php echo $item['prove_ahead']; ?></td>
                        <td style="display:none;"><?php echo $item['id']; ?></td>
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


<script language="javascript" src="/static/datatables/js/jquery.dataTables.js"></script>
<script language="javascript" src="/static/datatables/TableTools/js/dataTables.tableTools.js"></script>
<script language="javascript">
                    var selected = [];
                    var _BASE = "<?php echo base_url(); ?>";
var _LAST = '';
        var _TITLE = '';
        var _AMOUNT = '';
        var _DT = '';
    var _BASE = "<?php echo base_url(); ?>";
$(document).ready(function(){
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

    $('#sall').change(function(){
        if($("#sall").attr("checked")) {
            $('#data tbody tr').each(function(){
                $(this).addClass('selected');
            });
            $('.chb').each(function(){
                $(this).attr('checked', true);
            });
        } else {
            $('#data tbody tr').each(function(){
                $(this).removeClass('selected');
            });
            $('.chb').each(function(){

                $(this).attr('checked', false);
            });
        } 
    });
    var table = $('#data').DataTable({
        'info' : false,
            'ordering' : false,
            'pagingType' : 'full_numbers',
            'searching' : true,
            "language": {
                "lengthMenu": "每页展示: _MENU_ 条",
                    "zeroRecords": "没有满足条件的数据",
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
    });
    $('#data tbody').on('click', 'tr', function (e, data) {
        try{
            var _sch = $($(this).find('input').get(0)).attr('checked');
            if(_sch){
                $($(this).find('input').get(0)).attr('checked', false);
            } else {
                $($(this).find('input').get(0)).attr('checked', true);
            }
        }catch(e){console.log(e); }
        var _item = $(this);
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
    });

    $('.pa').each(function(){
        $(this).click(function(){
            var _pa = $(this).data('pa');
            if(_pa > -1){
                table.column(6).search("" + _pa).draw();
                //$('#data').DataTable().column(7).search(_pa).draw();
            } else {
                table.column(6).search('').draw();
                //$('#data').DataTable().column(7).search('').draw();
            }
        });
    });
    var tt = new $.fn.dataTable.TableTools(
        table, {
        "sSwfPath": "/static/datatables/TableTools/swf/copy_csv_xls_pdf.swf",
            "sRowSelect": "multi",
            "aButtons" : [

                                {
                                    "sExtends":    "xls",
                                        "sButtonText": '<div class="br3" style="display: inline-block; height: 24px; line-height: 24px; color: #fff; background-color: #ef8587; text-align: center; padding: 0 10px; margin-left: 0px;" id="btnExport">批量导出</div>',
                                }
        ]
        }
    );
    $(tt.fnContainer()).appendTo($('#master'));
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
    $('#datepicker_1').datepicker({onSelect:function(){table.draw();}});
    $('#datepicker_2').datepicker({onSelect:function(){table.draw();}});
    var _today = new Date().format('yyyy-MM-dd');
    var _start = strDate2Timestamp(_today + " 00:00:00");
    _start = new Date(_start - 86400 * 1000 * 90).format('yyyy-MM-dd');
    $('#datepicker_1').datepicker({onSelect:function(){table.draw();}});
    $('#datepicker_2').datepicker({onSelect:function(){table.draw();}});
    $('#datepicker_1').val(_start);
    $('#datepicker_2').val(_today);
    $('#markdown').click(function(){
        var _ids = [];
        $('.reimclick').each(function(){
            var _id = $(this).data('id');
            _ids.push(_id);
        });
        try{
        var url = _BASE + 'bills/marksuccess';
        $.ajax(url, {
            'method' : 'POST',
                //'dataType': 'json',
                'type': "post",
                'data' : {'data' : _ids},
                'success' : function(data){
                    location.replace(location.href);
                },
                    'error' : function(){
                        alert("提醒失败");
                    }
        });
        }catch(e){ console.log(e); }
    });
});
</script>
