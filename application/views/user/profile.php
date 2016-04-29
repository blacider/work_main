<style>
.webuploader-pick  {
background:#fff !important;

}
#loading{
position:absolute;
width:300px;
top:0px;
left:50%;
margin-left:-150px;
text-align:center;
padding:7px 0 0 0;
font:bold 11px Arial, Helvetica, sans-serif;
}

#weixin-wallet {
    position: relative;
    line-height: 34px;
}
#weixin-wallet .logo {
    position: absolute;
    left: 50%;
    top: 50%;
    height: 30px;
    width: 30px;
    margin-top: -15px;
    margin-left: -15px;
}
</style>
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />
<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />

<div class="page-content">
    <div class="page-content-area">
        <form id="profile_form" class="form-horizontal" role="form" method="post" action="<?php echo base_url('users/update_profile'); ?>/<?php echo $isOther ?>/">
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right">头像</label>
                        <div class="col-xs-6 col-sm-6 filePicker">
                            <?php $user = $member; ?>
                            <?php $disabled = $self == 1 ? '' : 'disabled'; ?>
                            <a id="btn_cimg" class="filePicker"  style="height:144px;width:155px" class="btn btn-primary btn-white">
                            <input type="hidden" id="avatar" name="avatar" value="<?php echo $user['avatar']; ?>" />
                            <img src="<?php echo $user['avatar_url'];?>" style="height:130px;width:130px" id="avatar_src" /> </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right">邮箱</label>
                        <div class="col-xs-6 col-sm-6">
                            <?php if($self != 1) { ?>
                                <input type='hidden' id="uid" name='uid' value="<?php echo $user['id']; ?>">
                            <?php } ?>
                            <div class="col-xs-12 col-sm-12 "  style="margin-left:0px !important;padding-left:0px !important;" >
                                <input type="text" name="email" class="col-xs-10 col-sm-10" value="<?php echo $user['email']; ?>" disabled>
                                <a href="javascript:void(0)" style="margin-left:5px;" class="btn btn-danger btn-sm change_email" >修改</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right">手机</label>
                        <div class="col-xs-6 col-sm-6">
                            <input type="hidden" name="phone" value="<?php echo $user['phone']; ?>" >
                            <div class="col-xs-12 col-sm-12 "  style="margin-left:0px !important;padding-left:0px !important;" >
                                <input type="text" class="col-xs-10 col-sm-10"value="<?php echo $user['phone']; ?>" disabled/>
                                <a href="javascript:void(0)" style="margin-left:5px;" class="btn btn-danger btn-sm change_phone" >修改</a>
                            </div>
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right">用户ID</label>
                        <div class="col-xs-6 col-sm-6">
                        <?php
                            if(in_array($profile['admin'],[1,3,4]))
                            {
                        ?>
                            <input type="text" class="col-xs-6 col-sm-6 form-control" name="client_id" value="<?php echo $user['client_id']; ?>"  />
                        <?php
                            }
                            else
                            {
                        ?>
                             <input type="text" class="col-xs-6 col-sm-6 form-control" name="client_id" value="<?php echo $user['client_id']; ?>"  disabled/>
                        <?php
                            }
                        ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right">姓名</label>
                        <div class="col-xs-6 col-sm-6">
                        <?php
                            if(in_array($profile['admin'],[1,3,4]))
                            {
                        ?>
                            <input type="text" class="col-xs-6 col-sm-6 form-control" name="nickname" value="<?php echo $user['nickname']; ?>"  />
                         <?php
                            }
                            else
                            {
                        ?>
                            <input type="text" class="col-xs-6 col-sm-6 form-control" name="nickname" value="<?php echo $user['nickname']; ?>"  disabled/>
                        <?php
                            }
                        ?>
                        </div>
                    </div>






<?php
$open = 1;
if($profile['gid'] > 0){
    $_config = $profile['group']['config'];
    if($_config) {
        $config = json_decode($_config, True);

        if(array_key_exists('private_structure', $config) && $config['private_structure'] == 1){
            $open = 0;
        }
    }
}

if(in_array($profile['admin'],[1,3,4])){
    $open = 1;
}
?>

                       <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">默认审批人</label>
                                <div class="col-xs-6 col-sm-6">
<?php
    if($open == 1) {
?>
                                        <select class="col-xs-6 col-sm-6 form-control chosen-select tag-input-style" name="manager" data-placeholder="请选择标签">
<?php 
    } else {
?>
                                        <select class="col-xs-6 col-sm-6 form-control chosen-select tag-input-style" name="manager" data-placeholder="请选择标签" disabled>
<?php
    }
?>
                                    <option value="0" >无</option>
<?php 
    foreach($gmember as $m){
        if($m['id'] == $manager_id)
        {
?>
                                        <option selected value="<?php echo $m['id']; ?>"><?php echo $m['nickname'] . " - [" . $m['email'] . "]"; ?></option>
<?php } else { ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname'] . " - [" . $m['email'] . "]"; ?></option>
<?php
}
    }
