$(document).ready(function() {
    hookTable();
    hookEnabledSwitch();
    hookDeleteButton();
});

function hookTable() {
    renum_field_list();
    
    var fixHelperModified = function(e, tr) {
        var columns = tr.children();
        var helper = tr.clone();
        helper.children().each(function(index) {
            var column_width = columns.eq(index).outerWidth();
            $(this).width(column_width);
        });
        return helper;
    };

    $('#field_list tbody').sortable({
        axis: 'y',
        items: ' > tr:not([data-frozen=true])',
        helper: fixHelperModified,
        beforeStop: beforeStopMoving,
        stop: function(e, ui) {
            renum_field_list();
        }
    });
}

function beforeStopMoving(e, ui) {
    // 字段 id
    var id = $(ui.item).data('id');
    var title = $(ui.item).find('td[data-column=title]').text();
    // 目标位置 id
    var to_id = $(ui.placeholder).next('tr:not(.ui-sortable-helper)').data('id');
    if (to_id == undefined) {
        to_id = 0;
    }
    console.log('move ' + id + ' before ' + to_id);

    $.ajax({
        url: __BASE + '/item_customization/move/' + id,
        method: 'POST',
        dataType: 'JSON',
        data: {
            to: to_id
        },
        success: function (data, status, xhr) {
            console.log(data);
            if (data['status']) {
                enabled = data['data']['enabled'];
                var msg = '已移动字段⎡' + title + '⎦';
                console.log('notification: ' + msg);
                show_notify(msg);
            } else {
                var msg = data['data']['msg'];
                console.log('notification: ' + msg);
                show_notify(msg);
                $('#field_list tbody').sortable( "cancel" );
            }
        },
        failed: function(xhr, status, error) {
            var msg = "调整字段序列时出错：" + error;
            console.log('notification: ' + msg);
            show_notify(msg);
            $('#field_list tbody').sortable( "cancel" );
        },
    });
}

function renum_field_list() {
    var $rows = $('#field_list > tbody > tr');
    $rows.each(function() {
        var index = $rows.index($(this)) + 1;
        $(this).find('td:first').first().html(index);
    });
}

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
    $('table').on('click', '.delete_field', function() {
        var tr = $(this).closest('tr');
        var id = tr.data('id');
        var title = tr.find('td[data-column=title]').text();

        var confirmed = confirm('删除的字段不可恢复，确认要删除字段⎡' + title + '⎦吗？');
        if (!confirmed)
            return;

        $.ajax({
            url: __BASE + '/item_customization/delete/' + id,
            method: 'DELETE',
            success: function (data, status, xhr){
                console.log(data);
                if (data['status']) {
                    var msg = '字段⎡' + title + '⎦已删除';
                    console.log('notification: ' + msg);
                    show_notify(msg);
                    tr.remove();
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
