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
            <div class="row" style="overflow:hidden;">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                     

                           <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-rigtht">帐套名</label>
                                <div class="col-xs-4 col-sm-4">
                                <input id="sob_name" type="text" class="form-controller col-xs-12" name="sob_name" placeholder="输入帐套名">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-rigtht">部门选择</label>
                                <div class="col-xs-4 col-sm-4">
                                    <select id="group" class="chosen-select tag-input-style" multiple="multiple" name="groups[]"  data-placeholder="请选择部门">
                                      <option value="0">公司</option>
                                    <?php
                                      $exit = array();
                                    foreach($sob_data as $ug){
                                    ?>
                                             <option selected value="<?php echo $ug['group_id']; ?>"><?php echo $ug['group_name']; ?></option>
                                    <?php
                                        array_push($exit, $ug['group_id']);
                                    }

                                    foreach($ugroups as $ug){
                                        if(!in_array($ug['id'], $exit))
                                        {
                                            ?>
                                            <option select value="<?php echo $ug['id']; ?>"><?php echo $ug['name']; ?></option>
                                            <?php
                                        }
                                    }

                                    ?>                                
                                </select>
                                </div>
                            </div>
                            
                      

                            <input type="hidden" id="sob_id" name="sob_id" value="<?php echo $sob_id?>" />
                            <input type="hidden" id="renew" name="renew" value="0" />
                            <input type="reset" style="display:none;" id="reset">
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>

                                    <a style="position:relative;left:80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
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
var _sob_id = "<?php echo $sob_id ?>";
   $(document).ready(function(){
   /*	$('.renew').click(function(){
    var _checked = $('#isadmin').is('checked');
    console.log("checked" + _checked);
    $('#profile').submit();
	});*/
        $.ajax({
            type:"get",
            url:__BASE+"category/getsobs",
            dataType:"json",
            success:function(data){
                console.log(data);
                console.log(data[_sob_id]);
                _sob_data = data[_sob_id];
                _sob_name = _sob_data['sob_name'];
                _sob_groups = _sob_data['groups'];
                console.log(_sob_name);
                $('#sob_name').val(_sob_name);
                console.log(_sob_groups);
            },
             error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.status);
                        console.log(XMLHttpRequest.readyState);
                        console.log(textStatus);
                    },
        });


        $('.renew').click(function(){

            var sname = $('#sob_name').val();
            var sgroups = $('#group').val();
            //if(sname)
      
            if(sname == '')
            {
                $('#sob_name').focus();
                show_notify("请输入用户名");
                return false;
            }
            if(sgroups == null)
            {
                $('#group').focus();
                show_notify("请选择部门");
                return false;
            }

	              $.ajax({
                type:"post",
                url:__BASE+"category/update_sob",
                data:{sob_name:$('#sob_name').val(),groups:$('#group').val(),sid:$('#sob_id').val()},
                dataType:'json',
                success:function(data){
                       show_notify('保存成功');
                       window.location.href=__BASE+"category/account_set";
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.status);
                        console.log(XMLHttpRequest.readyState);
                        console.log(textStatus);
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
            $('#sob_name').val(_sob_name);
            $("#group").val('');
            for (var item in _sob_groups) {
                if (item != undefined) {
                    var _id = _sob_groups[item].group_id;
                    $('select').find('option[value="'+ _id +'"]').attr('selected', 'true');
                }
            }
            $('#group').trigger("chosen:updated");

        });
    });
</script>

       

