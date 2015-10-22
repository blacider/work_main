<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />
<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<!-- <link rel="stylesheet" href="/static/third-party/jqui/jquery-ui.min.css" id="main-ace-style" /> -->

<!-- page specific plugin styles -->
<link rel="stylesheet" href="/static/ace/css/colorbox.css" />
<!--<script src="/static/ace/js/jquery1x.min.js"></script> -->
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/dropzone.min.js"></script>


<script src="/static/ace/js/date-time/moment.js"></script>
<!--
<script src="/static/ace/js/date-time/locale/zh-cn.js"></script>
-->

<script src="/static/ace/js/jquery.colorbox-min.js"></script>
<!--
<script src="/static/third-party/jfu/js/vendor/jquery.ui.widget.js"></script>
<script src="/static/third-party/jfu/js/jquery.iframe-transport.js"></script>
-->
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script src="/static/third-party/jfu/js/jquery.uploadfile.min.js"></script>


<div class="page-content">
    <div class="page-content-area">
        <form role="form" action='<?php echo base_url("company/create_approve/".$pid);  ?>' method="post" class="form-horizontal"  enctype="multipart/form-data" id="mainform">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">规则名</label>
                                 <div class="col-xs-2 col-sm-2">
                                    <input type="text" style="height: 30px;margin-top: 2px" value='<?php echo $rule['name'] ?>' class="form-controller" id="rname" name="rule_name" placeholder="规则名称">
                                    <input type="hidden" name="rid">
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">可审批金额限制</label>
                                <?php if ($rule['amount'] == -1) { ?>
                                <div class="col-xs-1 col-sm-1">
                                   <input type="text" disabled="disable" style="height: 30px;width:160%;margin-top: 2px" class="form-controller col-xs-12" id="total" name="total_amount" placeholder="总金额">
                                </div>

                                <div class="col-sm-2 col-sm-2">
                                    <div class="checkbox" style="margin-left:35px;">
                                        <label>
                                         <input type="checkbox" checked='true' id="frequency_unlimit" name="frequency_unlimit" >
                                            无限制
                                         </label>
                                    </div>
                                </div>
                                <?php } else {?>
                                <div class="col-xs-1 col-sm-1">
                                   <input type="text" value="<?php echo $rule['amount'] ?>" style="height: 30px;width:160%;margin-top: 2px" class="form-controller col-xs-12" id="total" name="total_amount" placeholder="总金额">
                                </div>

                                <div class="col-sm-2 col-sm-2">
                                    <div class="checkbox" style="margin-left:35px;">
                                        <label>
                                         <input type="checkbox" id="frequency_unlimit" name="frequency_unlimit" >
                                            无限制
                                         </label>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        
                            <label style="margin-left: -19px; position:relative;left:12px" class="col-sm-2 control-label no-padding-right">可审批类别</label>
                            <div id="category-content" class="col-sm-offset-2 col-xs-offset-2" style="position:relative;left:7px;">
                                <div class="form-group">
                                <?php if ($rule['allow_all_cates'] == 1) {?>
                                    <div class="radio col-xs-3 col-sm-3">
                                        <label>
                                         <input type="radio" checked class="fourParts" id="frequency_unlimit" name="all_able" value="1">
                                            全部允许
                                         </label>
                                    </div>
                                <?php } else { ?>
                                    <div class="radio col-xs-3 col-sm-3">
                                        <label>
                                         <input type="radio" class="fourParts" id="frequency_unlimit" name="all_able" value="1">
                                            全部允许
                                         </label>
                                    </div>
                                <?php } ?>
                                <?php if ($rule['allow_all_cates'] == -1) {?>
                                    <div class="radio col-xs-3 col-sm-3" style="margin-left:-35px;">
                                        <label>
                                         <input type="radio" checked class="fourParts" id="frequency_unlimit" name="all_able" value='-1'>
                                            全部禁止
                                         </label>
                                    </div>
                                <?php } else { ?>
                                    <div class="radio col-xs-3 col-sm-3" style="margin-left:-35px;">
                                        <label>
                                         <input type="radio" class="fourParts" id="frequency_unlimit" name="all_able" value='-1'>
                                            全部禁止
                                         </label>
                                    </div>
                                <?php } ?>

                                
                                </div>
                                <div class="form-group">
                                    <?php if ($rule['allow_all_cates'] == 0 && $flag == 1) {?>
                                        <div class="radio col-xs-6 col-sm-6">
                                            <label>
                                             <input type="radio" checked checkedclass="fourParts" id="frequency_unlimit" name="all_able" value="2">
                                                仅部分允许
                                            </label>
                                        </div>
                                    <?php } else { ?>
                                        <div class="radio col-xs-6 col-sm-6">
                                            <label>
                                             <input type="radio" class="fourParts" id="frequency_unlimit" name="all_able" value="2">
                                                仅部分允许
                                            </label>
                                        </div>
                                    <?php } ?>
                                    
                                </div>
                                <div class="form-group CategoryRow">
                                    <div class="col-xs-3 col-sm-3">
                                        <select name="sobs" class="sobs chosen-select-niu" data-placeholder="套帐">
                                        </select>
                                    </div>
                                    <div class="col-xs-3 col-sm-3">
                                        <select name="allow_category" class="sob_category chosen-select-niu" data-placeholder="类目">
                                        </select>
                                    </div>
                                        <div class="checkbox col-xs-2 col-sm-2">
                                            <label>
                                                <input type="checkbox" class="def" id="frequency_unlimit" name="default" >
                                                第一默认审批人
                                            </label>
                                        </div>
                                    
                                    <div class="col-xs-1 col-sm-1">
                                        <div class="addCategoryRow" onclick="addCategoryRow()">+</div>   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="radio col-xs-6 col-sm-6">
                                        <label>
                                        <?php if ($rule['allow_all_cates'] == 0 && $flag == -1) {?>
                                            <input type="radio" checked class="fourParts" id="frequency_unlimit" name="all_able" value='-2'>
                                        <?php } else { ?>
                                            <input type="radio" class="fourParts" id="frequency_unlimit" name="all_able" value='-2'>
                                        <?php } ?>
                                         
                                            仅部分禁止
                                         </label>
                                    </div>
                                </div>
                                <div class="form-group disableCategoryRow">
                                    <div class="col-xs-3 col-sm-3">
                                        <select name="sobs" class="sobs chosen-select-niu" data-placeholder="套帐">
                                        </select>
                                    </div>
                                    <div class="col-xs-3 col-sm-3">
                                        <select name="deny_category" class="sob_category chosen-select-niu" data-placeholder="类目">
                                        </select>
                                    </div>
                                       
                                    <div class="col-xs-1 col-sm-1">
                                        <div class="addDisableCategoryRow" onclick="addDisableCategoryRow()">+</div>   
                                    </div>
                                </div>
                            </div>
                        
                        <script type="text/javascript">
                            //selectCache = <?php echo json_encode($rule)?>;
                            selectCache = <?php echo json_encode($cate_arr)?>;
                            function appendChecked(selectJqDom, data, item) {
                                //第一个 selectJqDom.children()[0].children[0]
                                //$(selectJqDom.children()[0].children[0]).parent().children().remove('div'); 
                                $(selectJqDom.children()[0].children[0]).find("option[value='"+data['sob_id']+"']").attr("selected",true);
                                $(selectJqDom.children()[0].children[0]).trigger("chosen:updated");
                                //$(selectJqDom.children()[0].children[0]).change();
                                //第二个
                                $(selectJqDom.children()[0].children[0]).change();
                                $(selectJqDom.children()[1].children[0]).find("option[value='"+data['category_id']+"']").attr("selected",true);
                                $(selectJqDom.children()[1].children[0]).trigger("chosen:updated");
                                //$(selectJqDom.children()[1].children[0]).find("option[value="+ data['sob_name']+"]").attr("selected",true);
                                //checkbox
                                //selectJqDom.find("option[text="+ data+"]").attr("selected",true);
                                if (data['act'] == 1) {
                                    selectJqDom.find("input[type='checkbox']")[0].checked = true;
                                }
                            }
                            function initSelectCache() {
                                var pointer = 0, disablePointer = 0;
                                for (item in selectCache) {
                                    if (item != undefined) {
                                        if (selectCache[item]['act'] == -1) {
                                            if (disablePointer != 0) addDisableCategoryRow();
                                            appendChecked($($('.disableCategoryRow')[disablePointer]), selectCache[item]);
                                            disablePointer += 1;
                                        } else {
                                            if (pointer != 0) addCategoryRow();
                                            appendChecked($($('.CategoryRow')[pointer]), selectCache[item]);
                                            pointer += 1;
                                        }
                                    }
                                }
                                var value;
                                for (var item in $("input[type='radio']")) {
                                    if (item != undefined && $("input[type='radio']")[item].checked) {
                                        value = $("input[type='radio']")[item].value;
                                    }
                                }
                                changeAble(value);
                            }
                            function updateSelectSob(data) {
                                $(".sobs").empty();
                                $(".sobs").append(data);
                                $(".sobs").trigger("change");
                                $(".sobs").trigger("chosen:updated");
                            }
                            function removeCategoryRow(div) {
                                $(div).parent().parent().remove();
                            }
                            function addCategoryRow() {
                                var addDom = $('.CategoryRow .addCategoryRow');
                                var category = "<div class='form-group CategoryRow'><div class='col-xs-3 col-sm-3'><select name='sobs' class='sobs chosen-select-niu' data-placeholder='套帐''></select></div><div class='col-xs-3 col-sm-3'><select name='allow_category' class='sob_category chosen-select-niu' data-placeholder='类目'></select></div><div class='checkbox col-xs-2 col-sm-2'><label><input type='checkbox' class='def' id='frequency_unlimit' name='default' >第一默认审批人</label></div><div class='col-xs-1 col-sm-1'><div class='addCategoryRow' onclick='addCategoryRow()''>+</div>   </div></div>"
                                addDom.removeClass('addCategoryRow');
                                addDom.attr('onclick', 'removeCategoryRow(this)');
                                addDom.addClass('removeCategoryRow');
                                addDom.text('-');
                                addDom.parent().parent().after(category);
                                $(".chosen-select-niu").chosen({width:"100%"});
                                $($(".CategoryRow .sobs")[$(".CategoryRow .sobs").length-1]).append(selectDataSobs);
                                $(".CategoryRow .sobs").trigger("chosen:updated");
                                $('.CategoryRow .sobs').change(function(){
                                    var s_id = $(this).val();
                                    if(selectDataCategory[s_id] != undefined){
                                            var _h = '';
                                        for(var i = 0 ; i < selectDataCategory[s_id].length; i++) {
                                             _h += "<option value='" +  selectDataCategory[s_id][i].category_id + "'>"+  selectDataCategory[s_id][i].category_name + " </option>";
                                        }
                                    }
                                    var selectDom = this.parentNode.nextElementSibling.children[0]
                                    $(selectDom).empty().append(_h).trigger("chosen:updated");
                                });
                                $($(".CategoryRow .sobs")[$(".CategoryRow .sobs").length-1]).trigger('change');
                            }
                            $(document).ready(function($) {
                                $(".chosen-select-niu").chosen({width:"100%"});
                            });
                            function addDisableCategoryRow() {
                                var addDom = $('.disableCategoryRow .addDisableCategoryRow');
                                var category = "<div class='form-group disableCategoryRow'><div class='col-xs-3 col-sm-3'><select name='sobs' class='sobs chosen-select-niu' data-placeholder='套帐''></select></div><div class='col-xs-3 col-sm-3'><select name='deny_category' class='sob_category chosen-select-niu' data-placeholder='类目'></select></div><div class='col-xs-1 col-sm-1'><div class='addDisableCategoryRow' onclick='addDisableCategoryRow()''>+</div>   </div></div>"
                                addDom.removeClass('addDisableCategoryRow');
                                addDom.attr('onclick', 'removeCategoryRow(this)');
                                addDom.addClass('removeCategoryRow');
                                addDom.text('-');
                                addDom.parent().parent().after(category);
                                $(".chosen-select-niu").chosen({width:"100%"});
                                $($(".disableCategoryRow .sobs")[$(".disableCategoryRow .sobs").length-1]).append(selectDataSobs);
                                $(".disableCategoryRow .sobs").trigger("chosen:updated");
                                $('.disableCategoryRow .sobs').change(function(){
                                    var s_id = $(this).val();
                                    if(selectDataCategory[s_id] != undefined){
                                        var _h = '';
                                        for(var i = 0 ; i < selectDataCategory[s_id].length; i++) {
                                             _h += "<option value='" +  selectDataCategory[s_id][i].category_id + "'>"+  selectDataCategory[s_id][i].category_name + " </option>";
                                        }
                                    }
                                    var selectDom = this.parentNode.nextElementSibling.children[0]
                                    $(selectDom).empty().append(_h).trigger("chosen:updated");
                                });
                                $($(".disableCategoryRow .sobs")[$(".disableCategoryRow .sobs").length-1]).trigger('change');
                            }
                        </script>

                          <!--  <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">最大金额</label>
                                <div class="col-xs-2 col-sm-2">
                                   <input type="text" class="form-controller col-xs-12" id="amount" name="rule_amount" placeholder="金额">
                                </div>

                                <div class="col-sm-2 col-sm-2">
                                    <div class="checkbox" >
                                        <label>
                                         <input type="checkbox" id="amount_unlimit" value="0">
                                            无限制
                                         </label>
                                        </div>
                                </div>

                                <div class="col-sm-2 col-sm-2">
                                   
                                        <select class="form-control" id="amount_time">
                                          <option >一年</option>
                                          <option>一月</option>
                                          <option>一日</option>
                                        </select>
                                </div>

                            </div> -->


                            

                        

                        <!--   <div class="form-group">
                                    <label class="col-sm-1 control-label no-padding-right">消费时间</label>
                                    <div class="col-xs-3 col-sm-3">
                                        <div class="input-group">
                                            <input id="date-timepicker1" name="sdt" type="text" class="form-control" />
                                            <span class="input-group-addon">
                                            <i class="fa fa-clock-o bigger-110"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-xs-3 col-sm-3">
                                        <div class="input-group">
                                            <input id="date-timepicker2" name="edt" type="text" class="form-control" />
                                            <span class="input-group-addon">
                                            <i class="fa fa-clock-o bigger-110"></i>
                                            </span>
                                        </div>
                                    </div>

                               
                            </div> -->
                            <hr>
                            <div class="form-group" style="margin-top:30px;">
                                <label class="col-sm-2 control-label no-padding-right">适用范围</label>
                                <!--<div class="col-xs-3 col-sm-3">
                                    <select class="chosen-select tag-input-style" id="group" name="gids[]" multiple="multiple" data-placeholder="请选择部门" placeholder="请选择部门">
                                    <?php 
                                    foreach($group as $g){
                                    ?>
                                        <option value="<?php echo $g['id']; ?>"><?php echo $g['name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div> -->

                                <div class="col-xs-5 col-sm-5">
                                    <select class="chosen-select tag-input-style" id="member" name="uids[]" multiple="multiple" data-placeholder="请选择员工">
                                    <?php 
                                    $mem = array();
                                    foreach ($rule['members'] as $key => $value) {
                                        # code…
                                        array_push($mem,$value['uid']);
                                    }
                                    foreach($member as $m){
                                        if(in_array($m['id'], $mem)){
                                    ?>
                                        <option selected value="<?php echo $m['id']; ?>"><?php echo $m['nickname'] . "[" . $m['email'] . "]"; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname'] . "[" . $m['email'] . "]"; ?></option>
                                    <?php
                                    }
                                    }
                                    ?>
         
                                    </select>
                                </div>

                               <div class="col-xm-2 col-sm-2">
                                    <div class="checkbox" >
                                        <label>
                                        <?php if ($rule['all_member'] == 1) {?>
                                         <input type="checkbox" id="all_members" checked="true"  name="all_members">
                                         <?php } else {?>
                                         <input type="checkbox" id="all_members"  name="all_members">
                                         <?php }?>
                                            全体员工
                                         </label>

                                    </div>
                                </div>
                            </div>


                           <!--

                            <input type="hidden" id="renew" name="renew" value="0" />
                            <input type="reset" style="display:none;" id="reset">
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>
                                

                                    <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                                </div>
                            </div>

                            -->
                             <input type='hidden' id="allow_category_ids" name="allow_category_ids">
                             <input type='hidden' id="deny_category_ids" name="deny_category_ids">
                             <input type='hidden' id="four" name="allow_all_category">
                             <input type='hidden' id="defaults" name="defaults">


                            <div class="form-group">
                                <div class="col-xm-2 col-sm-2 col-sm-offset-2 col-xm-offset-2">
                                    <input type="button" id='renew' value="保存">
                                </div>
                                <div class="col-xm-2 col-sm-2">
                                    <div><a href="" style="cursor:pointer;color:grey;position: relative;top:16px;">取消</a></div>
                                </div>
                                
                            </div>
                        </div>
            </div>
        </form>
    </div>
</div>

<style type="text/css">
    .form-group {
        margin-bottom: 30px;
    }
    .radio {
        position: relative;
        left: -2px;
    }
    .addCategoryRow, .addDisableCategoryRow, .removeCategoryRow{
        margin:2px auto auto 25px;
        font-size:20px;
        cursor:pointer;
    }
    input[type="button"]:hover {
        background-color: #ff7075;
    }
    input[type="button"] {
        width:100%;
        background-color: #FE575C;
        color:white;
        border-radius: 25px;
        font-size: 23px;
        width: 100%;
        max-width: 200px;
        height: 50px;
        border:0;
    }
</style>
<script language="javascript">
    //updateSelect()
    selectDataSobs = '';
    selectDataCategory = {};
function get_sobs(){
        $.ajax({
            url : __BASE + "category/get_sob_category",
            dataType : 'json',
            method : 'GET',
            success : function(data){
                for(var item in data){
                    var _h = "<option value='" +  item + "'>"+  data[item].sob_name + " </option>";
                    selectDataCategory[item] = data[item]['category'];
                    selectDataSobs += _h;
                }
                selectPostData = data;
                updateSelectSob(selectDataSobs);
                initSelectCache();
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {
                }
        });


        $('.sobs').change(function(){
            var s_id = $(this).val();
            var _h = '';
            if(selectDataCategory[s_id] != undefined)
            {
                for(var i = 0 ; i < selectDataCategory[s_id].length; i++)
                {
                    _h += "<option value='" +  selectDataCategory[s_id][i].category_id + "'>"+  selectDataCategory[s_id][i].category_name + " </option>";
                    
                }
            }
            var selectDom = this.parentNode.nextElementSibling.children[0]
            $(selectDom).empty().append(_h).trigger("chosen:updated");
        });
}

$(document).ready(function(){
   

        /*$.ajax({
        url:__BASE + "category/get_sob_category/"+s_id,
        dataType:'json',
        method:'GET',
        success:function(data){
            for(var key=0; key<data.length;key++)
            {
               for(var i in data[key])
               {
                    var _h = "<option value='" +  i + "'>"+  data[key][i] + " </option>";
                    $('#sob_category').append(_h);
                }
                                 
            }
        },
        error:function(XMLHttpRequest, textStatus, errorThrown) {
        });*/
           
    


   
  
    $('#date-timepicker1').datetimepicker({
        language: 'zh-cn',
            useCurrent: true,
            format: 'YYYY-MM-DD HH:mm',
            linkField: "dt",
            linkFormat: "YYYY-MM-DD HH:mm",
            sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });


    $('#date-timepicker2').datetimepicker({
        language: 'zh-cn',
            useCurrent: true,
            format: 'YYYY-MM-DD HH:mm',
            linkField: "dt",
            linkFormat: "YYYY-MM-DD HH:mm",
            sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });

    
    get_sobs();
    $('.chosen-select').chosen({allow_single_deselect:true}); 
    $(window)
        .off('resize.chosen')
        .on('resize.chosen', function() {
            $('.chosen-select').each(function() {
                var $this = $(this);
                $this.next().css({'width': $this.parent().width()});
            })
        }).trigger('resize.chosen');
    $('#renew').click(function(){
        
        var rname = $('#rname').val();
        var sobs = $('.sobs').val();
    var category = $('.category').val();

    var amount = $('#amount').val();
    var amount_unlimit = $('#amount_unlimit').val();
    var amount_time = $('#amount_time').val();

    var frequency = $('#frequency').val();
    //var frequency_unlimit = $('#frequency_unlimit').val();
    var frequency_time = $('#frequency_time').val();

    if($('#frequency_unlimit').is(':checked'))
    {
        $('#frequency_unlimit').val(1);
    }
    else
    {
        $('#frequency_unlimit').val(0);

    }

      if($('#all_members').is(':checked'))
    {
        $('#all_members').val(1);
    }
    else
    {
        $('#all_members').val(0);

    }

    /*$('.fourParts').each(function(){
        if($(this).is(':checked'))
        {
            $(this).val(1);
        }
        else
        {
            $(this).val(0);
        }
    }); */

        $('.def').each(function(){
        if($(this).is(':checked'))
        {
            $(this).val(1);
        }
        else
        {
            $(this).val(0);
        }
    });
/*  if(name=='')
    {   
        show_notify('请输入用户名');
        $('#name').focus();
        return false;
    }

    if(phone==''&& email=='')
    {   
        show_notify('请输入手机号码或email');
        $('#phone').focus();
        $('#email').focus();
        return false;
    }
    
        show_notify("hello");*/
       // $('#renew').val($(this).data('renew'));
        var allow_categories = [];
         var deny_categories = [];

        var amounts = [];
        var fourParts = [];
        var defaults = [] ;
        var els =document.getElementsByName("allow_category");
        for (var i = 0, j = els.length; i < j; i++){
        allow_categories.push(els[i].value);
        }

        var els =document.getElementsByName("deny_category");
        for (var i = 0, j = els.length; i < j; i++){
        deny_categories.push(els[i].value);
        }

        var els =document.getElementsByName("all_able");
        for (var i = 0, j = els.length; i < j; i++){
        fourParts.push(els[i].value);
        }

        var els =document.getElementsByName("default");
        for (var i = 0, j = els.length; i < j; i++){
        defaults.push(els[i].value);
        }
        var els =document.getElementsByName("category_amount");
        for (var i = 0, j = els.length; i < j; i++){
        amounts.push(els[i].value);
        }

         

        $('#allow_category_ids').val(JSON.stringify(allow_categories));

        $('#deny_category_ids').val(JSON.stringify(deny_categories));

        $('#defaults').val(JSON.stringify(defaults));

        $('#four').val(JSON.stringify(fourParts));

        $('#category_amounts').val(JSON.stringify(amounts));



        if($('#rname').val() == '')
        {
            $('#rname').focus();
            show_notify("请输入规则名");
            return false;
        }

        if(($('#total').val() == '')&&($('#frequency_unlimit').val()==0))
        {
            $('#total').focus();
            show_notify("请输入总金额");
            return false;
        }

        if($('input[name="all_able"]:checked').val() == undefined)
        {
            show_notify("请选择类目类型");
            return false;
        }

        if(($('#member').val() == null)&&($('#all_members').val()==0))
        {
            $('#member').focus();
            show_notify("请输入适用人员");
            return false;
        }

        $('#mainform').submit();
    });
    $('.cancel').click(function(){
        $('#reset').click();
    });

    $('#frequency_unlimit').click(function(){
        if($(this).is(':checked'))
        {
            $('#total').attr("disabled",true);
        }
        else
        {
            $('#total').attr("disabled",false);
        }
    });

      $('#frequency_unlimit').click(function(){
        if($(this).is(':checked'))
        {
            $('#frequency').attr("disabled",true);
        }
        else
        {
            $('#frequency').attr("disabled",false);
        }
    });
      $('input[type="radio"]').click(function() {
        changeAble(this.value);
      });
    $('#all_members').click(function(){
        if($(this).is(':checked'))
        {
            $('#member').prop('disabled',true).trigger("chosen:updated");
            $('#group').prop('disabled',true).trigger("chosen:updated");
        }
        else
        {
            $('#member').prop('disabled',false).trigger("chosen:updated");
            $('#group').prop('disabled',false).trigger("chosen:updated");
        }
    });

    /*var update_users = function () {
    if ($("#all_members").is(":checked")) {
        $('#member').prop('disabled', false);
    }
    else {
        $('#member').prop('disabled', 'disabled');
    }
  };
  $(update_users);
  $("#all_members").change(update_users);*/

});
function changeAble(value) {
        if (value == 1 || value == -1) {
            $('.chosen-select-niu').prop('disabled',true).trigger("chosen:updated");
            $('.def').attr('disabled', 'true');
            $('.addDisableCategoryRow').attr('onclick','');
            $('.addCategoryRow').attr('onclick','')
            $('.removeCategoryRow').attr('onclick','');
        } else if (value == -2) {
            $('.disableCategoryRow .chosen-select-niu').prop('disabled',false).trigger("chosen:updated");
            $('.CategoryRow .chosen-select-niu').prop('disabled',true).trigger("chosen:updated");
            $('.def').attr('disabled', 'false');
            $('.addDisableCategoryRow').attr('onclick','addDisableCategoryRow()');
            $('.addCategoryRow').attr('onclick','')
            $('.CategoryRow .removeCategoryRow').attr('onclick','');
            $('.disableCategoryRow .removeCategoryRow').attr('onclick','removeCategoryRow(this)');
        } else {
            $('.def').removeAttr('disabled');
            $('.disableCategoryRow .chosen-select-niu').prop('disabled',true).trigger("chosen:updated");
            $('.CategoryRow .chosen-select-niu').prop('disabled',false).trigger("chosen:updated");
            $('.addDisableCategoryRow').attr('onclick','');
            $('.addCategoryRow').attr('onclick','addCategoryRow()')
            $('.CategoryRow .removeCategoryRow').attr('onclick','removeCategoryRow(this)');
            $('.disableCategoryRow .removeCategoryRow').attr('onclick','');
        }
      }
</script>

