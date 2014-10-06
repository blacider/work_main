<div class="bs-doc-section">
<div class="panel panel-default">
  <div class="panel-heading">
  <h3 class="panel-title"><?php echo $profile['nickname']; ?></h3>
  </div>
  <div class="panel-body">

  <form id="profile_form" class="form-horizontal" role="form" method="post" action="<?php echo base_url('users/update_password'); ?>">
    <div class="form-group">
      <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
         <div class="col-sm-10">
<div id="swfContainer">
本组件需要安装Flash Player后才可使用，请从<a href="http://www.adobe.com/go/getflashplayer">这里</a>下载安装。
</div>
        </div>
    </div>


    <div class="form-group text-center">
    <div class="col-sm-12">
<input id="upload" value="更新" class="btn btn-primary">
    </div>
    </div>

</form>

  </div>
</div>
</div>
<script language="javascript" src="<?php echo base_url('statics/fl/scripts/swfobject.js');?>"></script>
<script language="javascript" src="<?php echo base_url('statics/fl/scripts/fullAvatarEditor.js');?>"></script>
<script language="javascript">
$(document).ready(function(){
    swfobject.addDomLoadEvent(function () {
        var swf = new fullAvatarEditor("swfContainer", {
            id: 'swf',
                file: __BASEURL + "statics/fl/fullAvatarEditor.swf",
                upload_url: 'users/update_avatar',
                avatar_sizes: "32*32",
                avatar_tools_visible: false,
                src_upload:false
        }, function (msg) {
            switch(msg.code)
            {
            case 3 :
                if(msg.type == 0)
                {
                }
                else if(msg.type == 1)
                {
                    alert("摄像头已准备就绪但用户未允许使用！");
                }
                else
                {
                    alert("摄像头被占用！");
                }
                break;
            case 5 :
                location.href = __BASEURL + "users/avatar";
                if(msg.type == 0)
                {
                    if(msg.content.sourceUrl)
                    {
                    }
                }
                break;
            }
        }
    );
        document.getElementById("upload").onclick=function(){
            swf.call("upload");
        };
    });
});
</script>


