
</div>



<!-- basic scripts -->

<!--[if !IE]> -->
<script type="text/javascript">
window.jQuery || document.write("<script src='/static/assets/js/jquery.min.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
window.jQuery || document.write("<script src='/static//assets/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
<script type="text/javascript">
if('ontouchstart' in document.documentElement) document.write("<script src='/static//assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="/static//assets/js/bootstrap.min.js"></script>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
<script src="/static//assets/js/excanvas.min.js"></script>
<![endif]-->
<script src="/static//assets/js/jquery-ui.custom.min.js"></script>
<script src="/static//assets/js/jquery.ui.touch-punch.min.js"></script>

<!-- ace scripts -->
<script src="/static//assets/js/ace-elements.min.js"></script>
<script src="/static//assets/js/ace.min.js"></script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
jQuery(function($) {
        $('.easy-pie-chart.percentage').each(function(){
            var $box = $(this).closest('.infobox');
            var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
            var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
            var size = parseInt($(this).data('size')) || 50;
            $(this).easyPieChart({
barColor: barColor,
trackColor: trackColor,
scaleColor: false,
lineCap: 'butt',
lineWidth: parseInt(size/10),
animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
size: size
});
            })

        $('.sparkline').each(function(){
            var $box = $(this).closest('.infobox');
            var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
            $(this).sparkline('html',
                {
tagValuesAttribute:'data-values',
type: 'bar',
barColor: barColor ,
chartRangeMin:$(this).data('min') || 0
});
            });


//flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
//but sometimes it brings up errors with normal resize event handlers
$.resize.throttleWindow = false;

var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
/**
  we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
  so that's not needed actually.
 */


//pie chart tooltip example
var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
var previousPoint = null;

placeholder.on('plothover', function (event, pos, item) {
        if(item) {
        if (previousPoint != item.seriesIndex) {
        previousPoint = item.seriesIndex;
        var tip = item.series['label'] + " : " + item.series['percent']+'%';
        $tooltip.show().children(0).text(tip);
        }
        $tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
        } else {
        $tooltip.hide();
        previousPoint = null;
        }

        });






var d1 = [];
for (var i = 0; i < Math.PI * 2; i += 0.5) {
    d1.push([i, Math.sin(i)]);
}

var d2 = [];
for (var i = 0; i < Math.PI * 2; i += 0.5) {
    d2.push([i, Math.cos(i)]);
}

var d3 = [];
for (var i = 0; i < Math.PI * 2; i += 0.2) {
    d3.push([i, Math.tan(i)]);
}



$('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
function tooltip_placement(context, source) {
    var $source = $(source);
    var $parent = $source.closest('.tab-content')
        var off1 = $parent.offset();
    var w1 = $parent.width();

    var off2 = $source.offset();
    //var w2 = $source.width();

    if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
    return 'left';
}


$('.dialogs,.comments').ace_scroll({
size: 300
});


//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
//so disable dragging when clicking on label
var agent = navigator.userAgent.toLowerCase();
if("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
$('#tasks').on('touchstart', function(e){
        var li = $(e.target).closest('#tasks li');
        if(li.length == 0)return;
        var label = li.find('label.inline').get(0);
        if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
        });

$('#tasks').sortable({
opacity:0.8,
revert:true,
forceHelperSize:true,
placeholder: 'draggable-placeholder',
forcePlaceholderSize:true,
tolerance:'pointer',
stop: function( event, ui ) {
//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
$(ui.item).css('z-index', 'auto');
}
}
);
$('#tasks').disableSelection();
$('#tasks input:checkbox').removeAttr('checked').on('click', function(){
        if(this.checked) $(this).closest('li').addClass('selected');
        else $(this).closest('li').removeClass('selected');
        });


//show the dropdowns on top or bottom depending on window height and menu position
$('#task-tab .dropdown-hover').on('mouseenter', function(e) {
        var offset = $(this).offset();

        var $w = $(window)
        if (offset.top > $w.scrollTop() + $w.innerHeight() - 100)
        $(this).addClass('dropup');
        else $(this).removeClass('dropup');
        });

})
</script>

<!-- the following scripts are used in demo only for onpage help and you don't need them -->
<link rel="stylesheet" href="/static//assets/css/ace.onpage-help.css" />
<link rel="stylesheet" href="/static//docs/assets/js/themes/sunburst.css" />

<script type="text/javascript">
ace.vars['base'] = '/static/';
</script>
<script src="/static//assets/js/ace/elements.onpage-help.js"></script>
<script src="/static//assets/js/ace/ace.onpage-help.js"></script>

</body>
</html>
