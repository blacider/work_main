$('document').ready(function(){
        $.getJSON(__BASEURL + 'api/con_course/lists', function(data){
            var _count = data['total'];
            var _data = data['data'];
            var _tbl = '';
            for(var i = 0; i < _count; i++){
            _tbl += '<tr>';
            var j = _data[i];
            _tbl += '<td>'+j['teacher_name']+'</td><td>'+j['classroom_name']+'</td><td>'+j['stu_num']+'</td><td>'+j['start_time']+'</td><td>'+j['end_time']+'</td><td>'+j['class_intro']+'</td><td><a href="' + __BASEURL + 'admin/con_course/con?i=' + j['id'] + '">关注</a>';
            _tbl += '</tr>';
            }
            $('#subjects').append(_tbl); 
        });
});
