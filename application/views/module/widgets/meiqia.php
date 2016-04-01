<!-- 美洽 -->
<style>
    #MEIQIA-PANEL-HOLDER-MASK {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 21474836399;
        display: block;
        width: 50px;
        height: 50px;
        border: 1px solid rgba(0, 0, 0, .1);
        border-radius: 25px;
        box-shadow: 0 0 14px 0 rgba(0, 0, 0, .16);
        cursor: pointer;
        text-decoration: none;
        content: '...';
        background-color: #ff575b;
        color: #fff;
        text-align: center;
        line-height: 50px;
        font-weight: bold;
        font-family: 'Helvetica Neue', Helvetica, Arial, 'Hiragino Sans GB', 'Microsoft YaHei', sans-serif;
    }
    #MEIQIA-PANEL-HOLDER-MASK img {
        width: 20px;
        height: 20px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -10px;
        margin-top: -10px;
    }
</style>
<script type='text/javascript'>
    $('body').append('<div id="MEIQIA-PANEL-HOLDER-MASK"><img src="/static/img/mod/meiqia/btn-meiqia@2x.png" alt="" /></div>');
    $('#MEIQIA-PANEL-HOLDER-MASK').on('click', function () {
        var _this = this;
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
        _MEIQIA('allSet', function () {
            $(_this).remove();
            _MEIQIA._SHOWPANEL()
        });
    });
</script>