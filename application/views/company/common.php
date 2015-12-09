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
                                <label class="col-sm-3 control-label no-padding-right">必须填写银行信息</label>
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
                                <label class="col-sm-3 control-label no-padding-right">同一报销单中允许包含不同类别的消费</label>
                                <div class="col-xs-6 col-sm-6">
                                 <!--   <input type="text" placeholder="组名称" class="col-xs-12" required="required" name="gname"> -->
                                   <!-- <div class="col-xs-12 col-sm-12 col-md-12"> -->
                                        <label style="margin-top:8px;">
                                            <input name="same_category" class="ace ace-switch btn-rotate" type="checkbox" id="same_category" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>

                                   <!-- </div> -->
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">审批时修改后金额不能大于提交金额</label>
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
                                <label class="col-sm-3 control-label no-padding-right">报销单打印时隐藏备注</label>
                                <div class="col-xs-6 col-sm-6">
                                 <!--   <input type="text" placeholder="组名称" class="col-xs-12" required="required" name="gname"> -->
                                   <!-- <div class="col-xs-12 col-sm-12 col-md-12"> -->
                                        <label style="margin-top:8px;">
                                            <input name="export_no_note" class="ace ace-switch btn-rotate" type="checkbox" id="export_no_note" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                   <!-- </div> -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">报销单打印时隐藏商家</label>
                                <div class="col-xs-6 col-sm-6">
                                        <label style="margin-top:8px;">
                                            <input name="hide_merchants" class="ace ace-switch btn-rotate" type="checkbox" id="hide_merchants" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                </div>
                            </div>

                              <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">不允许自主选择下一审批人</label>
                                <div class="col-xs-4 col-sm-4">
                                        <label style="margin-top:8px;">
                                            <input name="close_directly" class="ace ace-switch btn-rotate" type="checkbox" id="close_directly" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                </div>
                            </div>

                              <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">报销单状态变化时邮件通知</label>
                                <div class="col-xs-4 col-sm-4">
                                        <label style="margin-top:8px;">
                                            <input name="mail_notify" class="ace ace-switch btn-rotate" type="checkbox" id="mail_notify" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                </div>
                            </div>

                              <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">普通员工不可见组织结构</label>
                                <div class="col-xs-4 col-sm-4">
                                        <label style="margin-top:8px;">
                                            <input name="private_structure" class="ace ace-switch btn-rotate" type="checkbox" id="private_structure" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                </div>
                            </div>

                              <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">不填写「备注」无法提交报销</label>
                                <div class="col-xs-4 col-sm-4">
                                        <label style="margin-top:8px;">
                                            <input name="note_compulsory" class="ace ace-switch btn-rotate" type="checkbox" id="note_compulsory" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                </div>
                            </div>

                              <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">消费时间不自动生成</label>
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
                                            <input name="export_no_company" class="ace ace-switch btn-rotate" type="checkbox" id="export_no_company" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>

                                   <!-- </div> -->
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">是否开放外汇</label>
                                <div class="col-xs-6 col-sm-6">
                                 <!--   <input type="text" placeholder="组名称" class="col-xs-12" required="required" name="gname"> -->
                                   <!-- <div class="col-xs-12 col-sm-12 col-md-12"> -->
                                        <label style="margin-top:8px;">
                                            <input name="open_exchange" class="ace ace-switch btn-rotate" type="checkbox" id="open_exchange" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>

                                   <!-- </div> -->
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">在Excel中增加类目金额汇总</label>
                                <div class="col-xs-6 col-sm-6">
                                 <!--   <input type="text" placeholder="组名称" class="col-xs-12" required="required" name="gname"> -->
                                   <!-- <div class="col-xs-12 col-sm-12 col-md-12"> -->
                                        <label style="margin-top:8px;">
                                            <input name="statistic_using_category" class="ace ace-switch btn-rotate" type="checkbox" id="statistic_using_category" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>

                                   <!-- </div> -->
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">报告按照类目分类</label>
                                <div class="col-xs-6 col-sm-6">
                                        <label style="margin-top:8px;">
                                            <input name="same_category_pdf" class="ace ace-switch btn-rotate" type="checkbox" id="same_category_pdf" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>

                                   <!-- </div> -->
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">审批是否需要二次确认</label>
                                <div class="col-xs-6 col-sm-6">
                                        <label style="margin-top:8px;">
                                            <input name="approval_confirmation" class="ace ace-switch btn-rotate" type="checkbox" id="approval_confirmation" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>

                                   <!-- </div> -->
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">报销单页脚配置</label>
                                <div class="col-xs-4 col-sm-4">
                                    <select id="footer_format" class="chosen-select tag-input-style" name="footer_format"  data-placeholder="请选择页脚的格式">
                                    <option value="0">无</option>
                                    <option value="1">仅公司名称</option>
                                    <option value="2">仅部门名称</option>
                                    <option value="3">公司/部门名称</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">报销单打印模板设置</label>
                                <div class="col-xs-4 col-sm-4">
                                    <select id="template" class="chosen-select tag-input-style" name="template"  data-placeholder="请选择模板">
                                    <option value="a4.yaml">A4模板</option>
                                    <option value="a5.yaml">A5模板</option>
                                    <option value="b5.yaml">B5模板</option>
                                    <option value="disanshihead.yaml">210*114</option>
                                    <option value="disanshidepart.yaml">210*114 表头包含部门</option>
                                    <option value="disanshi.yaml">A4 表头有金额</option>
                                
                                </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">员工在此金额下无需确认收款</label>
                                <div class="col-xs-2 col-sm-2">
					               <input id="user_confirm" type="number" class="form-controller col-xs-12 text_input" name="user_confirm" placeholder="输入额度">
                                </div>
                                <div class="col-sm-2 col-sm-2">
                                    <div class="checkbox" style="margin-left:35px;">
                                        <label>
                                         <input type="checkbox" id="confirm_unlimit" name="confirm_unlimit" >
                                            无限制
                                         </label>
                                    </div>
                                 </div>
                            </div>

                             

                             <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">每月最多可提交的报销单数量</label>
                                <div class="col-xs-4 col-sm-4">
                                <input id="report_quota" type="number" class="form-controller col-xs-12 text_input" name="report_quota" placeholder="报销单数">
                                </div>
                            </div>

                              <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">最多可提交最近几个月之前的报销</label>
                                <div class="col-xs-4 col-sm-4">
                                <input id="max_allowed_months" type="number" class="form-controller col-xs-12 text_input" name="max_allowed_months" placeholder="月数">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-rigtht">自然月起始</label>
                                <div class="col-xs-4 col-sm-4">
                                <input id="calendar_month" type="number" class="form-controller col-xs-12 text_input" name="calendar_month" placeholder="自然月">
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
    $('#profile').submit();
	});*/

   $("#confirm_unlimit").change(function(){
        if($(this).is(':checked'))
        {
            $('#user_confirm').prop('disabled',true).trigger('chosen:updated');
        }
        else
        {
            $('#user_confirm').prop('disabled',false).trigger('chosen:updated');
        }
   });
   $.ajax({
    type:"get",
    url:__BASE+"company/getsetting",
    dataType:'json',
    success:function(data){
        //设置checkbox的值
        $('.btn-rotate').each(function(){
            var temp_name = $(this).prop('name');
            if(data[temp_name] == 1)
            {
                $("input[name="+temp_name+"]").prop('checked',data[temp_name]);
                $("input[name="+temp_name+"]").trigger('chosen:updated');
            }
        });

        //设置select的值
        $('.chosen-select').each(function(){
            var temp_name = $(this).prop('name');
            if(data[temp_name] != undefined)
            {
                $("#"+temp_name).val(data[temp_name]).prop('selected',true);
                $("#"+temp_name).trigger("chosen:updated");
            }
        });

        //设置text的值
        $('.text_input').each(function(){
            var temp_name = $(this).prop('name');
            if(data[temp_name] != undefined)
            {
                $('input[name='+temp_name+']').val(data[temp_name]);
            }
        });

        if(data.user_confirm != undefined) {
            if(data.user_confirm == -1)
            {
                $('#user_confirm').val('');
                $('#confirm_unlimit').attr('checked',true);
                $('#confirm_unlimit').trigger('change');
                $('#confirm_unlimit').trigger('change:updated');
                //$('#confirm_unlimit').trigger('click');
            }
            else
            {
                $('#user_confirm').val(data.user_confirm);
            }
        }
    }
   });

    $('.renew').click(function(){

        //保存上传数据
        var upload_data = new Object();

        //checkbox数据获取
        $('.btn-rotate').each(function(){
            if($(this).is(':checked'))
            {
                $(this).val(1);
            }
            else
            {
                $(this).val(0);
            }
            var temp_name = $(this).prop('name');
            upload_data[temp_name] = $(this).val();
        });

        //单选框数据获取
        $('.chosen-select').each(function(){
            var temp_name = $(this).prop('name');
            upload_data[temp_name] = $('option:selected',this).val();
        });

        //输入文本框数据获取
        $('.text_input').each(function(){
            var temp_name = $(this).prop('name');
            upload_data[temp_name] = $(this).val();
        });


        var lval = $('#user_confirm').val();
        if($('#confirm_unlimit').is(':checked'))
        {
            lval = -1;
        }

        var calendar_month = $('#calendar_month').val();
        if(isNaN(calendar_month))
        {
            calendar_month = 0;
        }
        if(calendar_month>=32 || calendar_month <= 0)
        {
            $('#calendar_month').focus();
            show_notify('请输入有效的自然月');
            return false;
        }
        if(isNaN(lval))
        {
                lval = 0;
        }
        upload_data['user_confirm'] = lval;
       if(lval>=0 || lval == -1)
       {
               $.ajax({
                    type:"post",
                    url:__BASE+"company/profile",
                    data:{'company_config':upload_data},
                    dataType:'json',
                    success:function(data){
                           show_notify('保存成功');
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        },            });
    	 }
    	 else
    	 {
    	 	show_notify('请输入有效额度');
    	 	$('#user_confirm').val('');
    		$('#user_confirm').focus();
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

       

