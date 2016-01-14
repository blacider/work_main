<?php 

function show_attachments(&$s)
{
    $s['attachment'] = '';
    if(array_key_exists('attachments',$s))
    {
        $img_path = '/static/images/';
        $img = 'default.png';
        $attach_img_dic = array(
            'application/vnd.openxmlformats-officedocument.presentationml.presentation'=>'powerpoint.png',
            'application/vnd.ms-powerpoint'=>'powerpoint.png',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'=>'word.png',   
            'application/msword'=>'word.png',
            'application/pdf'=>'pdf.png',
            'pplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet'=>'excel.png',
            'application/vnd.ms-excel'=>'excel.png'
        );
        if($s['attachments'])
        {
            foreach($s['attachments'] as $attach)
            {
                if(array_key_exists('mime',$attach) && array_key_exists($attach['mime'],$attach_img_dic))
                {
                    $img = $attach_img_dic[$attach['mime']];
                }
                $_filename = '';
                $_file_url = '';
                if(array_key_exists('filename',$attach))
                {
                    $_filename = $attach['filename'];
                }
                if(array_key_exists('url',$attach))
                {
                    $_file_url = $attach['url'];
                }
                $_attach = '<img title="' . htmlspecialchars($_filename)  .  '" style="width:25px;height:25px" src = "' . htmlspecialchars($img_path . $img) . '"/>';
                $_attach_url = '<a title="' . htmlspecialchars($_filename)  . '"  href="' . htmlspecialchars($_file_url) . '">' . $_attach . '</a>';
                $s['attachment'] = $s['attachment'] . '&nbsp;&nbsp;' . $_attach_url;
            }
        }
    }
}


function get_report_status_str($status) {
    switch($status) {
    case 0:
        $txt = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#A07358;background:#A07358 !important;">待提交</button>';
        break;
    case 1:
        $txt = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#46A3D3;background:#46A3D3 !important;">审核中</button>';
        break;
    case 2:
        $txt = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#42B698;background:#42B698 !important;">待结算</button>';
        break;
    case 3:
        $txt = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#B472B1;background:#B472B1 !important;">退回</button>';
        break;
    case 4:
        $txt = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
        break;
    case 5:
        $txt = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
        break;
    case 6:
        $txt = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#42B698 !important;">待支付</button>';
        break;
    case 7:
        $txt = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">完成待确认</button>';
        break;
    case 8:
        $txt = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">完成已确认</button>';
        break;
    default:
        $txt = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#A07358;background:#A07358 !important;">待提交</button>';
    }
    return $txt;
}

function get_report_type_str($item_type_dic,$prove_ahead_id,$approval)
{
	$prove_ahead = '报销';
	$extra = '';
	if($approval == 0)
	    $extra = '第一轮';
	else if($approval == 1)
	    $extra = '第二轮';
	switch($prove_ahead_id){
	    case 0: {$prove_ahead = '<font color="black">' . $item_type_dic[0]  . '</font>';};break;
    	case 1: {$prove_ahead = '<font color="green">' . $item_type_dic[1] . $extra .'</font>';};break;
    	case 2: {$prove_ahead = '<font color="red">' . $item_type_dic[2] . $extra . '</font>';};break;
	}
	
	return $prove_ahead;
}