?>
                                    </select>
                                </div>
                        </div>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">级别</label>
                                <div class="col-xs-6 col-sm-6">
<?php if(in_array($profile['admin'],[1,3,4])){ ?>
                                    <select class="chosen-select tag-input-style" name="rank" data-placeholder="级别" >
<?php } elseif($self) { ?>
                                    <select class="chosen-select tag-input-style" name="rank" data-placeholder="级别" disabled>
<?php } else { ?>
                                    <select class="chosen-select tag-input-style" name="rank" data-placeholder="级别" disabled>
<?php } ?>
                                        <option value=0>无</option>
<?php 
$rank = $pro['rank_id'];
foreach($ranks as $m){
    if($m['id']==$rank && $rank!=0) {
?>
                                        <option selected value="<?php echo $m['id']; ?>"><?php echo $m['name']; ?></option>
<?php } else { ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['name']; ?></option>
<?php
    }
}

?>
                                    </select>
</div>
</div>

                          <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">职位</label>
                                <div class="col-xs-6 col-sm-6">
<?php 
if(in_array($profile['admin'],[1,3,4])){
?>
                                    <select class="col-xs-6 col-sm-6 chosen-select tag-input-style" name="level" data-placeholder="职位" >
<?php } elseif($self) { ?>
                                    <select class="col-xs-6 col-sm-6 chosen-select tag-input-style" name="level" data-placeholder="职位" disabled>
<?php } else { ?>
                                    <select class="col-xs-6 col-sm-6 chosen-select tag-input-style" name="level" data-placeholder="职位" disabled>
<?php } ?>
                                    <option value=0>无</option>
<?php 
    $level = $pro['level_id'];
    foreach($levels as $m){
        if($m['id']==$level && $level!=0) {
?>
                                        <option selected value="<?php echo $m['id']; ?>"><?php echo $m['name']; ?></option>
<?php } else { ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['name']; ?></option>
<?php
        }
    }

?>
                                    </select>
                                </div>
                        </div>




                        <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">所属帐套</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select class="chosen-select tag-input-style" multiple="multiple" name="sobs[]" data-placeholder="帐套信息" disabled>
<?php 
    $sobs = $pro['sob'];
    foreach($sobs as $m){

?>
                                        <option selected value="<?php echo $m['sob_id']; ?>"><?php echo $m['sob_name']; ?></option>
<?php
    }

?>
                                    </select>
                                </div>
                        </div>

                        <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">所属部门</label>
                                <div class="col-xs-6 col-sm-6">
<?php
    if(in_array($profile['admin'],[1,3])){
?>
                                        <select class="chosen-select tag-input-style" multiple="multiple" name="usergroups[]" data-placeholder="部门信息" >
<?php
    }
    else
    {
?>
                                    <select class="chosen-select tag-input-style" multiple="multiple" name="usergroups[]" data-placeholder="部门信息" disabled>
<?php
    }
?>
<?php 
    $usergroups = $pro['usergroups'];
    $in_groups = array();
    foreach($usergroups as $m){
        array_push($in_groups,$m['id']);
?>
                                        <option selected value="<?php echo $m['id']; ?>"><?php echo $m['name']; ?></option>
<?php
    }
    foreach($ug as $g)
    {
        if(!in_array($g['id'], $in_groups))
        {
            if($profile['admin']!=4)
            {
?>
                                        <option value="<?php echo $g['id']; ?>"><?php echo $g['name']; ?></option>
<?php
            }
            else
            {
                if(in_array($g['id'], $admin_groups_granted))
                {
?>
                                        <option value="<?php echo $g['id']; ?>"><?php echo $g['name']; ?></option>
<?php
                }
            }
        }
    }
?>
                                    </select>
                                </div>
                        </div>

                          <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">提交规则</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select class="chosen-select tag-input-style" multiple="multiple" name="commits[]" data-placeholder="提交规则" disabled>
<?php 
    $commits = $pro['commits'];
    foreach($commits as $m){

?>
                                        <option selected value="<?php echo $m['id']; ?>"><?php echo $m['name']; ?></option>
<?php
    }

?>
                                    </select>
                                </div>
                        </div>

                         <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">审批规则</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select class="chosen-select tag-input-style" multiple="multiple" name="audits[]" data-placeholder="审批规则" disabled>
<?php 
    $audits = $pro['audits'];
    foreach($audits as $m){

?>
                                        <option selected value="<?php echo $m['id']; ?>"><?php echo $m['name']; ?></option>
<?php
    }

?>
                                    </select>
                                </div>
                        </div>




                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right">银行卡号</label>
                        <div class="col-xs-6 col-sm-6">
                            <div class="col-xs-12 col-sm-12 "  style="margin-left:0px !important;padding-left:0px !important;" >
                                <div class="btn-toolbar" id="btns">

