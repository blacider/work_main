<script src="/static/ace/js/jquery.colorbox-min.js"></script>

<!-- page specific plugin styles -->
<link rel="stylesheet" href="/static/ace/css/colorbox.css" />





<div class="page-content">
    <div class="page-content-area">
        <form role="form" class="form-horizontal"  enctype="multipart/form-data" >
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">金额</label>
                                <div class="col-xs-9 col-sm-9">
                                    <label> ￥ <?php echo $item['amount']; ?> </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">分类</label>
                                <div class="col-xs-9 col-sm-9">
                                    <label> <?php echo $item['category']; ?> </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">消费时间</label>
                                <div class="col-xs-9 col-sm-9">
                                    <label> <?php echo $item['dt']; ?> </label>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">商家</label>
                                <div class="col-xs-9 col-sm-9">
                                    <label> <?php echo $item['merchants']; ?> </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">标签</label>
                                <div class="col-xs-9 col-sm-9">

                                    <label> <?php echo $item['tags']; ?> </label>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">类型</label>
                                <div class="col-xs-9 col-sm-9">
                                    <label> <?php echo $item['prove_ahead']; ?> </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">留言</label>
                                <div class="col-xs-9 col-sm-9">
                                    <label> <?php echo $item['note']; ?> </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">照片</label>
                                <div class="col-xs-9 col-sm-9 ">
                                    <div class="fallback">
                                        <?php foreach($item['images'] as $i){ ?>
                                        <div class="col-xs-6 col-md-3">
                                            <a href="<?php echo $i['path']; ?>" class="thumbnail" data-rel="colorbox">
                                                <img src="<?php echo $i['path']; ?>" >
                                            </a>
                                        </div>
                                        <?php  } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 10px;min-weight:40px;">
                                <center>
                                    <button class="btn gray" onclick="javascript:history.go(-1);">返回</button>
                                    <a class="btn btn-success" href="<?php echo base_url('/items/edit/' . $item['id']); ?>">修改</a>
                                </center>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
$(document).ready(function(){
    var $overflow = '';
    var colorbox_params = {
        rel: 'colorbox',
            reposition:true,
            scalePhotos:true,
            scrolling:false,
            previous:'<i class="ace-icon fa fa-arrow-left"></i>',
            next:'<i class="ace-icon fa fa-arrow-right"></i>',
            close:'&times;',
            current:'{current} of {total}',
            maxWidth:'100%',
            maxHeight:'100%',
            onOpen:function(){
                $overflow = document.body.style.overflow;
                document.body.style.overflow = 'hidden';
            },
                onClosed:function(){
                    document.body.style.overflow = $overflow;
                },
                    onComplete:function(){
                        $.colorbox.resize();
                    }
    };

    $('.fallback [data-rel="colorbox"]').colorbox(colorbox_params);
});
</script>
