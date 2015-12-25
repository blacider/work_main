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



