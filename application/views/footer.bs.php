
</div> <!-- eof main-content -->

<div class="footer">
    <div class="footer-inner">
        <!-- #section:basics/footer -->
        <div class="footer-content">
            <span class="bigger-120">
                <span class="blue bolder"><a href="http://www.yunbaoxiao.com" target="_blank">如数科技</a></span>
                ©2016
            </span>

            &nbsp; &nbsp;
            京ICP备14046885号-2
        </div>

        <!-- /section:basics/footer -->
    </div>
</div>
</div>
<script type="text/javascript">
jQuery(function($) {
    $('#loading-btn').on('click', function () {
        var btn = $(this);
        btn.button('loading');
        setTimeout(function () {
            btn.button('reset')
        }, 2000)
    });

    $('#id-button-borders').attr('checked' , 'checked').on('click', function(){
        $('#default-buttons .btn').toggleClass('no-border');
    });
})
    </script>

<!-- 百度统计 -->
<div style="display: none;">
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?777289b210223dd4e237d8e2089250fd";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</div>

<!-- 美洽 -->
<script type='text/javascript'>
    (function(m, ei, q, i, a, j, s) {
        m[a] = m[a] || function() {
            (m[a].a = m[a].a || []).push(arguments)
        };
        j = ei.createElement(q),
            s = ei.getElementsByTagName(q)[0];
        j.async = true;
        j.charset = 'UTF-8';
        j.src = i + '?v=' + new Date().getUTCDate();
        s.parentNode.insertBefore(j, s);
    })(window, document, 'script', '//eco-api.meiqia.com/dist/meiqia.js', '_MEIQIA');
    _MEIQIA('entId', 7359);
</script>
</body>
</html>
