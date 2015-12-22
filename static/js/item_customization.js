$(document).ready(function() {
    // 列表界面
    hookEnabledSwitch();
    hookDeleteButton();

    // 编辑界面
    hookSwitch();
    hookTagAdd();
    hookTagRemove();
});

function hookEnabledSwitch() {
    $('.toggle-enabled').click(function() {
        var id = $(this).closest('tr').data('id');
        var enabled = ($(this).is(':checked') ? 1 : 0)
        var title = $(this).closest('tr').find('td[data-column=title]').text();
        $.ajax({
            url: __BASE + '/item_customization/toggle/' + id,
            method: 'POST',
            dataType: 'JSON',
            data: {
                enabled: enabled
            },
            success: function (data, status, xhr){
                console.log(data);
                if (data['status']) {
                    enabled = data['data']['enabled'];
                    var msg = '字段⎡' + title + '⎦已' + (enabled ? '启用' : '禁用');
                    console.log('notification: ' + msg);
                    show_notify(msg);
                } else {
                    var msg = data['data']['msg'];
                    console.log('notification: ' + msg);
                    show_notify(msg);
                }
            },
            error: function (xhr, status, error) {
                var msg = "切换字段状态时出错：" + error;
                console.log('notification: ' + msg);
                show_notify(msg);
            }
        });
    });
}

function hookDeleteButton() {
    $('.delete_field').click(function() {
        var id = $(this).closest('tr').data('id');
        var title = $(this).closest('tr').find('td[data-column=title]').text();

        var confirmed = confirm('删除的字段不可恢复，确认要删除字段⎡' + title + '⎦吗？');
        if (!confirmed)
            return;

        $.ajax({
            url: __BASE + '/item_customization/delete/' + id,
            method: 'DELETE',
            success: function (data, status, xhr){
                console.log(data);
                if (data['status']) {
                    $(this).closest('tr').remove();
                    var msg = '字段⎡' + title + '⎦已删除';
                    console.log('notification: ' + msg);
                    show_notify(msg);
                } else {
                    var msg = data['data']['msg'];
                    console.log('notification: ' + msg);
                    show_notify(msg);
                }
            },
            error: function (xhr, status, error) {
                var msg = "删除字段时出错：" + error;
                console.log('notification: ' + msg);
                show_notify(msg);
            }
        });
    });
}


function hookSwitch() {
    var chks = $('form input[type="checkbox"]');
    chks.each(function() {
        var val = $(this).is(':checked') ? 1 : 0;
        $(this).before('<input type="hidden" name="' + $(this).attr('name') + '" value="' + val + '" />');
        $(this).removeAttr('name');
    });
    chks.change(function() {
        var val = $(this).is(':checked') ? 1 : 0;
        $(this).prev('input[type="hidden"]').val(val);
    });
}

function hookTagAdd() {
    $('#tag-add').click(function() {
        var text = $('#tag-input').val();
        text = text.trim();
        if (!text)
            return;

        var lastIndex = $('ul.chosen-choices li:last').data('index');
        if (lastIndex == undefined) {
            lastIndex = 0;
        }

        var _li = $('<li></li>', { 'class': 'search-choice', 'data-index': lastIndex + 1 });
        _li.append($('<input />', { 'type': 'hidden', 'name': 'extra[' + (lastIndex + 1) + '][id]', 'value': 0 }));
        _li.append($('<input />', { 'type': 'hidden', 'name': 'extra[' + (lastIndex + 1) + '][name]', 'value': text }));
        _li.append($('<span></span>').text(text));
        _li.append($('<a></a>', { class: 'search-choice-close' }));
            
        $('ul.chosen-choices').append(_li);
        $('#tag-input').val('');
    });
}

function hookTagRemove() {
    $('.search-choice-close').click(function() {
        var _li = $(this).closest('li');
        var text = $(_li).find('span').text();
        var confirmed = confirm('确认删除标签⎡' + text + '⎦吗？');
        if (!confirmed)
            return;

        $(_li).remove();
    });
}
