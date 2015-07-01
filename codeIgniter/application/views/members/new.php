
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
        <form role="form" action="<?php echo base_url('members/docreate');  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" id="mainform">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">姓名</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="nickname" placeholder="姓名">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">手机</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="mobile" placeholder="手机">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">邮箱</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="email" placeholder="邮箱">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">部门</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select class="chosen-select tag-input-style" name="groups" multiple="multiple" data-placeholder="请选择部门">
                                        <!-- <option value="0">请选择部门</option> -->
                                        <?php foreach($groups['group'] as $g) { ?>
                                        
                                        <option value="<?php echo $g['id']; ?>"><?php echo $g['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">银行户名</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input id="account" name="account" type="text" class="form-controller col-xs-12" placeholder="银行户名" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">银行卡号</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="cardno" placeholder="银行卡号">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">开卡行</label>
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
                                        <option value='工商银行'>工商银行</option>
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
                                <label class="col-sm-1 control-label no-padding-right">开户地</label>
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
                                <label class="col-sm-1 control-label no-padding-right">管理员</label>
                                <div class="col-xs-6 col-sm-6">
                                    <label style="margin-top:8px;">
                                        <input name="admin" class="ace ace-switch btn-rotate" type="checkbox"  style="margin-top:4px;" />
                                        <span class="lbl"></span>
                                    </label>

                                </div>
                            </div>

                            <input type="hidden" id="renew" name="renew" value="0" />
                            <input type="reset" style="display:none;" id="reset">
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>
                                    <a class="btn btn-white btn-default renew" data-renew="1"><i class="ace-icon fa fa-check "></i>保存再记</a>

                                    <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                                </div>
                            </div>

                        </div>
            </div>
        </form>
    </div>
</div>

<script language="javascript">
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
    $('#modal_title').val();
    $('#account' ).val("");
    $('#id' ).val("");
    $('#cardloc' ).val("");
    $('#cardno'  ).val("");
    $('#cardbank').val("");
    if(!disable) {
        $('.new_card').hide();
        $('#account').attr("disabled",  true);
        $('#cardloc').attr("disabled",  true);
        $('#cardno').attr("disabled",   true);
        $('#cardbank').attr("disabled", true);
    } else {
        $('.new_card').show();
        $('#account').attr("disabled",  false);
        $('#cardloc').attr("disabled",  false);
        $('#cardno').attr("disabled",   false);
        $('#cardbank').attr("disabled", false);
    }
}
$(document).ready(function(){

    get_province();
    $('.chosen-select').chosen({allow_single_deselect:true}); 
    $(window)
        .off('resize.chosen')
        .on('resize.chosen', function() {
            $('.chosen-select').each(function() {
                var $this = $(this);
                $this.next().css({'width': $this.parent().width()});
            })
        }).trigger('resize.chosen');
    $('.renew').click(function(){
        
        var _p = $('#province').val();
        var _c = $('#city').val();
        var _loc = _p + _c;//$('#cardloc').val();
        $('#cardloc').val(_loc);
        $('#renew').val($(this).data('renew'));
        $('#mainform').submit();
    });
    $('.cancel').click(function(){
        $('#reset').click();
    });
    $('.new_credit').click(function(){
        reset_bank(1, '添加新银行卡');
        $('#credit_model').modal({keyborard: false});
    });


});
</script>

