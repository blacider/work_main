$('document').ready(function(){
        $.getJSON(__BASEURL + 'api/stu_course/lists', function(data){
            var _user_type = data['user_type'];
            var _count = data['total'];
            var _data = data['data'];
            var _tbl = '';
            for(var i = 0; i < _count; i++){
            _tbl += '<tr>';
            var j = _data[i];
            _tbl += '<td>'+j['teacher_name']+'</td><td>'+j['classroom_name']+'</td><td>'+j['stu_num']+'</td><td>'+j['start_time']+'</td><td>'+j['end_time']+'</td><td>'+j['class_intro']+'</td><td><a href="' + __BASEURL + 'admin/stu_course/join_room/'+j['id'] + '">上课</a></td><td><a href="' + __BASEURL + 'admin/stu_course/del?i=' + j['id'] + '">删除</a></td>';
            _tbl += '</tr>';
            }
            $('#stud_subjects').append(_tbl);
           if(_user_type == "stu")
           {
                $('#stu').show();
           } 
        });

           // $('#teach').hide();
        $.getJSON(__BASEURL + 'api/stu_course/teach_lists', function(data){
            var _user_type = data['user_type'];
            var _count = data['teach_total'];
            var _data = data['teach_data'];
            var _tbl = '';
            for(var i = 0; i < _count; i++){
            _tbl += '<tr>';
            var j = _data[i];
            _tbl += '<td>'+j['teacher_name']+'</td><td>'+j['classroom_name']+'</td><td>'+j['stu_num']+'</td><td>'+j['start_time']+'</td><td>'+j['end_time']+'</td><td>'+j['class_intro']+'</td><td><a href="' + __BASEURL + 'admin/stu_course/join_room/'+j['id'] + '">上课</a></td>';
            _tbl += '</tr>';
            }
            $('#teach_subjects').append(_tbl);
           if(_user_type == "teach")
           {
                $('#teach').show();
           } 

        });

});
