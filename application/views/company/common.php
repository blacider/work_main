<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<script src="/static/ace/js/date-time/moment.min.js"></script>
<!-- <script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script> -->
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/dropzone.min.js"></script>


<script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locales/bootstrap-datepicker.zh-CN.js" charset="UTF-8"></script>




<div class="page-content">
    <div class="page-content-area">
        <form role="form"  class="form-horizontal"  enctype="multipart/form-data" id="mainform">
            <!-- <div class="row"> -->
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">是否不允许预借</label>
                                <div class="col-xs-6 col-sm-6">
                                 <!--   <input type="text" placeholder="组名称" class="col-xs-12" required="required" name="gname"> -->
                                   <!-- <div class="col-xs-12 col-sm-12 col-md-12"> -->
                                        <label style="margin-top:8px;">
                                            <input name="allow_borrow" class="ace ace-switch btn-rotate" type="checkbox" id="allow_borrow" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>

                                   <!-- </div> -->
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">是否是否隐藏预算</label>
                                <div class="col-xs-6 col-sm-6">
                                 <!--   <input type="text" placeholder="组名称" class="col-xs-12" required="required" name="gname"> -->
                                   <!-- <div class="col-xs-12 col-sm-12 col-md-12"> -->
                                        <label style="margin-top:8px;">
                                            <input name="allow_budget" class="ace ace-switch btn-rotate" type="checkbox" id="allow_budget" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>

                                   <!-- </div> -->
                                </div>
                            </div>

                              <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">是否有银行信息</label>
                                <div class="col-xs-6 col-sm-6">
                                 <!--   <input type="text" placeholder="组名称" class="col-xs-12" required="required" name="gname"> -->
                                   <!-- <div class="col-xs-12 col-sm-12 col-md-12"> -->
                                        <label style="margin-top:8px;">
                                            <input name="need_bank_info" class="ace ace-switch btn-rotate" type="checkbox" id="need_bank_info" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>

                                   <!-- </div> -->
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">同一报告中是否允许包含不同类目消费</label>
                                <div class="col-xs-6 col-sm-6">
                                 <!--   <input type="text" placeholder="组名称" class="col-xs-12" required="required" name="gname"> -->
                                   <!-- <div class="col-xs-12 col-sm-12 col-md-12"> -->
                                        <label style="margin-top:8px;">
                                            <input name="isadmin" class="ace ace-switch btn-rotate" type="checkbox" id="isadmin" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>

                                   <!-- </div> -->
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">修改金额不能大于原始金额</label>
                                <div class="col-xs-6 col-sm-6">
                                 <!--   <input type="text" placeholder="组名称" class="col-xs-12" required="required" name="gname"> -->
                                   <!-- <div class="col-xs-12 col-sm-12 col-md-12"> -->
                                        <label style="margin-top:8px;">
                                            <input name="low_amount_only" class="ace ace-switch btn-rotate" type="checkbox" id="low_amount_only" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                   <!-- </div> -->
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">报销单是否省略备注</label>
                                <div class="col-xs-6 col-sm-6">
                                 <!--   <input type="text" placeholder="组名称" class="col-xs-12" required="required" name="gname"> -->
                                   <!-- <div class="col-xs-12 col-sm-12 col-md-12"> -->
                                        <label style="margin-top:8px;">
                                            <input name="isremark" class="ace ace-switch btn-rotate" type="checkbox" id="isremark" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                   <!-- </div> -->
                                </div>
                            </div>

                              <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">审批按照规则运行</label>
                                <div class="col-xs-4 col-sm-4">
                                        <label style="margin-top:8px;">
                                            <input name="close_directly" class="ace ace-switch btn-rotate" type="checkbox" id="close_directly" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                </div>
                            </div>

                              <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">邮件通知报告状态变化</label>
                                <div class="col-xs-4 col-sm-4">
                                        <label style="margin-top:8px;">
                                            <input name="mail_notify" class="ace ace-switch btn-rotate" type="checkbox" id="mail_notify" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                </div>
                            </div>

                              <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">不开放组织结构</label>
                                <div class="col-xs-4 col-sm-4">
                                        <label style="margin-top:8px;">
                                            <input name="private_structure" class="ace ace-switch btn-rotate" type="checkbox" id="private_structure" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                </div>
                            </div>

                              <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">必须填写备注</label>
                                <div class="col-xs-4 col-sm-4">
                                        <label style="margin-top:8px;">
                                            <input name="note_compulsory" class="ace ace-switch btn-rotate" type="checkbox" id="note_compulsory" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                </div>
                            </div>

                              <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">不默认填写消费时间</label>
                                <div class="col-xs-4 col-sm-4">
                                        <label style="margin-top:8px;">
                                            <input name="not_auto_time" class="ace ace-switch btn-rotate" type="checkbox" id="not_auto_time" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">报销单是否包含公司</label>
                                <div class="col-xs-6 col-sm-6">
                                 <!--   <input type="text" placeholder="组名称" class="col-xs-12" required="required" name="gname"> -->
                                   <!-- <div class="col-xs-12 col-sm-12 col-md-12"> -->
                                        <label style="margin-top:8px;">
                                            <input name="iscompany" class="ace ace-switch btn-rotate" type="checkbox" id="iscompany" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>

                                   <!-- </div> -->
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">报销单打印模板设置</label>
                                <div class="col-xs-4 col-sm-4">
                                    <select id="temp" class="chosen-select tag-input-style" name="temp"  data-placeholder="请选择模板">
                                    <option value="a4.yaml">A4模板</option>
                                    <option value="a5.yaml">A5模板</option>
                                    <option value="b5.yaml">B5模板</option>
                                
                                </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">报告结算后需员工确认的额度</label>
                                <div class="col-xs-4 col-sm-4">
					               <input id="limit" type="text" class="form-controller col-xs-12" name="limit" placeholder="输入额度">
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">每月最多可提交的报告数量</label>
                                <div class="col-xs-4 col-sm-4">
                                <input id="reports_limit" type="text" class="form-controller col-xs-12" name="reports_limit" placeholder="报告数">
                                </div>
                            </div>

                              <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">只可以提交最近几个月的报销限制</label>
                                <div class="col-xs-4 col-sm-4">
                                <input id="max_allowed_months" type="text" class="form-controller col-xs-12" name="max_allowed_months" placeholder="月数">
                                </div>
                            </div>





                            <input type="hidden" id="renew" name="renew" value="0" />
                            <input type="reset" style="display:none;" id="reset">
                            <div class="clearfix form-actions col-sm-10 col-md-10">
                                <div class="col-md-offset-3 col-md-9">
                                    <a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>

                                    <a  class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!--</div>-->
        </form>
    </div>
