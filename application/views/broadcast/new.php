
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
<form role="form" action="<?php echo base_url('broadcast/docreate');  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" id="itemform">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right">标题</label>
                <div class="col-xs-6 col-sm-6">
                    <input type="text" class="form-controller col-xs-12" name="title" id="title" placeholder="标题" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right">正文</label>
                <div class="col-xs-6 col-sm-6">
                    <textarea class="col-xs-12 col-sm-12" row="30" id="content" name="content"></textarea>
                </div>
            </div>

                 <div class="from-group">
                    <label class="col-sm-1 control-label no-padding-right">适用范围</label>
                 <div class="col-xs-4 col-sm-4">
                                    <select id="group" class="chosen-select range tag-input-style" multiple="multiple" name="groups[]"  data-placeholder="请选择部门">
                                    <?php
                                        foreach($ugroups as $item)
                                        {
                                    ?>
                                        <option value="<?php echo $item['id']?>"><?php echo $item['name']?></option>
                                    <?php
                                        }
                                    ?></select>
                                </div>
                                <label class="col-sm-1 control-label no-padding-rigtht" style="color:red">部门</label>
                </div>

                  <div class="from-group">
                    <label class="col-sm-1 control-label no-padding-right"></label>
                 <div class="col-xs-4 col-sm-4">
                                    <select id="group" class="chosen-select range tag-input-style" multiple="multiple" name="ranks[]"  data-placeholder="请选择级别">
                                    <?php
                                        foreach($ranks as $item)
                                        {
                                    ?>
                                        <option value="<?php echo $item['id']?>"><?php echo $item['name']?></option>
                                    <?php
                                        }
                                    ?></select>
                                </div>
                                <label class="col-sm-1 control-label no-padding-rigtht" style="color:red">级别</label>
                </div>

                  <div class="from-group">
                    <label class="col-sm-1 control-label no-padding-right"></label>
                 <div class="col-xs-4 col-sm-4">
                                    <select id="group" class="chosen-select range tag-input-style" multiple="multiple" name="levels[]"  data-placeholder="请选择职位">
                                    <?php
                                        foreach($levels as $item)
                                        {
                                    ?>
                                        <option value="<?php echo $item['id']?>"><?php echo $item['name']?></option>
                                    <?php
                                        }
                                    ?></select>
                                </div>
                                <label class="col-sm-1 control-label no-padding-rigtht" style="color:red">职位</label>
                </div>

                  <div class="from-group">
                    <label class="col-sm-1 control-label no-padding-right"></label>
                 <div class="col-xs-4 col-sm-4">
                                    <select id="group" class="chosen-select range tag-input-style" multiple="multiple" name="members[]"  data-placeholder="请选择员工">
                                    <?php
                                        foreach($members as $item)
                                        {
                                    ?>
                                        <option value="<?php echo $item['id']?>"><?php echo $item['nickname']?></option>
                                    <?php
                                        }
                                    ?></select>
                                </div>
                                <label class="col-sm-1 control-label no-padding-rigtht" style="color:red">员工</label>
                </div>
                  <div class="from-group">
                    <label class="col-sm-1 control-label no-padding-right"></label>
                 <div class="col-xs-4 col-sm-4">
                    <input type="checkbox" id="is_all" name="all" value='0'/>全体员工
                </div>
                </div>

           
                       
                   <input type="hidden" name="send" id="is_send" value="0">
            <div class="clearfix form-actions col-sm-8 col-xs-8">
                <div class="col-md-offset-3 col-md-8">
                    <a class="btn btn-white btn-primary renew" data-renew="-1"><i class="ace-icon fa fa-save "></i>取消</a>
                    <a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>
                    <a class="btn btn-white btn-primary renew" data-renew="1"><i class="ace-icon fa fa-save "></i>发送</a>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
</div>

<script language="javascript">
var __BASE = "<?php echo base_url();?>";
$(document).ready(function() {
 
     $('.renew').each(function(){
        $(this).click(function(){
             var renew = $(this).data('renew');
             if(renew == -1)
             {
                location.href = __BASE + 'broadcast/index'; 
             }
             if(renew == 0)
             {
                if(confirm("确认保存消息?"))
                    $('#itemform').submit();
             }
             if(renew == 1)
             {
                if(confirm("发送后将不能撤回，确认发送消息?"))
                {
                    var title = $('#title').val();
                    var content = $('#content').val();
                    var some = 0;
                    $('.range').each(function(){
                        if($(this).val())
                        {
                            some = 1;
                        }
                       
                    });
                    if(!title)
                    {
                        show_notify('请输入标题');
                        return false;
                    }
                    if(!content)
                    {
                        show_notify('请输入内容');
                        return false;
                    }
                    if(some == 0 && $('#is_all').val() == 0)
                    {
                        show_notify('请选择适用范围');
                        return false;
                    }
                    

                    $('#is_send').val(1);
                    
                    $('#itemform').submit();
                }
             }
        });
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


    $('#is_all').click(function(){
        if($('#is_all').is(":checked"))
        {
            $('#is_all').val(1);
            console.log($('#is_all').val()); 
        }
        else
        {
            $('#is_all').val(0); 
            console.log($('#is_all').val());           
        }
    });

});

</script>
