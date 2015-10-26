
<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<script src="/static/ace/js/date-time/moment.min.js"></script>
<!-- <script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script>
-->
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/jquery.json.min.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locales/bootstrap-datepicker.zh-CN.js" charset="UTF-8"></script>


<div class="page-content">
<div class="page-content-area">
    <form class="form-horizontal"> 
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12">

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-rigtht">项目名称</label>
                            <div class="col-xs-3 col-sm-3">
                            <input type="text" class="form-controller col-xs-12" id="name" placeholder="项目名称" value="<?php echo $item['name']; ?>"></div>
                            <input type="hidden" id="item_id" name="item_id" value="<?php echo $item['id']; ?>">
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-rigtht">项目类型</label>
                            <div class="col-xs-3 col-sm-3">
                                <select id="type" class="chosen-select range tag-input-style" name="groups"  data-placeholder="请选择类型">
                                <option value="1">备注</option>
                                </select>
                            </div>
                        </div>

                        <label class="col-sm-2 control-label no-padding-rigtht" style="position:absolute;left:0px;">适用范围</label>
                        <div class="form-group">
                            <div class="col-xs-4 col-sm-4 col-xs-offset-2">
                                <select id="group" class="chosen-select range tag-input-style" name="groups[]"  data-placeholder="请选择部门">
                                <option value="-1">公司</option>
                                </select>
                            </div>
                            <label class="col-sm-1 control-label no-padding-rigtht" style="color:red">部门</label>
                        </div>
                <input type="hidden" id="renew" name="renew" value="0" />
                <input type="reset" style="display:none;" id="reset">
                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <a class="btn btn-white btn-primary renew" data-renew="0"> <i class="ace-icon fa fa-save "></i>
                            保存
                        </a>

                        <a style="position:relative;left:80px;" class="btn btn-white cancel" data-renew="-1"> <i class="ace-icon fa fa-undo gray bigger-110"></i>
                            取消
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </form>
</div>
</div>


<!-- PAGE CONTENT ENDS -->

<script type="text/javascript">
    var __BASEURL = "<?php echo base_url(); ?>";
   $(document).ready(function(){
        $('.chosen-select').chosen({allow_single_deselect:true , width:"100%"});
       
        $('.cancel').click(function(){
            history.go(-1);
        });
        $("#modal-table").find("label input").click(function(event) {
            var DOM = $("#modal-table").find(".quota");
            DOM.attr('disabled', !DOM.attr('disabled'));
        });

        $('.renew').click(function() {
            var name = $('#name').val();
            var group = $('#group').val();
            var type = $('#type').val();
            var _item_id = $('#item_id').val();
            if(name == '')
            {
                $('#name').focus();
                show_notify("请输入名称");
                return false;
            }
            if(isAllChinese(name)) {
                if(getRealLen(name) > 16) {
                    show_notify("项目名称最多只能有8个汉字");
                    return false;
                }
            } else {
                if(getRealLen(name) > 14) {
                    show_notify("项目名称最多只能有14个字符");
                    return false;
                }
            }
            $.ajax({
                type:"post",
                url:__BASE+"company/docreate_custom_item",
                data:{
                    gids:group,
                    name:name,
                    item_id:_item_id,
                    type:type,
                },
                dataType:'json',
                success:function(data){
                        if(data.status == 1) {
                            show_notify('保存成功');
                            location.href = __BASEURL + 'company/custom_item';
                        } else {
                            show_notify('保存失败');
                        }
                },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {}
               });
        });

    });

    // 如果全部汉字，就得给8个汉字，如果不是全部汉字，就14个字符
    function isAllChinese(str) {
        if(!str || (str && 0 == str.length)) return false;
        var obj = str.match(/[^\x00-\xff]/g);
        if(!obj) return false;
        return obj.length == str.length;
    }

    function getRealLen(str) {  
            return str.replace(/[^\x00-\xff]/g, '__').length; 
    } 
</script>