<?php 
    foreach($member['banks'] as $b) {
?>
<div class="btn-group" id="bank_<?php echo $b['id']; ?>" > 
    <button data-toggle="dropdown" class="btn btn-primary btn-white dropdown-toggle">
        <?php echo $b['account']; ?>
        <i class="ace-icon fa fa-angle-down icon-on-right"></i> 
    </button> 
    <ul class="dropdown-menu"> 
        <li> <a href="javascript:void(0)" data-id="<?php echo $b['id']; ?>" data-cardtype="<?php echo $b['cardtype']; ?>" data-bankname="<?php echo $b['bankname'];?>"  data-cardno="<?php echo $b['cardno'];?>" data-bankloc="<?php echo $b['bankloc'];?>" 
                data-account="<?php echo $b['account'];?>" data-subbranch="<?php echo $b['subbranch'];?>" data-default="<?php echo $member['credit_card'];?>" class="edit_bank">修改</a> </li>
        <li> <a href="javascript:void(0)" data-id="<?php echo $b['id']; ?>" data-cardtype="<?php echo $b['cardtype']; ?>" data-bankname="<?php echo $b['bankname'];?>"  data-cardno="<?php echo $b['cardno'];?>" data-bankloc="<?php echo $b['bankloc'];?>" 
                data-account="<?php echo $b['account'];?>" data-subbranch="<?php echo $b['subbranch'];?>" data-default="<?php echo $member['credit_card'];?>" class="show_bank">展示</a> </li> 
        <li class="divider"></li> 
        <li> 
        <a href="javascript:void(0)" data-id="<?php echo $b['id']; ?>" data-bankname="<?php echo $b['bankname'];?>"  data-cardno="<?php echo $b['cardno'];?>" data-bankloc="<?php echo $b['bankloc'];?>"  data-account="<?php echo $b['account'];?>" class="del_bank"> 删除</a> 
        </li> 
    </ul> 
</div><!-- /.btn-group -->
<?php 
    }
?>
                                    <div class="btn-group">
                                        <a href="javascript:void(0)" class="btn btn-success new_credit">
                                            <i class="ace-icon fa fa-credit-card icon-only"></i>
                                            添加银行卡
                                        </a>
                                    </div><!-- /.btn-group -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 微信绑定 -->
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right">微信钱包授权</label>
                        <div class="col-xs-6 col-sm-6">
                            <h2 class="weixin-wallet-tip" style="margin: 0;     margin-bottom: 15px; font-size: 11px; line-height: 34px;">支持财务人员将报销费用转账到您的微信钱包</h2>
                            <div id="weixin-wallet">
                                
                                <div style="display: none;" class="weixin-wallet-authorized">
                                    <span class="who"></span>，您已经授权 <a href="javascript:void()">取消授权</a>
                                </div>
                            </div>
                            <p class="weixin-wallet-tip" style="margin: 10px 0; font-size: 11px;">
                                请使用微信扫一扫进行扫码
                                <br>
                                <span style="color: red">＊请确认为本人操作</span>
                            </p> 
                            </div>
                    </div>

<?php 
    if(in_array($profile['admin'], [1,2,3,4])){
?>
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right">角色</label>
                                <div class="col-xs-2 col-sm-2">
                                 <select name="admin_new" id="admin_new" class="chosen-select tag-input-style" <?php if(!in_array($profile['admin'], [1,3])){echo "disabled";}?>> 
                                   <?php
                                            $chara = array(0 => "员工", 
                                                1 => "管理员",
                                                2 => "出纳",
                                                3 => "IT人员",
                                                4 => "部门管理员");
                                            if($profile['admin'] == 3) {
                                                $chara = array(0 => "员工", 
                                                    2 => "出纳",
                                                    3 => "IT人员",
                                                    4 => "部门管理员");
                                            }
                                            foreach($chara as $val => $des) {
                                                //for ($i=0; $i < 4; $i++) { 
                                                $str1 = '<option value="' . $val . '"';
                                                $select = 'selected="true"';
                                                $str2 = '>' . $chara[$val] . "</option>";
                                                if ($val == $member['admin']) {
                                                    echo $str1.$select.$str2;
                                                } else {
                                                    echo $str1.$str2;
                                                }
                                            }
                                    ?>
                                    </select>
                                </div>

                              <div class="col-xs-4 col-sm-4" id="cashier_view" hidden>
                                <select name="admin_groups_granted[]" id="admin_groups_granted" multiple="multiple" class="chosen-select tag-input-style" data-placeholder="请选择部门" <?php if($profile['admin']!=1){ echo "disabled";}?>> 
                             <?php
                                $groups_granted = array();
                                if($pro && array_key_exists('admin_groups_granted', $pro))
                                {
                                    $groups_granted = explode(',',$pro['admin_groups_granted']);
                                }
                
                            ?>
                            <?php
                                if(in_array(0, $groups_granted))
                                {
                            ?>
                                    <option selected value='0'>公司</option>
                            <?php
                                } else {
                            ?>
                                    <option value='0'>公司</option>
                            <?php
                                }
                            ?>
                            <?php

                                 foreach($ug as $g)
                                 {
                                    if(in_array($g['id'], $groups_granted))
                                    {
                            ?>
                                     <option selected value="<?php echo $g['id']; ?>"><?php echo $g['name']; ?></option>
                            <?php
                                    }
                                    else
                                    {
                             ?>
                                     <option value="<?php echo $g['id']; ?>"><?php echo $g['name']; ?></option>
                             <?php 
                                    }
                                }
                             ?>
                                 </select>
                              </div>
                    </div>
<?php 
}
?>

                    <input type="hidden" name="admin_old" value="<?php echo $member['admin']; ?>" type="hidden" />


                    <div class="clearfix form-actions col-md-8">
                        <div class="col-md-offset-3 col-md-12">
                        <?php if ($self) {?>
                            <a class="btn btn-white btn-primary password" data-renew="1"><i class="ace-icon fa fa-key"></i>修改密码</a>
                        <?php } ?>
                            <a class="btn btn-white btn-default renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>


