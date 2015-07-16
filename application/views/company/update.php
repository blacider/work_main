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

                            <div class="form-group disableCategoryRow">
                                    <label class="col-sm-2 control-label no-padding-right">类目</label>
                                    <div class="col-xs-2 col-sm-2" style="margin-top:2px">
                                        <select name="sobs" id="sobs" class="sobs chosen-select-niu" data-placeholder="套帐">
                                        </select>
                                    </div>
                                    <div class="col-xs-2 col-sm-2" style="margin:2px 20px auto 20px;">
                                        <select name="deny_category" id="sob_category" class="sob_category chosen-select-niu" data-placeholder="类目">
                                        </select>
                                    </div>
                                       
                                </div>
                            <script type="text/javascript">
                                $(document).ready(function($) {
                                $(".chosen-select-niu").chosen({width:"100%"});
                            });
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

                                <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">最大频次/月</label>
                                <div class="col-xs-2 col-sm-2">
                                   <input type="text" class="form-controller col-xs-12" id="frequency" name="rule_frequency" placeholder="频次">
                                </div>

                                <div class="col-sm-2 col-sm-2">
                                    <div class="checkbox" >
                                        <label>
                                         <input type="checkbox" id="frequency_unlimit" name="frequency_unlimit" >
                                            无限制
                                         </label>
                                        </div>
                                </div>

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

                            </div>

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
                              <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">适用范围</label>
                                <div class="col-xs-3 col-sm-3">
                                    <select class="chosen-select tag-input-style" id="group" name="gids[]" multiple="multiple" data-placeholder="请选择部门" placeholder="请选择部门">
                                    <?php 
                                    foreach($group as $g){
                                        if(in_array($g['id'],$rule['groups']))
                                        {
                                    ?>
                                        <option selected value="<?php echo $g['id']; ?>"><?php echo $g['name']; ?></option>
                                    <?php
                                        }   else {
                                    ?>
                                        <option value="<?php echo $g['id']; ?>"><?php echo $g['name']; ?></option>
                                    <?php
                                    } 
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="col-xs-3 col-sm-3">
                                    <select class="chosen-select tag-input-style" id="member" name="uids[]" multiple="multiple" data-placeholder="请选择员工">
                                    <?php 
                                    foreach($member as $m){
                                        if(in_array($m['id'], $rule['members'])){
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
<p><?php echo json_encode($cate_arr)?></p>
<script type="text/javascript">
    var freq = "<?php echo $rule['freq_count']?>";
    var all_members = "<?php echo $rule['all_company']?>";
    var freq_period = "<?php echo $rule['freq_period']?>";
</script>
<script language="javascript">
   var selectPostData = {};
   var selectDataCategory = {};
   var selectDataSobs = '';
       function updateSelectSob(data) {
                                $("#sobs").empty();
                                $("#sobs").append(data);
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
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.status);
                        console.log(XMLHttpRequest.readyState);
                        console.log(textStatus);}
        });


        $('#sobs').change(function(){
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
           
    
    if(freq == -1)
    {
        $('#frequency_unlimit').attr('checked',true);
         $('#frequency').attr("disabled",true);
    }
    else
    {
        $('#frequency').val(freq);
    }

     if(all_members == 1)
    {
        $('#all_members').attr('checked',true);
        $('#member').prop('disabled',true).trigger("chosen:updated");
        $('#group').prop('disabled',true).trigger("chosen:updated");
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

