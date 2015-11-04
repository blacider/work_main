<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<script src="/static/ace/js/date-time/moment.min.js"></script>
<!-- <script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script> -->
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/dropzone.min.js"></script>


<script src="/static/ace/js/date-time/moment.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script>
    
     
	 
	   <script src="/static/ace/js/jquery.colorbox-min.js"></script>
	   
	     <!-- page specific plugin styles -->
	     <link rel="stylesheet" href="/static/ace/css/colorbox.css" />



<div class="page-content">
    <div class="page-content-area">
        <form role="form" action="<?php echo base_url('reports/create');  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" id="mainform">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">名称</label>
                                <div class="col-xs-9 col-sm-9">
                                    <input type="text" id="title" class="form-controller col-xs-12" name="title"  placeholder="名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">发送至</label>
                                <div class="col-xs-9 col-sm-9">
                                    <select class="chosen-select tag-input-style" name="receiver[]" multiple="multiple" data-placeholder="请选择审批人" id="receiver">
                                        <?php 
					$user = $this->session->userdata('user');
					foreach($members as $m) {
					if($user['id'] != $m['id']){
                        if ($user['manager_id'] != $m['id']){?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
                                        <?php } else {?>
                                        <option selected="true" value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
                                        <?php } ?>
                                        <?php }} ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">抄送至</label>
                                <div class="col-xs-9 col-sm-9">
                                    <select class="chosen-select tag-input-style" name="cc[]" id="cc" multiple="multiple" data-placeholder="请选择抄送人">
                                        <?php foreach($members as $m) {
					if($user['id'] != $m['id']){?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
                                       
                                        <?php }} ?>
                                    </select>
                                </div>
                            </div>