</div>

<script type="text/javascript">
var __BASE = "<?php echo $base_url; ?>";
</script>
<script type="text/javascript">
   $(document).ready(function(){
   /*	$('.renew').click(function(){
    var _checked = $('#isadmin').is('checked');
    console.log("checked" + _checked);
    $('#profile').submit();
	});*/
   $.ajax({
    type:"get",
    url:__BASE+"company/getsetting",
    dataType:'json',
    success:function(data){

       // console.log(data);

         if(data.allow_budget!=undefined)
        {
            if(data.allow_budget==1)
            {
            $('#allow_budget').attr('checked', data.allow_budget);
            $("#allow_budget").trigger("chosen:updated");
            }

        }

       if(data.allow_borrow!=undefined)
        {
            if(data.allow_borrow==1)
            {
            $('#allow_borrow').attr('checked', data.allow_borrow);
            $("#allow_borrow").trigger("chosen:updated");
            }

        }
       
        if(data.same_category!=undefined)
        {
            if(data.same_category==1)
            {
            $('#isadmin').attr('checked', data.same_category);
            $("#isadmin").trigger("chosen:updated");
            }

        }

        if(data.not_auto_time!=undefined)
        {
            if(data.not_auto_time==1) {
                $('#not_auto_time').attr('checked', data.not_auto_time);
                $("#not_auto_time").trigger("chosen:updated");
            }
        }


        if(data.note_compulsory != undefined)
        {
            if(data.note_compulsory ==1) {
                $('#note_compulsory').attr('checked', data.note_compulsory);
                $("#note_compulsory").trigger("chosen:updated");
            }
        }



        if(data.export_no_note!=undefined)
        {
            if(data.export_no_note==1)
            {
            $('#isremark').attr('checked', data.export_no_note);
            $("#isremark").trigger("chosen:updated");
            }

        }

         if(data.need_bank_info!=undefined)
        {
            if(data.need_bank_info==1)
            {
            $('#need_bank_info').attr('checked', data.need_bank_info);
            $("#need_bank_info").trigger("chosen:updated");
            }

        }
        if(data.close_directly!=undefined)
        {
            if(data.close_directly==1)
            {
            $('#close_directly').attr('checked', data.close_directly);
            $("#close_directly").trigger("chosen:updated");
            }

        }
        if(data.low_amount_only!=undefined)
        {
            if(data.low_amount_only==1)
            {
            $('#low_amount_only').attr('checked', data.low_amount_only);
            $("#low_amount_only").trigger("chosen:updated");
            }

        }

        if(data.export_no_company!=undefined)
        {
            if(data.export_no_company==1)
            {
            $('#iscompany').attr('checked', data.export_no_company);
            $("#iscompany").trigger("chosen:updated");
            }

        }
        if(data.mail_notify !=undefined)
        {
            if(data.mail_notify==1)
            {
            $('#mail_notify').attr('checked', data.mail_notify);
            $("#mail_notify").trigger("chosen:updated");
            }

        }
        if(data.private_structure !=undefined)
        {
            if(data.private_structure ==1)
            {
            $('#private_structure').attr('checked', data.private_structure);
            $("#private_structure").trigger("chosen:updated");
            }

        }

        if(data.template != undefined) {
            $("#temp").val( data.template ).attr('selected',true);
            $(".chosen-select").trigger("chosen:updated");
        }

        if(data.user_confirm != undefined) {
            $('#limit').val(data.user_confirm);
        }

        if(data.max_allowed_months != undefined) {
            $('#max_allowed_months').val(data.max_allowed_months);
        }

        if(data.report_quota != undefined)
        {
            $('#reports_limit').val(data.report_quota);
        }
    }
   });

        $('.renew').click(function(){
	   var lval = parseInt($('#limit').val());
       var r_limit = $('#reports_limit').val();
    //   console.log(lval);
      // console.log($('#isadmin').is(':checked'));
       if(isNaN(lval))
       {
            lval = 0;
       }
	   if(lval>=0)
	   {
           $.ajax({
                type:"post",
                url:__BASE+"company/profile",
                data:{
                    allow_borrow:$('#allow_borrow').is(':checked'),
                    allow_budget:$('#allow_budget').is(':checked'),
                    note_compulsory:$('#note_compulsory').is(':checked'),
                    not_auto_time:$('#not_auto_time').is(':checked'),
                    mail_notify:$('#mail_notify').is(':checked'),
                    close_directly :$('#close_directly').is(':checked'),
                    low_amount_only:$('#low_amount_only').is(':checked'),
                    max_allowed_months:$('#max_allowed_months').val(),private_structure:$('#private_structure').is(':checked'),
                        need_bank_info:$('#need_bank_info').is(':checked'),ischecked:$('#isadmin').is(':checked'),isremark:$('#isremark').is(':checked'),iscompany:$('#iscompany').is(':checked'),template:$('#temp option:selected').val(),limit:lval,reports_limit:r_limit},
                dataType:'json',
                success:function(data){
                      //  console.log(data);
                       show_notify('保存成功');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.status);
                        console.log(XMLHttpRequest.readyState);
                        console.log(textStatus);
                    },            });
	 }
	 else
	 {
	 	show_notify('请输入有效额度');
	 	$('#limit').val('');
		$('#limit').focus();
		return false;
	 }
       }); 

        $('.chosen-select').chosen({allow_single_deselect:true}); 
        $(window)
            .off('resize.chosen')
            .on('resize.chosen', function() {
                $('.chosen-select').each(function() {
                    var $this = $(this);
                    $this.next().css({'width': $this.parent().width()});
                })
            }).trigger('resize.chosen');
       
        $('.cancel').click(function(){
            $('#reset').click();
        });
    });
</script>

       

