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
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
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
                                <label class="col-sm-3 control-label no-padding-right">报销单是否包含备注</label>
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

                            <input type="hidden" id="renew" name="renew" value="0" />
                            <input type="reset" style="display:none;" id="reset">
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>

                                    <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
       
        if(data.same_category!=undefined)
        {
            if(data.same_category==1)
            {
            $('#isadmin').attr('checked', data.same_category);
            $("#isadmin").trigger("chosen:updated");
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

        if(data.export_no_company!=undefined)
        {
            if(data.export_no_company==1)
            {
            $('#isremark').attr('checked', data.export_no_company);
            $("#isremark").trigger("chosen:updated");
            }

        }

        if(data.template != undefined) {
            $("#temp").val( data.template ).attr('selected',true);
            $(".chosen-select").trigger("chosen:updated");
        }

        if(data.user_confirm != undefined) {
            $('#limit').val(data.user_confirm);
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
                data:{ischecked:$('#isadmin').is(':checked'),isremark:$('#isremark').is(':checked'),iscompany:$('#iscompany').is(':checked'),template:$('#temp option:selected').val(),limit:lval,reports_limit:r_limit},
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

       

