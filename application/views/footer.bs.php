
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
    $('#loading-btn').on(ace.click_event, function () {
        var btn = $(this);
        btn.button('loading')
            setTimeout(function () {
                btn.button('reset')
            }, 2000)
    });

    $('#id-button-borders').attr('checked' , 'checked').on('click', function(){
        $('#default-buttons .btn').toggleClass('no-border');
    });
})
    </script>
<script type="text/javascript" src="https://tajs.qq.com/stats?sId=50936285" charset="UTF-8"></script>

<!-- 百度统计 -->
<div style="display: none;">
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?f3b83c21deaa6cfaa74e7ade7c0418d0";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</div>
</body>
</html>