<input type="file" style="display:none;" id="src" name="file" data-url="<?php echo base_url('items/avatar'); ?>" data-form-data='{"type": "1"}'>

<div class="modal fade" id="select_img_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">选择图片</h4>
            </div>
            <div class="modal-body">
                <div id="div_thumbnail" class="thumbnail" style="display:none;">
                    <img src="/static/images/loading.gif">
                </div>
                <a class="btn btn-primary btn-white" id="mbtn_cimg" >选择图片</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="phone_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">修改手机号</h4>
            </div>
            <div class="modal-body">
            
                <form id="phone_form" class="form-horizontal" role="form" method="post" action="<?php echo base_url('users/update_phone'); ?>">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <?php
                                $updateWithoutVCode = false;

                                if(isset($user_type) == false) {
                                    $updateWithoutVCode = false;
                                } else if($user_type == 1 && !$is_self) {
                                    $updateWithoutVCode = true;
                                }
                                $visibilityStyle = '';
                                if($updateWithoutVCode) {
                                    $visibilityStyle = 'display: none';
                                }

                            ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">手机号</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input name="phone" type="text" class="form-controller col-xs-7" minlength="11" maxlength="11" id="phone" placeholder="新手机号" />
                                <a href="javascript:void(0)" style="margin-left:5px; <?php echo $visibilityStyle; ?>" class="btn btn-primary btn-sm getvcode" >获取验证码</a>
                                </div>
                            </div>

                            <div class="form-group" style="<?php echo $visibilityStyle; ?>">
                                <label class="col-sm-2 control-label no-padding-right">验证码</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input name="vcode" id="vcode" type="text" class="form-controller col-xs-12 br3 inp" placeholder="验证码" />
                                </div>
                            </div>

                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <a data-nocode="<?php echo $updateWithoutVCode; ?>" class="btn btn-white btn-primary update_phone" data-renew="0"><i class="ace-icon fa fa-save "></i>修改</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- update user email start-->
<div class="modal fade" id="modalUpdateEmail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">修改邮箱</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <label class="col-sm-2 control-label align-right">新邮箱</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control email" placeholder="新邮箱">
                    </div>
                    
                    <div class="col-sm-2 align-right" style="<?php echo $visibilityStyle; ?>">
                        <button class="btn-get-email-code btn btn-primary btn-sm" type="submit">发送验证码</button>
                    </div>
                    
                </div>
                <br>
                
                <div class="row" style="<?php echo $visibilityStyle; ?>">
                    <label class="col-sm-2 control-label align-right">验证码</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control vcode" placeholder="验证码">
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn-bind-email btn btn-primary">修改</button>
            </div>
        </div>
    </div>
</div>
<!-- update user email end -->

