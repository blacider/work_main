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
                                <label class="col-sm-2 control-label no-padding-right">允许不同类目消费记录</label>
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
                                <label class="col-sm-2 control-label no-padding-rigtht">报销单模板选择</label>
                                <div class="col-xs-4 col-sm-4">
                                    <select id="temp" class="chosen-select tag-input-style" name="temp"  data-placeholder="请选择标签">
                                    <option value="a4.yaml">A4模板</option>
                                    <option value="b5.yaml">B5模板</option>
                                </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-rigtht">需要用户确认额度</label>
                                <div class="col-xs-4 col-sm-4">
					<input id="limit" type="text" class="form-controller col-xs-12" name="limit" placeholder="输入额度">
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

        if(data.same_category!=undefined)
        {
            $('#isadmin').attr('checked', data.same_category);
        }
        if(data.template != undefined) {
            $("#temp").val( data.template ).attr('selected',true);
            $(".chosen-select").trigger("chosen:updated");
        }

        if(data.user_confirm != undefined) {
            $('#limit').val(data.user_confirm);
        }
    }
   });

        $('.renew').click(function(){
	   var lval = parseInt($('#limit').val());
	   if(lval>0)
	   {
           $.ajax({
                type:"post",
                url:__BASE+"company/profile",
                data:{ischecked:$('#isadmin').is(':checked'),template:$('#temp option:selected').val(),limit:lval},
                dataType:'json',
                success:function(data){
                        console.log(data);
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

       

