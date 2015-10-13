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
    <form role="form"  class="form-horizontal"  enctype="multipart/form-data" id="mainform" action="<?php echo base_url('company/create_finance_policy'); ?>" >
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                     

                           <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-rigtht">财务审批流名</label>
                                <div class="col-xs-4 col-sm-4">
                                <input id="sob_name" type="text" class="form-controller col-xs-12" name="sob_name" placeholder="输入财务审批流名">
                                </div>
                            </div>

                      

                            <input type="hidden" id="renew" name="renew" value="0" />
                            <input type="reset" style="display:none;" id="reset">
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>

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

        $('.renew').click(function(){
            var sname = $('#sob_name').val();
            var sgroups = $('#group').val();
            //if(sname)
            if(sname == '')
            {
                $('#sob_name').focus();
                show_notify("请输入财务审批流");
                return false;
            }
	       $.ajax({
                type:"post",
                url:__BASE+"company/create_finance_flow",
                data:{sob_name:$('#sob_name').val(),groups:0},
                dataType:'json',
                success:function(data){
                    var d = data;
                        if(d.code > 0)
                        {
                            show_notify('保存成功');
                            window.location.href=__BASE+"company/flow_update/"+d.code;
                        }
                        else
                        {
                            show_notify('保存失败');
                        }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                },            });
	       });
    });
</script>

       

