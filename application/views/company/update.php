<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />
<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<!-- <link rel="stylesheet" href="/static/third-party/jqui/jquery-ui.min.css" id="main-ace-style" /> -->

<!-- page specific plugin styles -->
<link rel="stylesheet" href="/static/ace/css/colorbox.css" />
<!--<script src="/static/ace/js/jquery1x.min.js"></script> -->
<script src="/static/ace/js/chosen.jquery.min.js"></script>


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
        <form role="form" action="<?php echo base_url('company/update_rule');  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" id="mainform">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">规则名称</label>
                                 <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" id="rname" name="rule_name" placeholder="规则名称" value="<?php echo $rule['name']?>">
                                    <input type="hidden" name="rid" value="<?php echo $rule['id']?>">
                                </div>
                            </div>
                            
                            <div class='cates'><hr>
                            <label style="margin-left: -8px;position: absolute;" class="col-sm-2 control-label no-padding-right">类目</label>
                            <div class="form-group CategoryRow">
                                    <div class="col-xs-2 col-sm-2 col-sm-offset-2 col-xs-offset-2" style="margin-top:2px">
                                        <select name="sobs" id="sobs" class="sobs chosen-select-niu" data-placeholder="套帐">
                                        </select>
                                    </div>
                                    <div class="col-xs-2 col-sm-2" style="margin-top:2px;">
                                        <select name="category" id="sob_category" class="sob_category chosen-select-niu" data-placeholder="类目">
                                        </select>
                                    </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">最大频次</label>
                                <div class="col-xs-2 col-sm-2">
                                   <input type="text" class="form-controller col-xs-12" id="freq_count" name="freq_count" placeholder="频次">
                                </div>

                                <div class="col-sm-2 col-sm-2">
                                    <div class="checkbox" >
                                        <label>
                                         <input type="checkbox" class='freq_unlimit' id="freq_unlimit" name="freq_unlimit" >
                                            无限制
                                         </label>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">周期</label>
                                <div class="col-xs-2 col-sm-2">
                                   <input type="text" class="form-controller col-xs-12" id="freq_period" name="freq_period" placeholder="周期">
                                </div>

                                <div class="col-sm-2 col-sm-2">
                                    <div class="checkbox" >
                                        <label>
                                         <input type="checkbox" class="freq_period_unlimit" id="freq_period_unlimit" name="freq_period_unlimit" >
                                            无限制
                                         </label>
                                    </div>
                                </div>
                                <div class="col-xs-1 col-sm-1">
                                        <div class="addCategoryRow" onclick="addCategoryRow()">+</div>   
                                </div>

                            </div>
                        </div>
                        <hr>
                        <style type="text/css">
                                .addCategoryRow, .removeCategoryRow {
                                    font-size: 20px;
                                    font-weight: bold;
                                    cursor:pointer;
                                }
                            </style>
                            <script type="text/javascript">
                            function removeCategoryRow(div) {
                                $(div).parent().parent().parent().remove();
                            }
                            function addCategoryRow() {
                                var addDom = $('.addCategoryRow');
                                var category = "<div class='cates'><hr><label style='margin-left: -8px;position: absolute;' class='col-sm-2 control-label no-padding-right'>类目</label><div class='form-group CategoryRow'><div class='col-xs-2 col-sm-2 col-sm-offset-2' col-xs-offset-2><select name='sobs' class='sobs chosen-select-niu' data-placeholder='套帐''></select></div><div class='col-xs-2 col-sm-2'><select name='category' class='sob_category chosen-select-niu' data-placeholder='类目'></select></div></div><div class='form-group'><label class='col-sm-2 control-label no-padding-right'>最大频次</label><div class='col-xs-2 col-sm-2'><input type='text' class='form-controller col-xs-12' id='freq_count' name='freq_count' placeholder='频次'></div><div class='col-sm-2 col-sm-2'><div class='checkbox' ><label><input type='checkbox' class='freq_unlimit' id='freq_unlimit' name='freq_unlimit' >无限制</label></div></div></div><div class='form-group'><label class='col-sm-2 control-label no-padding-right'>周期</label><div class='col-xs-2 col-sm-2'><input type='text' class='form-controller col-xs-12' id='freq_period' name='freq_period' placeholder='周期'></div><div class='col-sm-2 col-sm-2'><div class='checkbox' ><label><input type='checkbox' id='freq_period_unlimit' class='freq_period_unlimit' name='freq_period_unlimit' >无限制</label></div></div><div class='col-xs-1 col-sm-1'><div class='addCategoryRow' onclick='addCategoryRow()''>+</div></div></div></div>"
                                addDom.removeClass('addCategoryRow');
                                addDom.attr('onclick', 'removeCategoryRow(this)');
                                addDom.addClass('removeCategoryRow');
                                addDom.text('-');
                                addDom.parent().parent().parent().after(category);
                                $(".chosen-select-niu").chosen({width:"100%"});
                                $($(".CategoryRow .sobs")[$(".CategoryRow .sobs").length-1]).append(selectDataSobs);
                                $(".CategoryRow .sobs").trigger("chosen:updated");
                                $('.CategoryRow .sobs').change(function(){
                                    var s_id = $(this).val();
                                  //  console.log(s_id);
                                   // console.log(selectDataCategory);
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
                                bind_event();
                            }
                                $(document).ready(function($) {
                                $(".chosen-select-niu").chosen({width:"100%"});
                            });
                            </script>


                         
                            

                              <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">适用范围</label>
                                <div class="col-xs-3 col-sm-3">
                                    <select class="chosen-select tag-input-style" id="ranks" name="ranks[]" multiple="multiple" data-placeholder="请选择职级" placeholder="请选择职级">
                                    <?php 
                                    foreach($ranks as $g){
                                    ?>
                                        <option value="<?php echo $g['id']; ?>"><?php echo $g['name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="col-xs-3 col-sm-3">
                                    <select class="chosen-select tag-input-style" id="levels" name="levels[]" multiple="multiple" data-placeholder="请选择级别">
                                    <?php 
                                    foreach($levels as $m){
                                    ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                              <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"></label>
                                <div class="col-xs-3 col-sm-3">
                                    <select class="chosen-select tag-input-style" id="group" name="gids[]" multiple="multiple" data-placeholder="请选择部门" placeholder="请选择部门">
                                    <?php 
                                    foreach($group as $g){
                                    ?>
                                        <option value="<?php echo $g['id']; ?>"><?php echo $g['name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="col-xs-3 col-sm-3">
                                    <select class="chosen-select tag-input-style" id="member" name="uids[]" multiple="multiple" data-placeholder="请选择员工">
                                    <?php 
                                    foreach($member as $m){
                                    ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>

                                <div class="col-sm-2 col-sm-2">
                                    <div class="checkbox" >
                                        <label>
                                         <input type="checkbox" id="all_members"  name="all_members">
                                            全体员工
                                         </label>
                                        </div>
                                </div>
                            </div>

                           

                            <input type="hidden" id="renew" name="renew" value="0" />
                            <input type="reset" style="display:none;" id="reset">
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>
                                

                                    <a style="margin-left: 80px;" href="" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                                </div>
                            </div>

                        </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    var all_members = "<?php echo $rule['all_company']?>";
</script>
<script language="javascript">
function bind_event() {
    $('.freq_unlimit').click(function(event) {
        $(this).parent().parent().parent().parent().find('input[type="text"]').attr('disabled',this.checked);
    });
    $('.freq_period_unlimit').click(function(event) {
        $(this).parent().parent().parent().parent().find('input[type="text"]').attr('disabled',this.checked);
    });
}
    var selectCache = <?php echo json_encode($rule['cates'])?>;
                            function appendChecked(selectJqDom, data) {
                                //第一个 selectJqDom.children()[0].children[0]
                                selectJqDom.find('select[name="sobs"]').find("option[value='"+data['sob_id']+"']").attr("selected",true);
                                selectJqDom.find('select[name="sobs"]').trigger("chosen:updated");
                                //第二个
                                selectJqDom.find('select[name="sobs"]').change();
                                selectJqDom.find('select[name="category"]').find("option[value='"+data['category']+"']").attr("selected",true);
                                selectJqDom.find('select[name="category"]').trigger("chosen:updated");
                                if (data['freq_count'] == 0) {
                                    selectJqDom.find('.freq_unlimit').click();
                                }
                                else selectJqDom.find('input[name="freq_count"]').val(data['freq_count']);
                                if (data['freq_period'] == 0) {
                                    selectJqDom.find('.freq_period_unlimit').click();
                                }else selectJqDom.find('input[name="freq_period"]').val(data['freq_period']);
                                //console.log(1);
                            }
                            function initSelectCache() {
                                for (item in selectCache) {
                                    if (item != undefined) {
                                            if (item == 0) appendChecked($($('.cates')[0]), selectCache[item]);
                                            else {
                                                addCategoryRow();
                                                appendChecked($($('.cates')[item]), selectCache[item]);
                                            }
                                        }
                                    }
                                }
   var selectPostData = {};
   var selectDataCategory = {};
   var selectDataSobs = '';
       function updateSelectSob(data) {
                                $("#sobs").empty();
                                $("#sobs").append(data);
                                $("#sobs").trigger('change');
                                $("#sobs").trigger("chosen:updated");
                            }

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
            error:function(XMLHttpRequest, textStatus, errorThrown) {}
        });


        $('#sobs').change(function(){
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
   
bind_event();
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
           

     if(all_members == 1)
    {
        $('#all_members').attr('checked',true);
        $('#member').prop('disabled',true).trigger("chosen:updated");
        $('#group').prop('disabled',true).trigger("chosen:updated");
        $('#ranks').prop('disabled',true).trigger("chosen:updated");
            $('#levels').prop('disabled',true).trigger("chosen:updated");
    }
  
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
        var sobs = $('#sobs').val();
	var category = $('#category').val();

	var amount = $('#amount').val();
	var amount_unlimit = $('#amount_unlimit').val();
	var amount_time = $('#amount_time').val();

	var frequency = $('#frequency').val();
	//var frequency_unlimit = $('#frequency_unlimit').val();
	var frequency_time = $('#frequency_time').val();


    if(rname == '')
    {
        $('#rname').focus();
        show_notify("请输入规则名");
        return false;
    }
    if(($('#frequency').val() == '')&&(!$('#frequency_unlimit').is(':checked')))
    {
        $('#frequency').focus();
        show_notify("请输入频次");
        return false;
    }
    else if(isNaN(Number($('#frequency').val())))
    {
        $('#frequency').focus();
        show_notify("请输入数字");
        return false;

    }

    if(($('#group').val() == null)&&($('#member').val() == null)&&(!$('#all_members').is(':checked')))
    {
        show_notify('请选择适用范围');
        return false;
    }
    

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

     
/*	if(name=='')
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
        $('#mainform').submit();
    });

    $('#amount_unlimit').click(function(){
        if($(this).is(':checked'))
        {
            $('#amount').attr("disabled",true);
        }
        else
        {
            $('#amount').attr("disabled",false);
        }
    });
    $('#all_members').click(function(){
        if($(this).is(':checked'))
        {
           // console.log("helleo");
           $('#ranks').prop('disabled',true).trigger("chosen:updated");
            $('#levels').prop('disabled',true).trigger("chosen:updated");
            $('#member').prop('disabled',true).trigger("chosen:updated");
            $('#group').prop('disabled',true).trigger("chosen:updated");
        } else
        {
            $('#ranks').prop('disabled',false).trigger("chosen:updated");
            $('#levels').prop('disabled',false).trigger("chosen:updated");
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

