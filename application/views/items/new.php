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
        <form role="form" action="<?php echo base_url('items/create');  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" >
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">金额</label>
                                <div class="col-xs-9 col-sm-9">
                                    <input type="text" class="form-controller col-xs-12" name="amount" placeholder="金额">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">分类</label>
                                <div class="col-xs-9 col-sm-9">
                                    <select class="form-control" name="category">
                                        <option value="0">请选择分类</option>
                                        <?php foreach($categories as $category) { ?>
                                        <option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">消费时间</label>
                                <div class="col-xs-9 col-sm-9">
                                    <div class="input-group">
                                        <input id="date-timepicker1" name="dt" type="text" class="form-control" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-clock-o bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">商家</label>
                                <div class="col-xs-9 col-sm-9">
                                    <input type="text" name="merchant" class="form-controller col-xs-12" placeholder="消费商家">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">标签</label>
                                <div class="col-xs-9 col-sm-9">
                                    <select class="chosen-select tag-input-style" name="tags" multiple="multiple" data-placeholder="请选择标签">
                                        <?php foreach($tags as $category) {?>

                                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">类型</label>
                                <div class="col-xs-9 col-sm-9">
                                    <select class="col-xs-12 col-sm-12 form-controller" name="type" data-placeholder="请选择类型">
                                        <option value="0">报销</option>
                                        <option value="1">预算</option>
                                        <option value="2">借款</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">留言</label>
                                <div class="col-xs-9 col-sm-9">
                                    <textarea name="note" class="col-xs-12 col-sm-12  form-controller" > </textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">照片</label>
                                <div class="col-xs-9 col-sm-9 dropzone" id="dropzone">
                                    <div class="fallback">
                                        <input name="file" type="file" multiple="" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 10px;min-weight:40px;">
                                <center>
                                    <button class="btn btn-success">提交</button>
                                </center>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="images" id="images" >
        </form>
    </div>
</div>
<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
$(document).ready(function(){
    //var now = moment();
    $('#date-timepicker1').datetimepicker({
        language: 'zh-cn',
            //locale:  moment.locale('zh-cn'),
            useCurrent: true,
            format: 'YYYY-MM-DD HH:mm',
            linkField: "dt",
            linkFormat: "YYYY-MM-DD HH:mm",
            sideBySide: true
    }).next().on('dp.change', function(ev){
        console.log(ev.date);
    }).on(ace.click_event, function(){
        $(this).prev().focus();
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

    Dropzone.autoDiscover = false;
    try {
        var myDropzone = new Dropzone("#dropzone" , {
            paramName: "file", 
                url: __BASE + '/items/images',
                maxFilesize: 1.5,
                addRemoveLinks : true,
                dictDefaultMessage : '<i class="upload-icon ace-icon fa fa-cloud-upload blue fa-3x"></i><br /><span class="bigger-150 bolder"><i class="ace-icon fa fa-caret-right red"></i> 把发票照片拖拽至虚线框</span>  <br /><span class="smaller-80 grey">(或者点击上传)</span> <br />',
                dictResponseError: '照片上传出错!',
                previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-details\">\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n    <div class=\"dz-size\" data-dz-size></div>\n    <img data-dz-thumbnail />\n  </div>\n  <div class=\"progress progress-small progress-striped active\"><div class=\"progress-bar progress-bar-success\" data-dz-uploadprogress></div></div>\n  <div class=\"dz-success-mark\"><span></span></div>\n  <div class=\"dz-error-mark\"><span></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n</div>"
        });
        myDropzone.on('success', function(ev, str_data){
            data = eval("(" + str_data + ")"); 
            if(data.status > 0){
                var _data =  data.data;
                var _id = _data.id;
                if(_id > 0){
                    var _exists = ($('#images').val()).split(",");
                    if($.inArray(_id, _exists) < 0){
                        _exists.push(_id);
                    }
                    $('#images').val(_exists.join(','));
                }
            }
        });
        myDropzone.on('removedfile', function(ev, str_data) {
        });
    } catch(e) {
        console.log(e);
        alert('Dropzone.js does not support older browsers!');
    }


});
</script>
