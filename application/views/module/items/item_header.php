<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<script src="/static/ace/js/jquery.json.min.js"></script>
<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />

<!-- <link rel="stylesheet" href="/static/third-party/jqui/jquery-ui.min.css" id="main-ace-style" /> -->

<!-- page specific plugin styles -->
<link rel="stylesheet" href="/static/ace/css/colorbox.css" />
<div class="page-content">
<div class="page-content-area">
<form role="form" action="<?php echo base_url('items/create');  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" id="itemform">
<div class="row">
<div class="col-xs-12 col-sm-12">
<?php echo $html_company_config;?>
<?php
  if($page_type == 1)
  {
    echo $html_item;
    echo $html_sob_id;
    echo $html_fee_afford_type;
    echo $html_fee_afford_ids;
    echo get_html_container($images,'html_images',false);
  }
?>
<script type="text/javascript">
var simbol_dic = {'cny':'人民币','usd':'美元','eur':'欧元','hkd':'港币','mop':'澳门币','twd':'新台币','jpy':'日元','ker':'韩国元',
                              'gbp':'英镑','rub':'卢布','sgd':'新加坡元','php':'菲律宾比索','idr':'印尼卢比','myr':'马来西亚元','thb':'泰铢','cad':'加拿大元',
                              'aud':'澳大利亚元','nzd':'新西兰元','chf':'瑞士法郎','dkk':'丹麦克朗','nok':'挪威克朗','sek':'瑞典克朗','brl':'巴西里亚尔'
                             }; 
var icon_dic = {'cny':'￥','usd':'$','eur':'€','hkd':'$','mop':'$','twd':'$','jpy':'￥','ker':'₩',
                              'gbp':'£','rub':'₽','sgd':'$','php':'₱','idr':'Rps','myr':'$','thb':'฿','cad':'$',
                              'aud':'$','nzd':'$','chf':'₣','dkk':'Kr','nok':'Kr','sek':'Kr','brl':'$'
                             }; 
var typed_currency = [];

var ifUp = 1;

//定义页面类型，获取页面内容
var PAGE_TYPE = "<?php echo $page_type; ?>";
if(PAGE_TYPE != 0)
{
  var item_info = $('#item_info').data('value');
}

var __BASE = "<?php echo $base_url; ?>";
var __config = $('#company_config').data('value');
var subs = "<?php echo $profile['subs'];?>";
var __item_config = $('#item_config').data('value');

var item_config = [];
if(__item_config)
{
    item_config = __item_config;
}

var _item_config = new Object();
for(var i = 0 ; i < item_config.length; i++)
{
    if(item_config[i]['type']==2 || item_config[i]['type'] == 5 || item_config[i]['type'] == 1) {
        _item_config[item_config[i]['cid']] = item_config[i];
    }
}

$(document).ready(function(){
  $('.chosen-select').chosen({allow_single_deselect:true}); 
  $(window)
  .off('resize.chosen')
  .on('resize.chosen', function() {
    $('.chosen-select').each(function() {
      var $this = $(this);
      $this.next().css({'width': $this.parent().width()});
    })
  }).trigger('resize.chosen');
});
</script>

<?
    foreach($item_customization as $ic)
    {
        if($ic['enabled'])
        {
            if(array_key_exists($ic['type'],$item_type_view_dic) && $item_type_view_dic[$ic['type']])
            {
                $load_data = array( 
                    'item_customization_value' => $ic,
                    'company_config' => $company_config,
                    'is_burden' => $is_burden,
                    'profile' => $profile,
                    'tags' => $tags,
                    'afford' => $afford,
                    'item_type_dic' => $item_type_dic,
                    'member' => $member,
                    'page_type' => $page_type
                    );
                if($page_type == 1)
                {
                    $load_data['item'] = $item;
                    $load_data['sob_id'] = $sob_id;
                }
                    
                get_sub_weget($item_type_view_dic[$ic['type']],$load_data);
            }
        }
    }

    include get_sub_module('module/items/item_footer');
?>