<?php
                        if(!empty($config)) {
?>
                            <input type="hidden" id="template_id" name="template_id" value="<?php echo $config['id']; ?>">

                            <?php
                            if($config['config'])
                            {
                                ?>
                            <hr>
                                <?php 
                            }
                            foreach($config['config'] as $field_group){
                            ?>
                                <?php
                                    if(array_key_exists('children', $field_group))
                                    {
                                    foreach($field_group['children'] as $field)
                                    {
                                ?>

                                <?php
                                    switch(intval($field['type']))
                                    {
                            
                                        case 1:
                                ?>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"><?php echo $field['name'];?></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 field_value" data-type="1" data-required="<?php echo $field['required'];?>" data-id="<?php echo $field['id'];?>" <?php if($field['required'] == 1){echo 'required';}?>/>
                                                </div>
                                            </div>
                                        
                                        </div>

                                <?php
                                        break;
                                ?>

                                <?php
                                        case 2:
                                ?>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"><?php echo $field['name'];?></label>
                                            <div class="col-xs-3 col-sm-3">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <select class="chosen-select tag-input-style col-xs-6 field_value" data-type="2" data-id="<?php echo $field['id'];?>" data-required="<?php echo $field['required'];?>" data-placeholder="请选择" <?php if($field['required'] == 1){echo 'required';}?>>
                                                        <?php foreach($field['property']['options'] as $m) { ?>
                                                                <option value="<?php echo $m; ?>"><?php echo $m; ?></option>
                                                       
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                        break;
                                ?>

                                <?php
                                        case 3:
                                ?>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"><?php echo $field['name'];?></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 period field_value date-timepicker1" data-type="3" data-id="<?php echo $field['id'];?>" data-required="<?php echo $field['required'];?>" name="dt" placeholder="时间" <?php if($field['required'] == 1){echo 'required';}?>>
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                        break;
                                ?>

                                <?php
                                        case 4:
                                ?>
                                        <div class="field_value" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>" data-required="<?php echo $field['required'];?>" >
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"><?php echo $field['name'];?></label>
                                            <div class="col-xs-6 col-sm-6">
                                                <div class="col-xs-12 col-sm-12 "  style="margin-left:0px !important;padding-left:0px !important;" >
                                                    <div class="btn-toolbar" id="<?php echo 'btns' . $field['id'];?>">
                                                        <div class="col-xs-3 col-sm-3">
                                              
                                                                <select class="chosen-select tag-input-style col-xs-6 field_value bank_select" id="<?php echo 'bank_select_' . $field['id'];?>" data-type="4" data-id="<?php echo $field['id'];?>" data-required="<?php echo $field['required'];?>" data-placeholder="请选择" <?php if($field['required'] == 1){echo 'required';}?>>
                                                                    <?php foreach($banks as $b) { ?>
                                                                            <option value='<?php echo json_encode($b); ?>'><?php echo $b['account']; ?></option>
                                                                   
                                                                    <?php } ?>
                                                                </select>
                                                        
                                                        </div>
                                                        <div class="btn-group">
                                                            <a href="javascript:void(0)" class="btn btn-success new_credit" data-id="<?php echo $field['id'];?>">
                                                                <i class="ace-icon fa fa-credit-card icon-only"></i>
                                                                添加银行卡
                                                            </a>
                                                        </div><!-- /.btn-group -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                        break;
                                ?>

                                <?php 
                                    }
                                ?>

                                <?php
                                    }
                                ?>
                            <hr>
<?php
                            }
                        }
                    }
?>



                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">总额</label>
                                <div class="col-xs-9 col-sm-9">
                                    <span class="middle" id="tamount">0</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">选择消费</label>
                                <div class="col-xs-9 col-sm-9">
                                    <table class="table table-border">
                                        <tr>
                                            <thead>
                                                <td>
                                                   <input name="all_item" id="all_item" type="checkbox" class="form-controller all_item"> 全选</td>
                                                </td>
                                                <td>消费时间</td>
                                                <td>类型</td>
                                                <td>金额</td>
                                                <td>类别</td>
                                                <td>商家</td>
                                                <td>备注</td>
                                                <td>操作</td>
                                            </thead>
                                        </tr>
<?php
    $_config = '';
    if(array_key_exists('config',$profile['group']))
    {
        $_config = $profile['group']['config'];
    }
    $__config = json_decode($_config,True);

$item_type = array();
$extra_item_type = [0,1,2];
if(array_key_exists('type', $config))
{
    $extra_item_type = $config['type'];
}
array_push($item_type,0);
if($__config)
{
    if(array_key_exists('disable_borrow', $__config) && $__config['disable_borrow'] == '0')
    {
        array_push($item_type,1);
    }
    if(array_key_exists('disable_budget', $__config) && $__config['disable_budget'] == '0')
    {
        array_push($item_type,2);
    }
}
foreach($items as $i){
    if($i['rid'] == 0 && in_array($i['prove_ahead'], $item_type) && in_array($i['prove_ahead'],$extra_item_type)){
                                        $item_amount = '';
                                        if($i['currency'] != 'cny')
                                        {
                                            $item_amount = round($i['amount']*$i['rate']/100,2);
                                        }
                                        else
                                        {
                                            $item_amount = $i['amount']; 
                                        }

                                        ?>
                                        <tr id="<?php echo 'item'.$i['id']?>">
                                        <td>
                                            <input name="item[]" value="<?php echo $i['id']; ?>" 
                                            type="checkbox" class="form-controller amount" 
                                            data-amount = "<?php echo $item_amount; ?>" data-type="<?php echo $i['prove_ahead'];?>"
                                            data-id="<?php echo $i['id']; ?>" 
                                            ></td>
                                            <td><?php echo strftime('%Y-%m-%d %H:%M', $i['dt']); ?></td>
                                            <td><?php echo $i['cate_str'];?></td>
                                            <td><?php echo $i['coin_symbol'] . $i['amount'];?></td>
                                            <td><?php echo $item_type_dic[$i['prove_ahead']];?></td>
                                            <td><?php echo $i['merchants']; ?></td>
                                            <td><?php echo $i['note']; ?></td>
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del">
                                                    <span class="ui-icon ui-icon ace-icon fa fa-search-plus txdetail" data-id="<?php echo $i['id']; ?>"></span>
                                                    <span class="ui-icon green ui-icon-pencil txedit" data-id="<?php echo $i['id']; ?>"></span>
                                                    <span class="ui-icon ui-icon-trash red  txdel" data-id="<?php echo $i['id']; ?>"></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } } ?>
                                    </table>
                                </div>
                            </div>

                            <input type="hidden" id="renew" value="0" name="renew">
                            <input type="reset" style="display:none;" id="reset">
                            <div class="clearfix form-actions col-md-10">
                                <div class="col-md-offset-3 col-md-9">
                                    <a class="btn btn-white btn-primary renew" data-renew="1"><i class="ace-icon fa fa-check"></i>提交</a>

                                    <a class="btn btn-white btn-default renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>

                                    <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
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


<div class="modal fade" id="force_submit">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">警告</h4>
      </div>
      <div class="modal-body" id="error">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消提交</button>
        <button type="button" class="btn btn-primary force_submit_btn" >确定提交</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="credit_model">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_title">添加银行卡</h4>
            </div>
            <div class="modal-body">
                <form id="password_form" class="form-horizontal" role="form" method="post" action="#">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">户名</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input id="account" name="account" type="text" class="form-controller col-xs-12" placeholder="户名" />
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
                                        <option value='中国邮政储蓄银行'>中国邮政储蓄银行</option>
                                        <option value='上海浦东银行'>上海浦东银行</option>
                                        <option value='D.F.S.I'>D.F.S.I</option>
                                        <option value='金华市商业银行'>金华市商业银行</option>
                                        <option value='徐州市郊农村信用合作联社'>徐州市郊农村信用合作联社</option>
                                        <option value='花旗银行有限公司'>花旗银行有限公司</option>
                                        <option value='兰州市商业银行'>兰州市商业银行</option>
                                        <option value='天津市商业银行'>天津市商业银行</option>
                                        <option value='广州市商业银行'>广州市商业银行</option>
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
                                        <option value='九江市商业银行'>九江市商业银行</option>
                                        <option value='江苏农信社'>江苏农信社</option>
                                        <option value='南京市商业银行'>南京市商业银行</option>
                                        <option value='三门峡市城市信用社'>三门峡市城市信用社</option>
                                        <option value='沈阳市商业银行'>沈阳市商业银行</option>
                                        <option value='西宁市商业银行'>西宁市商业银行</option>
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

                            <input type="hidden" name="bank_field_id" id="bank_field_id" />
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


<script language="javascript">
update_tamount();
var __BASE = "<?php echo $base_url; ?>";

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

function escapeHtml(unsafe) {
    return unsafe
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
         .replace(/'/g, "&#039;");
 }



function reset_bank(disable, title,bank_field_id) {
        $('#modal_title').val();
        $('#account' ).val("");
        $('#cardloc' ).val("");
        $('#cardno'  ).val("");
        $('#cardbank').val("");
        $('#subbranch').val("");
        $('#bank_field_id').val(bank_field_id);
        if(!disable) {
            $('.new_card').hide();
            $('#account').attr("disabled",  true);
            $('#cardloc').attr("disabled",  true);
            $('#cardno').attr("disabled",   true);
            $('#cardbank').attr("disabled", true);
            $('#subbranch').attr("disabled",true);
        } else {
            $('.new_card').show();
            $('#account').attr("disabled",  false);
            $('#cardloc').attr("disabled",  false);
            $('#cardno').attr("disabled",   false);
            $('#cardbank').attr("disabled", false);
            $('#subbranch').attr("disabled",false);
        }
        $('.cancel').click(function(){
            $('#credit_model').modal('hide');
        });
    }



    function del_credit(node){
        var _id = $(node).data('id');
        $('#bank_' + _id).remove();
    }


    function update_credit(node){
        var _id = $(node).data('id');
        reset_bank(1, '修改银行卡', _id);
       
        $('#account').val($(node).data('account'));
        $('#cardbank').val($(node).data('bankname'));
        $('#cardloc').val($(node).data('bankloc'));
        $('#cardno').val($(node).data('cardno'));
        $('#subbranch').val($(node).data('subbranch'));
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
        var _id = $(node).data('id');
        reset_bank(0, '银行卡详情',_id);
        $('#account').val($(node).data('account'));
        $('#cardbank').val($(node).data('bankname'));
        $('#cardloc').val($(node).data('bankloc'));
        $('#cardno').val($(node).data('cardno'));
        $('#subbranch').val($(node).data('subbranch'));
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

function trim(str){ //删除左右两端的空格
　　 return str.replace(/(^\s*)|(\s*$)/g, "");
}

function toDecimal(x) {  
    var f = parseFloat(x);  
    if (isNaN(f)) {  
        return;  
    }  
    f = Math.round(x*100)/100;  
    return f;  
}  
//制保留2位小数，如：2，会在2后面补上00.即2.00  
function toDecimal2(x) {  
    
    var f = parseFloat(x);  
    
    if (isNaN(f)) {  
        return false;  
    }  
    var f = Math.round(x*100)/100;  
    var s = f.toString();  
    var rs = s.indexOf('.');  
    if (rs < 0) {  
        rs = s.length;  
        s += '.';  
    }  
    while (s.length <= rs + 2) {  
        s += '0';  
    }  
    return s;  
}  



function do_post(force) {
    // 囧

    var s = $('#receiver').val();
    var title = $('#title').val();
    if(title == "") {
        show_notify('请添加报告名');
        $('#title').focus();
        return false;
    }


    var sum=0;

    var _ids = Array();
    var report_type = 0;
    var flag = 0;
    var is_submit = 1;
	$('.amount').each(function(){
		if($(this).is(':checked')){
            _ids.push($(this).data('id'));
			var amount = $(this).data('amount');
            var item_type = $(this).data('type');
            if(flag == 0)
            {
                report_type = item_type;
                flag = 1;
            }
            if(report_type != item_type)
            {
                show_notify('同一报告中不能包含不同的消费类型');
                is_submit = 0;
                return false;
            }
           
			amount = parseInt(amount);
			sum+=amount;
		};
	});
    if(_ids.length == 0) {
        show_notify('提交的报告不能为空');
        return false;
    }

    var _period_start = 0;
    var _period_end = 0;

    var _location_from =  '';
    var _location_to =  '';

    var _contract = 0;
    var _contract_note = '';


    var _account = 0;
    var _account_name = '';
    var _account_no = '';
    var _payment = 0;


    var _borrowing = 0;
    var _note = '';


    var _template_id = 0;

    try {
        _template_id = $('#template_id').val();
    }catch(e){}

    try {
        _account = $('#account').val();
        var s = $("#account option:selected");
        _account_name = $(s).data('name');
        _account_no = $(s).data('no');
        if(!_account_name) _account_name = '';
        if(!_account_no) _account_no = '';
        if(!_account) _account = 0;
    } catch(e) {}

    var extra = [];
 
    $('.field_value').each(function(){
        var field_value = $(this).val();
        var field_id = $(this).data('id');
        var field_type = $(this).data('type');
        var field_required = $(this).data('required');

        if(field_type == 4)
        {
            var field_bank = $(this).data('bank');
            var bank_info = $('#bank_select_' + field_id).val();
       
            var field_account = '';
            var field_cardno = '';
            var field_bankname = '';
            var field_bankloc = '';
            var field_subbranch = '';
          
            if(field_required == 1 && !bank_info)
            {
                show_notify('必填银行卡项目不能为空');
                is_submit = 0;
                return false;
            }
            if(bank_info)
            {
                var _bank_info = JSON.parse(bank_info);
                console.log(_bank_info);
                var field_account = _bank_info['account'];
                var field_cardno = _bank_info['cardno'];
                var field_bankname = _bank_info['bankname'];
                var field_bankloc = _bank_info['bankloc'];
                var field_subbranch = _bank_info['subbranch'];
            }
            extra.push({'id':field_id,'value':JSON.stringify({
                                               'account':field_account,
                                               'cardno':field_cardno,
                                               'bankname':field_bankname,
                                               'bankloc':field_bankloc,
                                               'subbranch':field_subbranch,
                                               'account_type':field_bank
                                               })
                                               ,'type':field_type} );
        }
        else
        {

            if(field_required == 1 && trim(field_value)=='')
            {
                $(this).focus();
                show_notify('必填项目不能为空');
                is_submit = 0;
                return false;
            }
            extra.push({'id':field_id,'value':field_value,'type':field_type});
        }
        
    });

/*
    try {
        _note = $('#note').val();
        if(!_note) _note = '';
    } catch(e) {}

    try {
        _payment = $('input[name="payment"]:checked').val(); 
        if(!_payment) _payment = 0;
    }catch(e){}

    try {
        _borrowing = $('#borrowing').val();
        if(!_borrowing) _borrowing = 0;
    } catch(e) {}

    try {
        _contract = $('input[name="contract"]:checked').val(); 
        if(!_contract) _contract = -1;
    }catch(e){}
    if(_contract == 2) {
        try{
            _contract_note = $('#contract_note').val();
            if(!_contract_note) _contract_note = '';
        }catch(e){}
    }


    try {
        _period_end = (new Date($("#period_end").val())).getTime() / 1000;
        _period_start = (new Date($("#period_start").val())).getTime() / 1000;
        if(!_period_start || _period_start == NaN) _period_start = new Date().getTime() / 1000;
        if(!_period_end || _period_end== NaN) _period_end= new Date().getTime() / 1000;
        _period_start = parseInt(_period_start);
        _period_end = parseInt(_period_end);
    }catch(e){}

    try {
        _location_from = $('#location_from').val();
        if(!_location_from) _location_from = '';
        _location_to = $('#location_to').val();
        if(!_location_to) _location_to= '';
    }catch(e){} */


	if(s == null){
	     show_notify('请选择审批人');
	     $('#receiver').focus();
	     return false;
	}


	if(sum <= 0) {
		show_notify("报告总额不能小于等于0");
		return false;
	}
    
    // 转ajax,否则不能正确处理
    var _renew = $('#renew').val();
    if(_renew == 0) force = 1;
    // 获取所有的 条目
    var _cc = $('#cc').val();
    if(!_cc) _cc = Array();

    if(is_submit)
    {
        $.ajax({
            type : 'POST',
                url : __BASE + "reports/create", 
                    data : {'item' : _ids,
                        'title' : $('#title').val(),
                        'receiver' : $('#receiver').val(),
                        'cc' : _cc,

                        'template_id' : _template_id,
                        'extra':extra,
                        'type':report_type,

                        'renew' : _renew,
                        'force' : force
                    },
                    dataType: 'json',
                    success : function(data){
                        if(data.status > 0) {
                            window.location.href = __BASE + 'reports/index';
                        }
                        if(_renew == 1 && data.status == -71) {
                            $('#error').html(data.msg);
                            $('#force_submit').modal();
                            return false;
                        }
                        if(data.status < 0 && data.status != -71) {
                            show_notify(data.msg);
                        }
                        return false;
                    }
                });
    }

}

$(document).ready(function(){
    get_province();

    $('.new_credit').each(function(){
        var _id = $(this).data('id');
        $(this).click(function(){
            reset_bank(1,'添加新银行卡',_id);
            $('#credit_model').modal({keyborard:false});
        });
    });
    $('.new_card').click(function(){
        var _id = $('#bank_field_id').val();
        var _p = $('#province').val();
        var _c = $('#city').val();
        var _account = $('#account').val();
        var _bank = $('#cardbank').val();
        var _subbranch = $('#subbranch').val();
        var _no = $('#cardno').val();
        var _loc = _p + _c;//$('#cardloc').val();
        var value = {"account":_account,"bankname":_bank,"subbranch":_subbranch,"bankloc":_loc,"cardno":_no};
        var _value = JSON.stringify(value);

       
        var buf = '<option selected value="'+ escapeHtml(_value) +'">'+ _account +'</option>';
        $('#credit_model').modal('hide');
        $('#bank_select_' + _id).append(buf);
        $('#bank_select_' + _id).trigger('chosen:updated');
        console.log($('#bank_select_' + _id));
        show_notify('银行卡添加成功');
    });

    bind_event();

    $('#period_start').datetimepicker({
        language: 'zh-cn',
            //locale:  moment.locale('zh-cn'),
            useCurrent: true,
        format: 'YYYY-MM-DD HH:mm:ss',
            sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });
    $('#period_end').datetimepicker({
        language: 'zh-cn',
            //locale:  moment.locale('zh-cn'),
            useCurrent: true,
            format: 'YYYY-MM-DD HH:mm:ss',
            sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });
    $('#contract_note').hide();
    $('.contract').each(function(idx, item) {
        $(this).click(function() {
            var _val = $(this).val();
            if(_val == 0) {
                $('#contract_note').show();
            } else {
                $('#contract_note').hide();
            }
        });
    });
    $('.date-timepicker1').each(function(){
        $(this).datetimepicker({
        language: 'zh-cn',
            //locale:  moment.locale('zh-cn'),
            useCurrent: true,
            format: 'YYYY-MM-DD HH:mm:ss',
            linkField: "dt",
            linkFormat: "YYYY-MM-DD HH:mm:ss",
            sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
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

    $('.txdetail').each(function(){
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "items/show/" + _id;
        });
    });
    $('.txdel').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
           // location.href = __BASE + "items/del/" + _id + "/1";
           $.ajax({
            url:__BASE + "items/del/" + _id + "/1",
            method:'GET',
            success:function(data){
                $('#item'+_id).remove();
                show_notify('删除成功');
            }
           });
        });
    });
    $('.txedit').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "items/edit/" + _id;
        });
    });
    

    $('#all_item').click(function(){
        if($('#all_item').is(":checked"))
        {
            $('.amount').each(function(){
                $(this).prop('checked',true);
            });   

            //$("[name='item[]']").prop('checked',true);
        }
        else
        {
            $('.amount').each(function(){
                $(this).prop('checked',false);
              // $(this).removeAttr("checked"); 
            });
           // $("[name='item[]']").prop('checked',false);
        }
        update_tamount();
     });


    $('.renew').click(function(){
        $('#renew').val($(this).data('renew'));
        /// 不强制
        do_post(0);
    });
    $('.force_submit_btn').click(function() {
        $('#renew').val(1);
        do_post(1);
    });



    $('.amount').each(function(idx, item) {
        $(this).click(function(){
            update_tamount();
        });
    });
    $('.cancel').click(function(){
        $('#reset').click();
    });

});
function update_tamount(){
    var sum = 0;
    $('.amount').each(function(){
        if($(this).is(':checked')){
            var amount = $(this).data('amount');
            amount = Number(amount);
            sum=Number(sum) + Number(amount);
        };
    });
    $('#tamount').html('￥' + toDecimal2(sum));
}
</script>

