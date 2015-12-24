$(document).ready(function() {
    // 列表界面
    hookEnabledSwitch();
    hookDeleteButton();

    // 编辑界面
    hookSwitch();
    hookTagAdd();
    hookTagRemove();
    hookTree();
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

function hookTree() {
    $('.tree').each(function() {
        var value = $(this).prev('input[type=hidden]').val();
        var ids = JSON.parse(value);

        for (var i = 0; i < ids.length; i++) {
            var id = ids[i];
            var node = $(this).find('li[data-id=' + id + ']');
            setNode(node, 'checked', true);
        }
    });

    $('.tree li > span').dblclick(function() {
        var _li = $(this).closest('li');
        if ($(_li).find('ul').length) {
            $(_li).toggleClass('open');
        }
    });

    $('.tree li > .indicator').click(function() {
        $(this).closest('li').toggleClass('open');
    });

    $('.tree li > .checkstate').click(function() {
        var _li = $(this).closest('li');
        var state = getNodeState(_li);
        var dest = 'checked';
        if (state == 'checked') {
            dest = 'unchecked';
        }

        setNode(_li, dest, true);
        saveTree(_li);
    });
}

function setNode(node, state, related) {
    var checkbox = $(node).find(' > div.checkstate');
    var id = $(node).data('id');
    console.log('change ' + id + ' to ' + state);
    checkbox.removeClass('unchecked').removeClass('checked').removeClass('mixed').addClass(state);

    if (related) {
        setChildren(node, state);
        setParent(node, state);
    }
}

function getNodeState(node) {
    var checkbox = $(node).find(' > div.checkstate');
    if (checkbox.is('.checked')) {
        return 'checked';
    } else if (checkbox.is('.mixed')) {
        return 'mixed';
    } else {
        return 'unchecked';
    }
}

function toggle(node) {
    var checkbox = $(node).find(' > div.checkstate');
    var src = getNodeState(node);
    var id = $(node).data('id');
    console.log('change ' + id + ' to ' + dest);
    checkbox.removeClass(src).addClass(dest);
    return dest;
}


function setParent(node, state) {
    var parent = $(node).parent().closest('.tree li').get(0);
    if (parent) {
        var state = calcNodeState(parent);
        setNode(parent, state);
        setParent(parent, state);
    }
}

function calcNodeState(node) {
    var children = $(node).find(' > ul > li').has(' > .checkstate');
    
    var count = children.length;
    var countChecked = children.has(' > .checked').length;
    var countUnchecked = children.has(' > .unchecked').length;
    var countMixed = children.has(' > .mixed').length;

    if (count == countChecked) {
        return 'checked';
    } else if (count == countUnchecked) {
        return 'unchecked';
    } else {
        return 'mixed';
    }
}

function setChildren(node, state) {
    console.assert(state != 'mixed');

    $(node).find('ul > li').each(function() {
        setNode(this, state);
        setChildren(this, state);
    });
}

function saveTree(node) {
    var tree = $(node).closest('.tree');
    var ids = [ ];
    var sobs = tree.find(' > li');

    for (var i = 0; i < sobs.length; i++) {
        var sob = sobs[i];
        var state = getNodeState(sob);

        console.log('sob ' + $(sob).find(' > span').text() + ' was ' + state);

        if (state == 'unchecked') 
            continue;

        var categories = $(sob).find('> ul > li');
        for (var j = 0; j < categories.length; j++) {
            var cate = categories[j];
            var state = getNodeState(cate);
            
            console.log('category ' + $(cate).find(' > span').text() + ' was ' + state);

            if (state == 'unchecked') 
                continue;

            if (state == 'checked') {
                ids.push($(cate).data('id'));
                continue;
            }

            var sub_categories = $(cate).find(' > ul > li');
            for (var l = 0; l < sub_categories.length; l++) {
                var sub_cate = sub_categories[l];
                var state = getNodeState(sub_cate);
                
                console.log('sub category ' + $(sub_cate).find('> span').text() + ' was ' + state);
                if (state == 'checked') {
                    ids.push($(cate).data(id));
                }
            }
        }
    }

    $(tree).prev('input[type=hidden]').val(JSON.stringify(ids));
}
