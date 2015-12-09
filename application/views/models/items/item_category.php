<div class="form-group">
	<label class="col-sm-1 control-label no-padding-right">类别</label>

	<div class="col-xs-3 col-sm-3" style="margin-top:2px">
		<select class="form-control chosen-select" name="sob" id="sobs">
		</select>
	</div>

	<div class="col-xs-3 col-sm-3" style="margin-top:2px;">
		<select class="sob_category chosen-select" name="category" id="sob_category" data-placeholder="类别">
		</select>
	</div>
</div>
<script type="text/javascript">
function updateSelectSob(data) {
    $("#sobs").empty();
    $("#sobs").append(data);
    $("#sobs").trigger('change');
    $("#sobs").trigger("chosen:updated");
}
function get_sobs(){
    var selectPostData = {};
    var selectDataCategory = {};
    var selectDataSobs = '';
    $.ajax({
        url : __BASE + "category/get_my_sob_category",
        dataType : 'json',
        method : 'GET',
        success : function(data){
            console.log(data);
            for(var item in data) {
                var _h = "<option value='" +  item + "'>"+  data[item].sob_name + " </option>";
                selectDataCategory[item] = data[item]['category'];
                selectDataSobs += _h;
            }
            selectPostData = data;
            updateSelectSob(selectDataSobs);
        },
        error:function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrownr);
        }
    });


    $('#sobs').change(function(){
        var s_id = $(this).val();
        var _h = '';
        if(selectDataCategory[s_id] != undefined)
        {
            for(var i = 0 ; i < selectDataCategory[s_id].length; i++)
            {
                var parent_name = '';
                if(selectDataCategory[s_id][i]['children']!=undefined)
                {
                    parent_name = selectDataCategory[s_id][i]['category_name'];
                    _h+="<optgroup style='font-style: normal;' label='"+ parent_name +"'>"
                    for(var j = 0 ; j < selectDataCategory[s_id][i]['children'].length; j++)
                    {
                        _h+="<option data-parent='" + parent_name + "' data-name='" + selectDataCategory[s_id][i]['children'][j]['category_name'] + "' value='" +  selectDataCategory[s_id][i]['children'][j]['id'] + "'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + selectDataCategory[s_id][i]['children'][j]['category_name'] + " </option>";
                    }
                    _h+="</optgroup>";
                }
                else
                {
                    _h += "<option data-parent='' data-name='" + selectDataCategory[s_id][i].category_name + "' value='" +  selectDataCategory[s_id][i].id + "'>" +selectDataCategory[s_id][i].category_name + " </option>";
                }   
            }
        }
        var selectDom = this.parentNode.nextElementSibling.children[0]
        $(selectDom).empty().append(_h).trigger("chosen:updated");
        $('#sob_category').trigger('change');
        $('#sob_category').trigger('change:updated');
    });

    $('#sob_category').each(function(){
        $(this).change(function(){
            var pre_cate = $('.cate_selected',$(this));
            var pre_parent = pre_cate.data('parent');
            var pre_name = pre_cate.data('name');
            if(pre_parent)
            {
                pre_cate.html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + pre_name);
            }
            $('.cate_selected',$(this)).removeClass('cate_selected');
            var selected_cate = $('option:selected',$(this));
            var selected_cate_parent = selected_cate.data('parent');
            var selected_cate_name = selected_cate.data('name');
            selected_cate.prop('class','cate_selected').trigger('chosen:updated');
            if(selected_cate_parent)
            {
                $(this).next().find('span').text(selected_cate_parent+'-'+selected_cate_name);
            }

        });
    });
}
$(document).ready(function(){
	get_sobs();
});

</script>