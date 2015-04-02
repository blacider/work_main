<div class="box footer">
    <div class="fl fl footer_l">&copy;2014-2015 如数科技 all rights reserved</div>
    <div class="fr fl footer_r">京ICP备13019086-2号</div>
</div>
<script  type="text/javascript" src="/static/js/jquery-ui-1.8.12.custom.min.js"></script>
<script type="text/javascript" src="/static/js/base.js"></script>
<!--[if IE 6]>
<script src="/static/js/DD_belatedPNG_0.0.8a-min.js"></script>
<script>
DD_belatedPNG.fix('*');
</script>
<![endif]-->

<script language="javascript">
(function ($) {
    // 汉化 Datepicker
    $.datepicker.regional['zh-CN'] =
        {
            clearText: '清除', clearStatus: '清除已选日期',
                closeText: '关闭', closeStatus: '不改变当前选择',
                prevText: '<上月', prevStatus: '显示上月',
                nextText: '下月>', nextStatus: '显示下月',
                currentText: '今天', currentStatus: '显示本月',
                monthNames: ['一月', '二月', '三月', '四月', '五月', '六月',
                '七月', '八月', '九月', '十月', '十一月', '十二月'],
                monthNamesShort: ['一', '二', '三', '四', '五', '六',
                '七', '八', '九', '十', '十一', '十二'],
                monthStatus: '选择月份', yearStatus: '选择年份',
                weekHeader: '周', weekStatus: '年内周次',
                dayNames: ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
                dayNamesShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
                dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
                dayStatus: '设置 DD 为一周起始', dateStatus: '选择 m月 d日, DD',
                dateFormat: 'yy-mm-dd', firstDay: 1,
                initStatus: '请选择日期', isRTL: false
        };
    $.datepicker.setDefaults($.datepicker.regional['zh-CN']);

})(jQuery);
function strDate2Timestamp(strDate){
    //strDate="2007-2-28 10:18:30"; 输入字符串格式 注意标点符号是半角的
    var strArray=strDate.split(" ");
    var strDate=strArray[0].split("-");
    var strTime=strArray[1].split(":");
    return (new Date(strDate[0],(strDate[1]-parseInt(1)),strDate[2],strTime[0],strTime[1],strTime[2])).getTime();
}
Date.prototype.format = function(format) {  
    /* 
     * eg:format="yyyy-MM-dd hh:mm:ss"; 
     */  
    var o = {  
        "M+" : this.getMonth() + 1, // month  
            "d+" : this.getDate(), // day  
            "h+" : this.getHours(), // hour  
            "m+" : this.getMinutes(), // minute  
            "s+" : this.getSeconds(), // second  
            "q+" : Math.floor((this.getMonth() + 3) / 3), // quarter  
            "S" : this.getMilliseconds()  
            // millisecond  
    }  

    if (/(y+)/.test(format)) {  
        format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4  
            - RegExp.$1.length));  
    }  

    for (var k in o) {  
        if (new RegExp("(" + k + ")").test(format)) {  
            format = format.replace(RegExp.$1, RegExp.$1.length == 1  
                ? o[k]  
                : ("00" + o[k]).substr(("" + o[k]).length));  
        }  
    }  
    return format;  
} 
</script>

</body>
</html>
