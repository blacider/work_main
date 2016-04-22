<link rel="stylesheet" href="/static/css/widgets/ie_lower_version.css">
<div id="IE-LOW-VERSION"  style="display: none">
    <div id="IE-LOW-VERSION-MASK">
    </div>
    <div id="IE-LOW-VERSION-CONTENT">
        <div class="wrap">
            <h2>
                当前浏览器版本过低，无法支持「云报销」正常运行，请升级：
            </h2>
            <div class="broswer-recommend">
                <a target="_blank" href="https://www.google.cn/intl/zh-CN/chrome/browser/desktop/">谷歌Chrome</a>
                <a target="_blank" href="http://www.firefox.com.cn/">火狐 Firefox</a>
            </div>
            <p>或扫码下载客户端：</p>
            <div class="img">
                <img class="download-code" src="/static/img/mod/ie_lower_version/download.png" alt="">
                <img class="sorry" src="/static/img/mod/ie_lower_version/sorry.png" alt="">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/static/js/libs/detect.js"></script>
<script>
    var ua = detect.parse(navigator.userAgent);
    var browser = ua['browser'];
    if(browser['family'] == 'IE' && browser['major']<=7) {
        var IE_LOW_VERSION = document.getElementById('IE-LOW-VERSION');
        IE_LOW_VERSION.style['display'] = 'block';
    }
</script>