<div class="modal fade" id="credit_model">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_title">添加银行卡</h4>
            </div>
            <div class="modal-body">
                <form id="password_form" class="form-horizontal" role="form" method="post" action="<?php echo base_url('users/new_credit'); ?>">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">户名</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input id="account" name="account" type="text" class="form-controller col-xs-12" placeholder="户名" />
                                    <input id="id" name="id" type="hidden" value="" />
                                    <input id="uid" name="uid" type="hidden" value="<?php echo $pid;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">卡号</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input id="cardno" name="cardno" type="text" class="form-controller col-xs-12" placeholder="卡号" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">开卡行</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select id="cardbank" name="cardbank" class="form-control" data-placeholder="请输入或者选择银行">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">卡类型</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select id="bankCardType" name="cardtype" class="form-control" data-placeholder="请选择卡类型">
                                        <option selected value="">请选择卡类型</option>
                                        <option value="0">借记卡</option>
                                        <option value="1">信用卡</option>
                                        <option value="2">其它</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">开户地</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select name="province" id="province">
                                    </select>
                                    <select name="city" id="city">
                                        <option>北京市</option>
                                    </select>
                                    <input id="cardloc" name="cardloc" type="hidden" class="form-controller col-xs-12 br3 inp" placeholder="开户地" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">支行</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input id="subbranch" name="subbranch" type="text" class="form-controller col-xs-12" placeholder="支行" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">默认账户</label>
                                <div class="col-xs-6 col-sm-6">
                                 <!--   <input type="text" placeholder="组名称" class="col-xs-12" required="required" name="gname"> -->
                                   <!-- <div class="col-xs-12 col-sm-12 col-md-12"> -->
                                        <label style="margin-top:8px;">
                                            <input name="is_default" class="ace ace-switch btn-rotate" type="checkbox" id="is_default" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>

                                   <!-- </div> -->
                                </div>
                            </div>

                            <input type="hidden" name="defualt_id" id="default_id" />


                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <a class="btn btn-white btn-primary new_card" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>

                                    <a style="margin-left: 80px;" class="btn btn-white cancel" id="credit_cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                                </div>
                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="loading">
                    <img src="/static/images/loading.gif">
</div>

<!--  <script src="/static/third-party/jfu/js/vendor/jquery.ui.widget.js"></script> -->
<!--  <script src="/static/third-party/jfu/js/jquery.iframe-transport.js"></script> -->
<!-- <script src="/static/third-party/jfu/js/jquery.uploadfile.min.js"></script> -->
<link rel="stylesheet" type="text/css" href="/static/third-party/webUploader/webuploader.css">

<!--引入JS-->
<script type="text/javascript" src="/static/third-party/webUploader/webuploader.js"></script>


