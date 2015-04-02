$('document').ready(function(){
        $.getJSON(__BASEURL + 'api/classroom/lists', function(data){
            var _count = data['total'];
            var _data = data['data'];
            var _tbl = '';
            for(var i = 0; i < _count; i++){
            _tbl += '<tr>';
            var j = _data[i];
            _tbl += '<td>'+j['teacher_name']+'</td><td>'+j['classroom_name']+'</td><td>'+j['stu_num']+'</td><td>'+j['start_time']+'</td><td>'+j['end_time']+'</td><td>'+j['class_intro']+'</td><td><a class="module_image" data-id="' + j['id'] + '"><i class="icon-flag"></i></a><a href="' + __BASEURL + 'admin/classroom/del?i=' + j['id'] + '"><i class="icon-trash"></i></a>';
            _tbl += '</tr>';
            }
            $('#subjects').append(_tbl); 
            $('.datetimepicker1').datetimepicker({
                   format: "yyyy-mm-dd hh:ii"
                   });
            $('.datetimepicker2').datetimepicker({
                   format: "yyyy-mm-dd hh:ii"
                   });
            $('.module_image').each(function(){
                $(this).click(function(){
                    var _id = $(this).data('id');
                    $('#hgid').val(_id);
                    $('#module_thumb_image').modal();
                });
            });
        });
});
