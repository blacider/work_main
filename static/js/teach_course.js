$('document').ready(function(){
        $.getJSON(__BASEURL + 'api/stu_course/teach_lists', function(data){
            var _count = data['teach_total'];
            var _data = data['teach_data'];
            var _tbl = '';
            for(var i = 0; i < _count; i++){
            _tbl += '<tr>';
            var j = _data[i];
            _tbl += '<td>'+j['teacher_name']+'</td><td>'+j['classroom_name']+'</td><td>'+j['stu_num']+'</td><td>'+j['start_time']+'</td><td>'+j['end_time']+'</td><td>'+j['class_intro']+'</td><td><a href="' + __BASEURL+ 'admin/stu_course/open?i=' + j['id'] + '">上课</a></td>';
            _tbl += '</tr>';
            }
            $('#teach_subjects').append(_tbl); 
        });
       // $('#stu').hide();

});
