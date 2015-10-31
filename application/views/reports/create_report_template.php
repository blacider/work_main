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
                                <label class="col-sm-2 control-label no-padding-rigtht">报告模板名</label>
                                <div class="col-xs-4 col-sm-4">
                                <input id="template_name" type="text" class="form-controller col-xs-12" name="template_name" placeholder="输入报告模板名">
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
    $('#profile').submit();
	});*/


        $('.renew').click(function(){
            var _name = $('#sob_name').val();
            if(_name == '')
            {
                $('#template_name').focus();
                show_notify("请输入报告模板名");
                return false;
            }
            /*if(sgroups == null)
            {
                $('#group').focus();
                show_notify("请选择部门");
                return false;
            }*/
	       $.ajax({
                type:"post",
                url:__BASE+"company/docreate_report_template",
                data:{template_name:$('#template_name').val()},
                dataType:'json',
                success:function(data){
                        if(data['id'] != undefined)
                        {
                            show_notify('保存成功');
                            window.location.href=__BASE+"company/update_report_template/"+data['id'];
                        }
                        else
                        {
                            show_notify('保存失败');
                            window.location.href=__BASE+"company/report_template_list";
                        }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    },            });
	 
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
            $('#template_name').val('');
           	
        });
    });
</script>

       

