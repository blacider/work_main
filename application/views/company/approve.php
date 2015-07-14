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
                                    <input type="text" style="height: 30px;margin-top: 2px" class="form-controller" id="rname" name="rule_name" placeholder="规则名称">
                                    <input type="hidden" name="rid">
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">总金额</label>
                                <div class="col-xs-1 col-sm-1">
                                   <input type="text" style="height: 30px;width:160%;margin-top: 2px" class="form-controller col-xs-12" id="total" name="total_amount" placeholder="总金额">
                                </div>

                                <div class="col-sm-2 col-sm-2">
                                    <div class="checkbox" style="margin-left:35px;">
                                        <label>
                                         <input type="checkbox" id="frequency_unlimit" name="frequency_unlimit" >
                                            无限制
                                         </label>
                                        </div>
                             </div>

                            </div>
                        
                            <label style="margin-left: -7px;" class="col-sm-2 control-label no-padding-right">审查类目</label>
                
                        <div class="form-group CategoryRow">
                                <div class="col-xs-1 col-sm-1" style="margin-top:2px">
                                    <select name="sobs" class="sobs chosen-select-niu" data-placeholder="套帐">
                                    </select>
                                </div>
                                <div class="col-xs-1 col-sm-1" style="margin:2px 20px auto 20px;">
                                    <select name="category" class="sob_category chosen-select-niu" data-placeholder="类目">
                                    </select>
                                </div>
                                <div class="col-xs-1 col-sm-1">
                                    <input type="text" style="width:160%;width:160%;height:30px;margin-top: 2px" class="form-controller" name="category_amount" value="" placeholder="最大金额">
                                </div>
                                <div class="col-xs-1 col-sm-1">
                                    <div class="addCategoryRow" onclick="addCategoryRow()">+</div>   
                                </div>
                        </div>
                        <script type="text/javascript">
                            function updateSelectSob(data) {
                                $(".sobs").empty();
                                $(".sobs").append(data);
                                $(".sobs").trigger("chosen:updated");
                            }
                            function removeCategoryRow(div) {
                                $(div).parent().parent().remove();
                                initCategoryRow();
                            }
                            function addCategoryRow(div) {
                                var addDom = $('.addCategoryRow');
                                var category = "<div class='form-group CategoryRow'><div class='col-xs-1 col-sm-1 notFirstCategoryRow' style='margin-top:2px;'><select name='sobs' class='sobs chosen-select-niu' data-placeholder='套帐''></select></div><div class='col-xs-1 col-sm-1' style='margin:2px 20px auto 20px;''><select name='category' class='sob_category chosen-select-niu' data-placeholder='类目'></select></div><div class='col-xs-1 col-sm-1'><input type='text' style='width:160%;width:160%;height:30px;margin-top: 2px' class='form-controller' name='category_amount' value='' placeholder='最大金额'></div><div class='col-xs-1 col-sm-1'><div class='addCategoryRow' onclick='addCategoryRow()''>+</div>   </div></div>"
                                addDom.removeClass('addCategoryRow');
                                addDom.attr('onclick', 'removeCategoryRow(this)');
                                addDom.addClass('removeCategoryRow');
                                addDom.text('-');
                                addDom.parent().parent().after(category);
                                $(".chosen-select-niu").chosen({width:"160%"});
                                $($(".sobs")[$(".sobs").length-1]).append(selectDataSobs);
                                $(".sobs").trigger("chosen:updated");
                                $('.sobs').change(function(){
                                    var s_id = $(this).val();
                                    if(selectDataCategory[s_id] != undefined){
                                        for(var i = 0 ; i < selectDataCategory[s_id].length; i++) {
                                            var _h = "<option value='" +  selectDataCategory[s_id][i].category_id + "'>"+  selectDataCategory[s_id][i].category_name + " </option>";
                                        }
                                    }
                                    var selectDom = this.parentNode.nextElementSibling.children[0]
                                    $(selectDom).empty().append(_h).trigger("chosen:updated");
                                });
                            }
                            $(document).ready(function($) {
                                $(".chosen-select-niu").chosen({width:"160%"});
                                initCategoryRow();
                            });
                            function initCategoryRow() {
                                var rows = $('.CategoryRow');
                                for (var i = 0; i < rows.length; i++) {
                                    if (i == 0)
                                        rows[i].firstChild.className = 'col-xs-1 col-sm-1 firstCategoryRow';
                                    else
                                        rows[i].firstChild.className = 'col-xs-1 col-sm-1 notFirstCategoryRow';
                                }
                            }
                        </script>

                                   
                            </div>
                                     <input type='hidden' id="category_ids" name="category_ids">
                                     <input type='hidden' id="category_amounts" name="category_amounts">
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


                                <!-- <div class="col-sm-2 col-sm-2">
                                   
                                        <select class="form-control" id="frequency_time" name="frequency_time">
                                        <?php
                                            $period = array(1=>"一月",2=>"一年",3=>"一日");
                                            foreach ($period as $key => $value) {
                                                if($key == $rule['freq_period'])
                                                {
                                        ?>
                                            <option selected value="<?php echo $key ?>"><?php echo $value?></option>
                                            <?php } else {?>
                                          <option value="<?php echo $key?>"><?php echo $value?></option>
                                          <?php
                                            }
                                            }
                                          ?>
                                        </select>
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

                                <div class="col-xs-3 col-sm-3">
                                    <select class="chosen-select tag-input-style" id="member" name="uids[]" multiple="multiple" data-placeholder="请选择员工">
                                    <?php 
                                    $mem = array();
                                    foreach ($rule['members'] as $key => $value) {
                                        # code...
                                        array_push($mem,$value['uid']);
                                    }
                                    foreach($member as $m){
                                        if(in_array($m['id'], $mem)){
                                    ?>
                                        <option selected value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?></option>
                                    <?php
                                    }
                                    }
                                    ?>
         
                                    </select>
                                </div>

                               <div class="col-xm-2 col-sm-2">
                                    <div class="checkbox" >
                                        <label>
                                         <input type="checkbox" id="all_members"  name="all_members">
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
                            <div class="form-group">
                                <div class="col-xm-2 col-sm-2">
                                    <input type="submit" value="保存">
                                </div>
                                <div class="col-xm-2 col-sm-2">
                                    <div><a href="" style="cursor:pointer;color:grey;position: relative;left:150px;top:64px;">取消</a></div>
                                </div>
                                
                            </div>
                        </div>
            </div>
        </form>
    </div>
