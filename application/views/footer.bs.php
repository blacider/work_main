
</div> <!-- eof main-content -->

<div class="footer" style="width: 100%; border-top: none">
    <div class="footer-inner" style="height: 51px; background: #fff">
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
<?php if(!$has_attacker) { ?>
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
<?php } ?>
<?php get_sub_widget('module/widgets/meiqia'); ?> 
 
</body>
</html>
