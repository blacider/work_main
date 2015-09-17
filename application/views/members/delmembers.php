<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<div class="page-content">
    <div class="page-content-area">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                        	<div class="form-group">
                        	<label class="col-sm-1 control-label no-padding-rigtht" style="color:red">员工</label>
                            <div class="col-xs-4 col-sm-4">
                                <select id="member" class="chosen-select tag-input-style" style="width:95%" multiple="multiple" name="member[]"  data-placeholder="请选择员工">
                                    <?php
                                    foreach($members as $ug){
                                    ?>
                                    <option  value="<?php echo $ug['email']; ?>">
                                        <?php echo $ug['nickname']; ?>
                                        (<?php echo $ug['email']; ?>)</option>
                                    <?php
                                    }

                                    ?></select>
                            </div>
                            <div class="btn btn-primary" id="submit" onclick="delectOneUser_()">开始删除</div>
                        	</div>

                        	<div class="form-group" style="clear:both">
                        		<label class="col-sm-2 control-label no-padding-right">结果:</label>
                        		<textarea id="result" cols="50" rows="10" style="margin-top: 15px;"></textarea>
                        	</div>
                        		
                        		
                        </div>

                    </div>
    </div>
</div>
<script type="text/javascript">
	var __BASE = "<?php echo $base_url;?>";
    var errorList = new Array();
	$(document).ready(function(){
		$('.chosen-select').chosen(); 

		//$('#submit').click(function() {
		//	delectOneUser();
		//});
	});
	function delectOneUser_() {
		if (confirm("确认删除吗？") == true) delectOneUser();
	}
	function delectOneUser() {
		var emails = $('.chosen-select').val();
		if (emails != null) {
			var email = emails.pop();
			var log = $('#result').val() + "正在删除用户:" + email + '\n';
			$('#result').val(log);
			$('.chosen-select').val(emails).trigger("chosen:updated");
			console.log(email);
			ajaxDelect(email);
		} else if (errorList.length) {
			errorList.join();
			$('.chosen-select').val(errorList).trigger("chosen:updated");
			var log = $('#result').val() + "失败删除用户:{\n" + errorList.join('\n') + '\n' + '}已在输入框显示' + '\n';
			$('#result').val(log);
			while (errorList.length) errorList.pop();
		}
	}
	function ajaxDelect(email) {
		//$.ajax({}); 成功转向ajaxSuccess(),失败转向ajaxError(),参数如下
		$.ajax({
			 url:__BASE+'members/members_del',
			 method:'POST',
			 dataType:'json',
			 data:{'email':email},
			 success:function(data){
			 	if(data.status)
			 	{
			 		ajaxSuccess(email);
			 	}
			 	else
			 	{
			 		ajaxError(email,data.msg);
			 	}
			 },
			 error:function(a,b,c){
			 	console.log(a);
			 	console.log(b);
			 }

		});
		//ajaxError(email, 'test');
	}
	function ajaxSuccess(email) {
		var log = $('#result').val() + "成功删除用户:" + email + '\n';
		$('#result').val(log);
		delectOneUser();
	}
	function ajaxError(email, reason) {
		var log = $('#result').val() + "删除用户" + email + '失败!!!由于:' + reason + '\n';
		$('#result').val(log);
		errorList.push(email);
		delectOneUser();
	}
</script>