</div>
<!-- <p><?php echo json_encode($rule)?></p> 
 <?php foreach ($rule['members'] as $key => $value) {
                                        # code...
                                echo $value['id'];     //   array_push($mem,$rule['members']['id']);
                                    }?>
<p><?php echo json_encode($rule['members'])?></p>
<p><?php echo json_encode($rule);?></p>
<p><?php echo $c_id.$c_name.$s_id.$s_name?></p>-->
<style type="text/css">
    .notFirstCategoryRow {
        margin-left: 167px !important;
    }
    .firstCategoryRow {
        margin-left: 0px;
    }
    .form-group {
        margin-bottom: 30px;
    }
    .addCategoryRow, .removeCategoryRow{
        margin:2px auto auto 25px;
        font-size:20px;
        cursor:pointer;
    }
    input[type="submit"]:hover {
        background-color: #ff7075;
    }
    input[type="submit"] {
        width:100%;
        background-color: #FE575C;
        color:white;
        border-radius: 25px;
        font-size: 23px;
        width: 160px;
        height: 50px;
        border:0;
        margin: 50px auto auto 130px;
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
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.status);
                        console.log(XMLHttpRequest.readyState);
                        console.log(textStatus);}
        });


        $('.sobs').change(function(){
            var s_id = $(this).val();
            var _h = '';
            if(selectDataCategory[s_id] != undefined)
            {
                for(var i = 0 ; i < selectDataCategory[s_id].length; i++)
                {
                    _h += "<option value='" +  selectDataCategory[s_id][i].category_id + "'>"+  selectDataCategory[s_id][i].category_name + " </option>";
                    
                   // console.log(_h);
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
            console.log(data);
            for(var key=0; key<data.length;key++)
            {
                console.log(data[key]);
               for(var i in data[key])
               {
                   console.log("##"+i+data[key][i]);
                    var _h = "<option value='" +  i + "'>"+  data[key][i] + " </option>";
                    $('#sob_category').append(_h);
                }
                                 
            }
        },
        error:function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.status);
                        console.log(XMLHttpRequest.readyState);
                        console.log(textStatus);}
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
    $('.renew').click(function(){
        
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
        console.log($('#frequency_unlimit').val());
    }
    else
    {
        $('#frequency_unlimit').val(0);
         console.log($('#frequency_unlimit').val());

    }

      if($('#all_members').is(':checked'))
    {
        $('#all_members').val(1);
        console.log($('#all_members').val());
    }
    else
    {
        $('#all_members').val(0);
         console.log($('#all_members').val());

    }
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
        var categories = [];
        var amounts = [];
        var els =document.getElementsByName("category");
        for (var i = 0, j = els.length; i < j; i++){
        console.log(els[i].value);
        categories.push(els[i].value);
        }

        var els =document.getElementsByName("category_amount");
        for (var i = 0, j = els.length; i < j; i++){
        console.log(els[i].value);
        amounts.push(els[i].value);
        }
        $('#category_ids').val(JSON.stringify(categories));
        $('#category_amounts').val(JSON.stringify(amounts));
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

    $('#all_members').click(function(){
        if($(this).is(':checked'))
        {
           // console.log("helleo");
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
        console.log("hello");
    }
    else {
        console.log("world");
        $('#member').prop('disabled', 'disabled');
    }
  };
  $(update_users);
  $("#all_members").change(update_users);*/

});
</script>

