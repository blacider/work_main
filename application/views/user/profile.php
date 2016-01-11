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
</style>
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />
<script type="text/javascript" src="/static/js/bank_code.json"></script>
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

<!--avatar_container <a id="btn_cimg" style="height:140px;width:140px" href="javascript:void(0)" class="avatar thumbnail"> btn btn-primary btn-white-->
                          <a id="btn_cimg" class="filePicker"  style="height:144px;width:155px" class="btn btn-primary btn-white">
                            <input type="hidden" id="avatar" name="avatar" value="<?php echo $user['avatar']; ?>" />
                            <img src="<?php echo $user['avatar_url'];?>" style="height:130px;width:130px" id="avatar_src" /> </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right">邮箱</label>
                        <div class="col-xs-6 col-sm-6">
<?php
if($self != 1) {
?>
<input type='hidden' id="uid" name='uid' value="<?php echo $user['id']; ?>">
<?php
}
?>
                            <!-- <input type="hidden" name="email" value="<?php echo $user['email']; ?>"> -->
                            <!-- <input type="text" class="col-xs-6 col-sm-6 form-control" value="<?php echo $user['email']; ?>" /> -->
                <input type="text" name="email" class="col-xs-6 col-sm-6 form-control" value="<?php echo $user['email']; ?>">
                <!-- <label class="control-label"><?php echo $user['email']; ?></label> -->
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
        <li> <a href="javascript:void(0)" data-id="<?php echo $b['id']; ?>" data-bankname="<?php echo $b['bankname'];?>"  data-cardno="<?php echo $b['cardno'];?>" data-bankloc="<?php echo $b['bankloc'];?>" 
                data-account="<?php echo $b['account'];?>" data-subbranch="<?php echo $b['subbranch'];?>" data-default="<?php echo $member['credit_card'];?>" class="edit_bank">修改</a> </li>
        <li> <a href="javascript:void(0)" data-id="<?php echo $b['id']; ?>" data-bankname="<?php echo $b['bankname'];?>"  data-cardno="<?php echo $b['cardno'];?>" data-bankloc="<?php echo $b['bankloc'];?>" 
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
                                if($pro && array_key_exists('admin_groups_granted', $pro) && $pro['admin_groups_granted'])
                                {
                                    $groups_granted = explode(',',$pro['admin_groups_granted']);
                                }
                
                            ?>
                                    <option value='0'>公司</option>
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

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">手机号</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input name="phone" type="text" class="form-controller col-xs-7" id="phone" placeholder="新手机号" />
                                <a href="javascript:void(0)" style="margin-left:5px;" class="btn btn-primary btn-sm getvcode" >获取验证码</a>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">验证码</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input name="vcode" id="vcode" type="text" class="form-controller col-xs-12 br3 inp" placeholder="验证码" />
                                </div>
                            </div>

                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <a class="btn btn-white btn-primary update_phone" data-renew="0"><i class="ace-icon fa fa-save "></i>修改并登出</a>

                                </div>
                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



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
                                    <input id="cardno" maxlength="25" name="cardno" type="text" class="form-controller col-xs-12" placeholder="卡号" />
                                </div>
                            </div>
                            <script type="text/javascript">
                            $(document).ready(function() {
                                $("#cardno").keyup(function(event) {
                                    var value = this.value;
                                    if (value >= 6) {
                                        value = value.substring(0,6);
                                    };
                                    if (BANK_CODE[value] != undefined) {
                                        $("#cardbank").val(BANK_CODE[value]);
                                    };
                                });
                            });
                            </script>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">开卡行</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select id="cardbank" name="cardbank" class="form-control">
                                        <option value='工商银行'>工商银行</option>
                                        <option value='农业银行'>农业银行</option>
                                        <option value='中国银行'>中国银行</option>
                                        <option value='建设银行'>建设银行</option>
                                        <option value='招商银行'>招商银行</option>
                                        <option value='平安银行'>平安银行</option>
                                        <option value='交通银行'>交通银行</option>
                                        <option value='中信银行'>中信银行</option>
                                        <option value='兴业银行'>兴业银行</option>
                                        <option value='光大银行'>光大银行</option>
                                        <option value='民生银行'>民生银行</option>
                                        <option value='华夏银行'>华夏银行</option>
                                        <option value='广发银行'>广发银行</option>
                                        <option value='北京银行'>北京银行</option>
                                        <option value='广州银行'>广州银行</option>
                                        <option value='晋商银行'>晋商银行</option>
                                        <option value='九江银行'>九江银行</option>
                                        <option value='锦州银行'>锦州银行</option>
                                        <option value='江苏银行'>江苏银行</option>
                                        <option value='中国邮政储蓄银行'>中国邮政储蓄银行</option>
                                        <option value='浦东发展银行'>上海浦东发展银行</option>
                                        <option value='D.F.S.I'>D.F.S.I</option>
                                        <option value='金华市商业银行'>金华市商业银行</option>
                                        <option value='徐州市郊农村信用合作联社'>徐州市郊农村信用合作联社</option>
                                        <option value='花旗银行有限公司'>花旗银行有限公司</option>
                                        <option value='兰州市商业银行'>兰州市商业银行</option>
                                        <option value='天津市商业银行'>天津市商业银行</option>
                                        <option value='威海市商业银行'>威海市商业银行</option>
                                        <option value='宁波市商业银行'>宁波市商业银行</option>
                                        <option value='高要市农村信用合作社联合社'>高要市农村信用合作社联合社</option>
                                        <option value='曲靖市商业银行'>曲靖市商业银行</option>
                                        <option value='营口市商业银行'>营口市商业银行</option>
                                        <option value='永亨银行'>永亨银行</option>
                                        <option value='重庆市商业银行'>重庆市商业银行</option>
                                        <option value='中国银行澳门分行'>中国银行澳门分行</option>
                                        <option value='陕西省农村信用社联合社'>陕西省农村信用社联合社</option>
                                        <option value='大西洋银行股份有限公司'>大西洋银行股份有限公司</option>
                                        <option value='常熟农村商业银行'>常熟农村商业银行</option>
                                        <option value='淮安市商业银行'>淮安市商业银行</option>
                                        <option value='嘉兴市商业银行'>嘉兴市商业银行</option>
                                        <option value='AEON信贷财务'>AEON信贷财务</option>
                                        <option value='江苏农信'>江苏农信</option>
                                        <option value='广州农村信用合作社联合社'>广州农村信用合作社联合社</option>
                                        <option value='东莞农村信用合作社'>东莞农村信用合作社</option>
                                        <option value='福州市商业银行'>福州市商业银行</option>
                                        <option value='长春市商业银行'>长春市商业银行</option>
                                        <option value='厦门市商业银行'>厦门市商业银行</option>
                                        <option value='南洋商业银行'>南洋商业银行</option>
                                        <option value='辽阳市商业银行'>辽阳市商业银行</option>
                                        <option value='湖州市商业银行'>湖州市商业银行</option>
                                        <option value='大同市商业银行'>大同市商业银行</option>
                                        <option value='东莞市商业银行'>东莞市商业银行</option>
                                        <option value='莱芜市商业银行'>莱芜市商业银行</option>
                                        <option value='吴江农村商业银行'>吴江农村商业银行</option>
                                        <option value='恒丰银行'>恒丰银行</option>
                                        <option value='哈尔滨市商业银行'>哈尔滨市商业银行</option>
                                        <option value='桂林市商业银行'>桂林市商业银行</option>
                                        <option value='温州商业银行'>温州商业银行</option>
                                        <option value='廖创兴银行有限公司'>廖创兴银行有限公司</option>
                                        <option value='天津市农村信用社'>天津市农村信用社</option>
                                        <option value='中外合资.南充市商业银行'>中外合资.南充市商业银行</option>
                                        <option value='廊坊市商业银行'>廊坊市商业银行</option>
                                        <option value='临沂市商业银行'>临沂市商业银行</option>
                                        <option value='绵阳市商业银行'>绵阳市商业银行</option>
                                        <option value='台州市商业银行'>台州市商业银行</option>
                                        <option value='成都农信社'>成都农信社</option>
                                        <option value='深圳市商业银行'>深圳市商业银行</option>
                                        <option value='烟台市商业银行'>烟台市商业银行</option>
                                        <option value='阜新市商业银行'>阜新市商业银行</option>
                                        <option value='成都商业银行'>成都商业银行</option>
                                        <option value='西安市商业银行'>西安市商业银行</option>
                                        <option value='丹东商行'>丹东商行</option>
                                        <option value='江苏农信社'>江苏农信社</option>
                                        <option value='南京市商业银行'>南京市商业银行</option>
                                        <option value='三门峡市城市信用社'>三门峡市城市信用社</option>
                                        <option value='沈阳市商业银行'>沈阳市商业银行</option>
                                        <option value='西宁农商银行'>西宁农商银行</option>
                                        <option value='浙江省农村信用社联合社'>浙江省农村信用社联合社</option>
                                        <option value='星展银行'>星展银行</option>
                                        <option value='绍兴商业银行'>绍兴商业银行</option>
                                        <option value='深圳农信社'>深圳农信社</option>
                                        <option value='连云港市商业银行'>连云港市商业银行</option>
                                        <option value='杭州商业银行'>杭州商业银行</option>
                                        <option value='武进农村商业银行'>武进农村商业银行</option>
                                        <option value='太仓农村商业银行'>太仓农村商业银行</option>
                                        <option value='乌鲁木齐市商业银行'>乌鲁木齐市商业银行</option>
                                        <option value='湖北农信社'>湖北农信社</option>
                                        <option value='沧州农信社'>沧州农信社</option>
                                        <option value='泉州市商业银行'>泉州市商业银行</option>
                                        <option value='镇江市商业银行'>镇江市商业银行</option>
                                        <option value='武汉市商业银行'>武汉市商业银行</option>
                                        <option value='常熟市农村商业银行'>常熟市农村商业银行</option>
                                        <option value='深圳发展银行'>深圳发展银行</option>
                                        <option value='徐州市商业银行'>徐州市商业银行</option>
                                        <option value='绍兴市商业银行'>绍兴市商业银行</option>
                                        <option value='渤海银行'>渤海银行</option>
                                        <option value='常州商业银行'>常州商业银行</option>
                                        <option value='佛山市禅城区农村信用联社'>佛山市禅城区农村信用联社</option>
                                        <option value='潍坊商业银行'>潍坊商业银行</option>
                                        <option value='江苏东吴农村商业银行'>江苏东吴农村商业银行</option>
                                        <option value='徽商银行淮北分行'>徽商银行淮北分行</option>
                                        <option value='鞍山市商业银行'>鞍山市商业银行</option>
                                        <option value='无锡市商业银行'>无锡市商业银行</option>
                                        <option value='东亚银行有限公司'>东亚银行有限公司</option>
                                        <option value='济南市商业银行'>济南市商业银行</option>
                                        <option value='珠海市商业银行'>珠海市商业银行</option>
                                        <option value='贵州省农村信用社联合社'>贵州省农村信用社联合社</option>
                                        <option value='徽商银行安庆分行'>徽商银行安庆分行</option>
                                        <option value='澳门国际银行'>澳门国际银行</option>
                                        <option value='泸州市商业银行'>泸州市商业银行</option>
                                        <option value='澳门永亨银行股份有限公司'>澳门永亨银行股份有限公司</option>
                                        <option value='柳州市商业银行'>柳州市商业银行</option>
                                        <option value='焦作市商业银行'>焦作市商业银行</option>
                                        <option value='石家庄市商业银行'>石家庄市商业银行</option>
                                        <option value='银川市商业银行'>银川市商业银行</option>
                                        <option value='上海银行'>上海银行</option>
                                        <option value='大丰银行有限公司'>大丰银行有限公司</option>
                                        <option value='扬州市商业银行'>扬州市商业银行</option>
                                        <option value='深圳市农村信用合作社联合社'>深圳市农村信用合作社联合社</option>
                                        <option value='福建省农村信用社联合社'>福建省农村信用社联合社</option>
                                        <option value='贵阳市商业银行'>贵阳市商业银行</option>
                                        <option value='大庆市商业银行'>大庆市商业银行</option>
                                        <option value='青岛商行'>青岛商行</option>
                                        <option value='佛山市三水区农村信用合作社'>佛山市三水区农村信用合作社</option>
                                        <option value='南通市商业银行'>南通市商业银行</option>
                                        <option value='南宁市商业银行'>南宁市商业银行</option>
                                        <option value='徽商银行芜湖分行'>徽商银行芜湖分行</option>
                                        <option value='北京农联社'>北京农联社</option>
                                        <option value='深圳农联社'>深圳农联社</option>
                                        <option value='徽商银行'>徽商银行</option>
                                        <option value='哈萨克斯坦国民储蓄银行'>哈萨克斯坦国民储蓄银行</option>
                                        <option value='大连市商业银行'>大连市商业银行</option>
                                        <option value='Travelex'>Travelex</option>
                                        <option value='山东农村信用联合社'>山东农村信用联合社</option>
                                        <option value='杭州市商业银行'>杭州市商业银行</option>
                                        <option value='江苏锡州农村商业银行'>江苏锡州农村商业银行</option>
                                        <option value='珠海农村信用合作社联社'>珠海农村信用合作社联社</option>
                                        <option value='江门市新会农信社'>江门市新会农信社</option>
                                        <option value='淄博市商业银行'>淄博市商业银行</option>
                                        <option value='张家港市农村商业银行'>张家港市农村商业银行</option>
                                        <option value='洛阳市商业银行'>洛阳市商业银行</option>
                                        <option value='湛江市商业银行'>湛江市商业银行</option>
                                        <option value='苏州市商业银行'>苏州市商业银行</option>
                                        <option value='宜昌市商业银行'>宜昌市商业银行</option>
                                        <option value='上海市农村信用合作社联合社'>上海市农村信用合作社联合社</option>
                                        <option value='重庆市农村信用社联合社'>重庆市农村信用社联合社</option>
                                        <option value='美国银行'>美国银行</option>
                                        <option value='中山市农村信用合作社'>中山市农村信用合作社</option>
                                        <option value='香港上海汇丰银行有限公司'>香港上海汇丰银行有限公司</option>
                                        <option value='日照市商业银行'>日照市商业银行</option>
                                        <option value='昆明商业银行'>昆明商业银行</option>
                                        <option value='抚顺市商业银行'>抚顺市商业银行</option>
                                        <option value='深圳商业银行'>深圳商业银行</option>
                                        <option value='江阴市农村商业银行'>江阴市农村商业银行</option>
                                        <option value='吉林市商业银行'>吉林市商业银行</option>
                                        <option value='徽商银行马鞍山分行'>徽商银行马鞍山分行</option>
                                        <option value='恒生银行有限公司'>恒生银行有限公司</option>
                                        <option value='长沙市商业银行'>长沙市商业银行</option>
                                        <option value='大新银行有限公司'>大新银行有限公司</option>
                                        <option value='江西省农村信用社联合社'>江西省农村信用社联合社</option>
                                        <option value='昆明市农村信用联社'>昆明市农村信用联社</option>
                                        <option value='成都市商业银行'>成都市商业银行</option>
                                        <option value='徽商银行合肥分行'>徽商银行合肥分行</option>
                                        <option value='中信嘉华银行有限公司'>中信嘉华银行有限公司</option>
                                        <option value='昆明农联社'>昆明农联社</option>
                                        <option value='泰隆城市信用社'>泰隆城市信用社</option>
                                        <option value='攀枝花市商业银行'>攀枝花市商业银行</option>
                                        <option value='德阳市商业银行'>德阳市商业银行</option>
                                        <option value='湖南省农村信用社联合社'>湖南省农村信用社联合社</option>
                                        <option value='昆山农村信用合作社联合社'>昆山农村信用合作社联合社</option>
                                        <option value='江阴农村商业银行'>江阴农村商业银行</option>
                                        <option value='高要市农村信用联社'>高要市农村信用联社</option>
                                        <option value='南通商业银行'>南通商业银行</option>
                                        <option value='厦门市农村信用合作社'>厦门市农村信用合作社</option>
                                        <option value='顺德农信社'>顺德农信社</option>
                                        <option value='上海商业银行'>上海商业银行</option>
                                        <option value='大连商业银行'>大连商业银行</option>
                                        <option value='尧都区农村信用合作社联社'>尧都区农村信用合作社联社</option>
                                        <option value='包头市商业银行'>包头市商业银行</option>
                                        <option value='鄞州农村合作银行'>鄞州农村合作银行</option>
                                        <option value='国家邮政局'>国家邮政局</option>
                                        <option value='永隆银行有限公司'>永隆银行有限公司</option>
                                        <option value='宁波鄞州农村合作银行'>宁波鄞州农村合作银行</option>
                                        <option value='呼市商业银行'>呼市商业银行</option>
                                        <option value='靖江市长江城市信用社'>靖江市长江城市信用社</option>
                                        <option value='郑州商业银行'>郑州商业银行</option>
                                        <option value='集友银行'>集友银行</option>
                                        <option value='中江市农村信用社'>中江市农村信用社</option>
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
<script src="/static/third-party/jfu/js/jquery.uploadfile.min.js"></script> 
    <script language="javascript">
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
            $('#cardbank').attr("disabled", true);
            $('#subbranch').attr("disabled",true);
            $('#is_default').attr("disabled",true);
        } else {
            $('.new_card').show();
            $('#account').attr("disabled",  false);
            $('#cardloc').attr("disabled",  false);
            $('#cardno').attr("disabled",   false);
            $('#cardbank').attr("disabled", false);
            $('#subbranch').attr("disabled",false);
            $('#is_default').attr("disabled",false);
        }
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
        reset_bank(1, '修改银行卡');
        $('#id').val($(node).data('id'));
        $('#account').val($(node).data('account'));
        $('#cardbank').val($(node).data('bankname'));
        $('#cardloc').val($(node).data('bankloc'));
        $('#cardno').val($(node).data('cardno'));
        $('#subbranch').val($(node).data('subbranch'));
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
        $('#id').val($(node).data('id'));
        $('#account').val($(node).data('account'));
        $('#cardbank').val($(node).data('bankname'));
        $('#cardloc').val($(node).data('bankloc'));
        $('#cardno').val($(node).data('cardno'));
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
                        $.ajax({
                            url:__BASE+"users/update_phone",
                                method:"POST",
                                dataType:"json",
                                data:{'phone':_phone,'vcode':_vcode},
                                success:function(data){
                                    if(data.status==0 || data.status=='false')
                                    {
                                        show_notify(data.data.msg);
                                    }
                                    else if(data.status == 1)
                                    {
                                        $('#phone_modal').modal('hide');
                                        show_notify("手机绑定成功,1秒之后跳转至登陆页面");
                                        setTimeout(function(){window.location.href="/login"}, 1000);
                                    }

                                    // $('#phone_modal').modal('hide');
                                }
                        });
                    });

                    $('.change_phone').click(function(){
                        $('#phone_modal').modal({keyborard: false});
                    });
                    $('.getvcode').click(function(){
                        var _phone = $('#phone').val();
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
                        var _default_id = $('#default_id').val();
                        var _default = ($('#is_default').is(':checked') ? 1:0);
                        if(_default == 1)
                        {
                            _default_id = _id;
                        }
                        else if(_default_id == _id)
                        {
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
                                        ,'subbranch':_subbranch
                                        ,'default':_default
                                },
                                dataType : 'json',
                                method : 'POST',
                                success : function(data){
                                    if(data.status){
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
                                            + '<li> <a href="javascript:void(0)" data-id="' + _id + '" data-bankname="' + _bank + '"  data-cardno="' + _no + '" data-bankloc="' + _loc+ '"  data-account="' + _account + '" data-subbranch="' + _subbranch + '"' + ' data-default="' + _default_id + '"' +' class="edit_bank" >修改</a> </li>'
                                            + '<li> <a  href="javascript:void(0)" data-id="' + _id + '" data-bankname="' + _bank + '"  data-cardno="' + _no + '" data-bankloc="' + _loc+ '"  data-account="' + _account + '" data-subbranch="' + _subbranch + '"' + ' data-default="' + _default_id + '"' +'  class="show_bank">展示</a> </li> '
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
                                        $('#cardbank').val("");
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

    });
</script>