<script type="text/javascript">$(window).load(function(){$("#loading").hide();})</script>
<!--
<script src="/static/third-party/jfu/js/vendor/jquery.ui.widget.js"></script>
<script src="/static/third-party/jfu/js/jquery.iframe-transport.js"></script> -->
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/js/libs/qrcodejs.min.js"></script>
<script src="/static/third-party/jfu/js/jquery.uploadfile.min.js"></script> 
<script src="/static/js/libs/underscore-min.js"></script> 
<script src="/static/js/widgets/input-suggestion.js"></script>
<script src="/static/plugins/cloud-dialog/dialog.js"></script>
<link rel="stylesheet" href="/static/plugins/cloud-dialog/dialog.css">
<script>
    var __BASE = "<?php echo $base_url; ?>";
    var flag = 0;
    var is_other = "<?php echo $isOther; ?>";
    var user_id = "<?php echo $pid;?>";

    function show_loading(){
        $('#loading').show();
    }

    function close_loading(){
        $('#loading').hide();
        //$.nmTop().close();
    }
    if(is_other == 0) {
        var uploader = WebUploader.create({
            // 选完文件后，是否自动上传。
            auto: true,
                // swf文件路径
                swf: '/static/third-party/webUploader/Uploader.swf',
                // 文件接收服务端。
                server: '<?php echo base_url('items/images'); ?>',
                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '.filePicker',
                // 只允许选择图片文件。
                accept: {
                    title: 'Images',
                        extensions: 'gif,jpg,jpeg,bmp,png',
                        mimeTypes: 'image/*'
                }

        });

        uploader.on( 'uploadProgress', function( file, percentage ) {
            show_loading();
        });
        uploader.on( 'uploadSuccess', function( file, resp ) {
            close_loading();
            if(resp.status > 0) {
                var _id = resp['data']['id'];
                var _src = resp['data']['url'];
                $('#avatar').val(_id);
                $('#avatar_src').attr( 'src', _src);
            }
        });
    }



    var __PROVINCE = Array();
    var _ifCreateCard = true;
    function get_province(){
        $.ajax({
            url : __BASE + "static/province.json",
                dataType : 'json',
                method : 'GET',
                success : function(data){
                    __PROVINCE = data;
                    $(data).each(function(idx, item){
                        var _h = "<option value='" +  item.name + "'>"+  item.name + " </option>";
                        $('#province').append(_h);
                    });
                }
        });
        $('#province').change(function(){
            var _p = $(this).val();
            $('#city').html('');
            $(__PROVINCE).each(function(idx, item) {
                if(item.name == _p){
                    $(item.city).each(function(_idx, _item){
                        var _h = "<option value='" +  _item + "'>"+  _item + " </option>";
                        $('#city').append(_h);
                    });
                }
            });
        });
    }

    function reset_bank(disable, title) {
        if(!disable) {
            $('.new_card').hide();
            $('#account').attr("disabled",  true);
            $('#cardloc').attr("disabled",  true);
            $('#cardno').attr("disabled",   true);
            $('#cardbank').attr("disabled", true).trigger("chosen:updated");
            $('#subbranch').attr("disabled",true);
            $('#is_default').attr("disabled",true);
            $('#bankCardType').attr('disabled', true);
        } else {
            $('.new_card').show();
            $('#account').attr("disabled",  false);
            $('#cardloc').attr("disabled",  false);
            $('#cardno').attr("disabled",   false);
            $('#cardbank').attr("disabled", false).trigger("chosen:updated");
            $('#subbranch').attr("disabled",false);
            $('#is_default').attr("disabled",false);
            $('#bankCardType').attr('disabled', false);
        }
        title && $('#credit_model').find('.modal-title').text(title);
        $('.cancel').click(function(){
            $('#credit_model').modal('hide');
        });
    }
    var __self = "<?php echo $self; ?>";
    var __error = "<?php echo $error; ?>";


    function del_credit(node){
        var _id = $(node).data('id');
        //var _uid = $(node).data('uid');
        $.ajax({
            url : __BASE + "users/del_credit/"  + _id + "/" + user_id,
                dataType : 'json',
                method : 'GET',
                success : function(data){
                    $('#bank_' + _id).remove();
                    show_notify('银行卡删除成功');
                }
        });
    }


    function update_credit(node){
        _ifCreateCard = false;
        reset_bank(1, '修改银行卡');
        $('#id').val($(node).data('id'));
        $('#account').val($(node).data('account'));
        $('#cardbank').val($(node).data('bankname')).trigger("chosen:updated");
        $('#cardloc').val($(node).data('bankloc'));
        $('#cardno').val($(node).data('cardno'));
        $('#subbranch').val($(node).data('subbranch'));
        $('#bankCardType').val($(node).data('cardtype'));
        $('#default_id').val($(node).data('default'));
        var _is_default = $(node).data('default');
        if(_is_default == $(node).data('id'))
        {
            $('#is_default').prop('checked',true);
            $('#is_default').trigger('chosen:updated');
        }
        else
        {
            $('#is_default').prop('checked',false);
            $('#is_default').trigger('chosen:updated');
        }
        $('#credit_model').modal('show');
        var i = 1, loc = $(node).data('bankloc');

        do {
            i += 1;
            $('select[name="province"]').val(loc.substr(0,i));
            if(i>loc.length+1)
            {
                break;
            }
        } while ($('select[name="province"]').val() == null); 
        /*for(var i=1;i<=loc.length+1;i++)
            {
             $('select[name="province"]').val(loc.substr(0,i));
                        }*/
                        var city = loc.substr(i);
                    $('select[name="province"]').change();
                    $('select[name="city"]').val(city);
    }

    function show_credit(node){
        reset_bank(0, '银行卡详情');
        _ifCreateCard = false;
        $('#id').val($(node).data('id'));
        $('#account').val($(node).data('account'));
        $('#cardbank').val($(node).data('bankname')).trigger("chosen:updated");
        $('#cardloc').val($(node).data('bankloc'));
        $('#cardno').val($(node).data('cardno'));
        $('#bankCardType').val($(node).data('cardtype'));
        $('#subbranch').val($(node).data('subbranch'));
        var _is_default = $(node).data('default');
        if(_is_default == $(node).data('id'))
        {
            $('#is_default').prop('checked',true);
            $('#is_default').trigger('chosen:updated');
        }
        else
        {
            $('#is_default').prop('checked',false);
            $('#is_default').trigger('chosen:updated');
        }
        $('#credit_model').modal('show');
        var i = 1, loc = $(node).data('bankloc');
        do {
            i += 1;
            $('select[name="province"]').val(loc.substr(0,i));
            if(i>loc.length+1)
            {
                break;
            }
        } while ($('select[name="province"]').val() == null);
        var city = loc.substr(i);
        $('select[name="province"]').change();
        $('select[name="city"]').val(city);
    }

    function bind_event(){
        $('.del_bank').click(function(){
            del_credit(this);
        });

        $('.show_bank').click(function(){
            show_credit(this);
        });

        $('.edit_bank').click(function(){
            update_credit(this);
        });


    }


    $(document).ready(function(){
        get_province();
        if(__error) show_notify(__error);
        $('.chosen-select').each(function(){
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


        $('.avatar').click(function(){
            if(0 == __self) return false;
            $('#btn_cimg').show();
            $('#select_img_modal').modal({keyborard: false});
        });

        $('.renew').click(function(){
            $('#profile_form').submit();
        });

        var flag = 0;
        $('#admin_new').change(function(){
            var admin_type_id = $('#admin_new').val();
            if(admin_type_id == 2 || admin_type_id == 4)
            {
                if(admin_type_id == 2 && flag)
                {
                    $('#admin_groups_granted').val([0]).prop('selected',true).trigger('chosen:updated');
                }
                else if(admin_type_id == 4 && flag)
                {
                    $('#admin_groups_granted').val([]).prop('selected',true).trigger('chosen:updated');
                }
                $('#cashier_view').prop('hidden',false).trigger('chosen:updated');
            }
            else
            {
                $('#cashier_view').prop('hidden',true).trigger('chosen:updated');
            }
            flag = 1;
        });
        $('#admin_new').trigger('change');
        $('#admin_new').trigger('change:updated');
        /*
    $('#btn_cimg').click(function(){
        $('#src').click();
    });
                         */
                        $('.password').click(function(){
                            $('#security_reset').modal({keyborard: false});
                        });
                        $('.update_phone').click(function(){
                        //$('#phone_form').submit();
                        var _phone = $('#phone').val();
                        var _vcode = $('#vcode').val();
                        var _self = this;

                        if(!/^1\d{10}$/.test(_phone)) {
                            return show_notify('请输入合法的手机号');
                        }

                        $.ajax({
                            url:__BASE+"users/update_phone",
                                method:"POST",
                                dataType:"json",
                                data:{'phone':_phone,'vcode':_vcode, uid: user_id},
                                success:function(data){
                                    if(data.status==0 || data.status=='false')
                                    {
                                        show_notify(data.data.msg);
                                    } else if(data.status == 1) {
                                        return window.location.reload();
                                    }
                                }
                        });
                    });

                    $('.change_phone').click(function(){
                        $('#phone_modal').modal({keyborard: false});
                    });
                    $('.getvcode').click(function(){
                        var _phone = $('#phone').val();

                        if(_phone.length!=11) {
                            return show_notify('请输入11位手机号码');
                        }

                        if(!/^(1)[0-9]{10,10}/.test(_phone)) {
                            return show_notify('请输入合法的手机号');
                        }

                        $.ajax({
                            url : __BASE + "users/getvcode",
                                data : {'phone' : _phone},
                                dataType : 'json',
                                method : 'POST',
                                success : function(data){
                                    if(data.status){
                                        //TODO: 设置定时器
                                        $('.gitvcode').hide();
                                        show_notify('验证码已经发送');
                                    } else {
                                        show_notify(data.data.msg);
                                    }
                                }
                        });
                    });
                    $('.new_credit').click(function(){
                        if (!_ifCreateCard) {
                            $('#modal_title').val();
                            $('#account' ).val("");
                            $('#id' ).val("");
                            $('#uid').val(user_id);
                            $('#cardloc' ).val("");
                            $('#cardno'  ).val("");
                            $('#cardbank').val("").trigger("chosen:updated");
                            $('#default_id').val("");
                        }
                        _ifCreateCard = true;
                        reset_bank(1, '添加新银行卡');
                        $('#credit_model').modal({keyborard: false});
                    });
                    $('.new_card').click(function(){
                        var _p = $('#province').val();
                        var _c = $('#city').val();
                        var _account = $('#account').val();
                        var _bank = $('#cardbank').val();
                        var _no = $('#cardno').val();
                        var _loc = _p + _c;//$('#cardloc').val();
                        var _id = $('#id').val();
                        var _subbranch = $('#subbranch').val();
                        var _card_type = $('#bankCardType').val();
                        var _default_id = $('#default_id').val();
                        var _default = ($('#is_default').is(':checked') ? 1:0);
                        if(_card_type==='') {
                            return show_notify('请选择卡类型');
                        }
                        if(_default == 1) {
                            _default_id = _id;
                        }
                        else if(_default_id == _id) {
                                _default_id = 0;
                        }
                        if (_account == "") {
                            show_notify('请输入户名');
                            $('#account').focus();
                            return false;
                        };
                        if (_no.length < 12) {
                            show_notify('请输入正确银行卡号');
                            $('#cardno').focus();
                            return false;
                        };
                        
                        if (_bank == "" || _bank == null || _bank == undefined) {
                            show_notify('请选择银行卡开户行');
                            $('#cardbank').focus();
                            return false;
                        };
                        
                        $.ajax({
                            url : __BASE + "users/new_credit",
                                data : {
                                    'account' : _account
                                        ,'cardbank' : _bank
                                        ,'cardno' : _no
                                        ,'cardloc' :  _loc
                                        ,'id' :  _id
                                        ,'uid' : user_id
                                        ,'cardtype' : _card_type
                                        ,'subbranch':_subbranch
                                        ,'default':_default
                                },
                                dataType : 'json',
                                method : 'POST',
                                success : function(data){
                                    if(data.status){
                                        _ifCreateCard = false;
                                        var _id = data.data.id;
                                        $('#credit_model').modal('hide');
                                        if(_id > 0){
                                            $('#bank_' + _id).remove();
                                        }
                                        var buf = '<div class="btn-group" id="bank_' + _id + '"> '
                                            + '<button data-toggle="dropdown" class="btn btn-primary btn-white dropdown-toggle">' 
                                            + _account 
                                            + '<i class="ace-icon fa fa-angle-down icon-on-right"></i> </button>'
                                            + '<ul class="dropdown-menu"> '
                                            + '<li> <a href="javascript:void(0)" data-cardtype="' + _card_type +'"  data-id="' + _id + '" data-bankname="' + _bank + '"  data-cardno="' + _no + '" data-bankloc="' + _loc+ '"  data-account="' + _account + '" data-subbranch="' + _subbranch + '"' + ' data-default="' + _default_id + '"' +' class="edit_bank" >修改</a> </li>'
                                            + '<li> <a  href="javascript:void(0)" data-cardtype="' + _card_type +'" data-id="' + _id + '" data-bankname="' + _bank + '"  data-cardno="' + _no + '" data-bankloc="' + _loc+ '"  data-account="' + _account + '" data-subbranch="' + _subbranch + '"' + ' data-default="' + _default_id + '"' +'  class="show_bank">展示</a> </li> '
                                            + '<li class="divider"></li> '
                                            + '<li> <a href="javascript:void(0)" data-uid="' + user_id + '" data-id="' + _id + '" data-bankname="' + _bank + '"  data-cardno="' + _no + '" data-bankloc="' + _loc+ '"  data-account="' + _account + '" class="del_bank">删除</a> </li>'
                                            + ' </ul> </div>';
                                        $('#btns').prepend(buf);
                                        bind_event();
                                        show_notify('银行卡添加成功');
                                        $('#modal_title').val();
                                        $('#account' ).val("");
                                        $('#id' ).val("");
                                        $('#uid').val(user_id);
                                        $('#cardloc' ).val("");
                                        $('#cardno'  ).val("");
                                        $('#cardbank').val("").trigger("chosen:updated");
                                        $('#default_id').val("");
                                    } else {
                                        show_notify(data.data.msg);
                                    }
                                },
                                    error: function (){
                                        show_notify('操作失败，请稍后尝试');
                                    }
                        });
                    });

                    bind_event();
                    $('#setadmin').change(function(){
                        var _admin = $('#setadmin').is(':checked') ? 0 : 1;
                        var uid = $('#uid').val();
                        $.ajax({
                            url: __BASE + "/members/setadmin/" + uid + "/" + _admin,
                                method: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    if(!data.status ) {
                                        show_notify(data.data.msg);
                                    }
                                },
                                    error: function(data) {
                                        show_notify('设置用户信息失败');
                                    }
                        });
                    });
    new InputSuggestion('#cardbank', {
        onDataLoaded: function(data) {
            var BANK_CODE = (function changeBankDataToMap(argument) {
                var bankMap = {};
                for (var name in data) {
                    var prefixArray = data[name];
                    for (var i = 0; i < prefixArray.length; i++) {
                        bankMap[prefixArray[i]] = name;
                    }
                }
                return bankMap;
            })(data);
            $("#cardno").keyup(function(e) {
                var value = this.value;
                if (value.length < 6) {
                    return;
                }
                value = value.substring(0, 6);
                if (BANK_CODE[value] != undefined) {
                    $('#cardbank').val(BANK_CODE[value]);
                    $('#cardbank').trigger("chosen:updated");
                };
            });
        }
    });

    });

    function unbindWeixinPay() {
        return Utils.api('giro_auth/rescind_wxauth', {
            method: 'post',
            env: 'miaiwu',
        }).done(function (rs) {
            if(rs['status']<=0) {
                return
            }
            window.location.reload();
        });
    };


    // 添加二维码
    // giro_auth/employee_wechat_info
    Utils.api('giro_auth/employee_wxpub_payhead_info', {
        env: 'miaiwu'
    }).done(function (rs) {
        if(rs['status']<=0) {
            return $("#weixin-wallet").text(rs['data']['msg']);
        }
        var data = rs['data'];
        if(!data['company_opened']) {  //企业未开通
            $("#weixin-wallet").parent().remove();
            console.log('企业未开通');
            return
        } else if(data['company_opened']) { //企业开通
            if(data['employee_opened']) {
                $("#weixin-wallet .who").text(data['wx_nickname']);
                $(".weixin-wallet-authorized").show();
                $('.weixin-wallet-tip').hide();
                $(".weixin-wallet-authorized a").on('click', function  (e) {
                    var dialog = new CloudDialog({
                        content: "确认取消授权？",
                        ok: function () {
                            unbindWeixinPay();
                        }
                    });
                    dialog.showModal();
                });
            } else {
                var qrcode = new QRCode(document.getElementById("weixin-wallet"), {
                    // text: "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx068349d5d3a73855&redirect_uri=http%3A%2F%2Fdadmin.cloudbaoxiao.com%2Fmobile%2Fwallet&response_type=code&scope=snsapi_userinfo&state=STATE&connect_redirect=1#wechat_redirect",
                    text:data['auth_url'],
                    width: 128,
                    height: 128,
                    colorDark : "#ff575b",
                    colorLight : "#fff",
                    correctLevel : QRCode.CorrectLevel.M
                });
            }
        }
    });
    
</script>
<script src="<?= static_url("/static/js/mod/user/profile.js") ?>"></script>