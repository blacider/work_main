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
            lastIndex = -1;
        }

        var _li = $('<li></li>', { 'class': 'search-choice', 'data-index': lastIndex + 1 });
        _li.append($('<input />', { 'type': 'hidden', 'name': 'extra[options][' + (lastIndex + 1) + '][id]', 'value': 0 }));
        _li.append($('<input />', { 'type': 'hidden', 'name': 'extra[options][' + (lastIndex + 1) + '][name]', 'value': text }));
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
    // 初始化树选择
    $('.tree').each(function() {
        var value = $(this).prev('input[type=hidden]').val();
        var ids = JSON.parse(value);

        // [0] 代表全选
        if (ids.length == 1 && ids[0] == 0) {
            $(this).find(' > li').each(function() {
                setNode(this, 'checked', true);
            });
        }

        // 按照选择设置
        for (var i = 0; i < ids.length; i++) {
            var id = ids[i];
            var node = $(this).find('li[data-id=' + id + ']');
            setNode(node, 'checked', true);
        }
    });

    // 双击展开树
    $('.tree li > span').dblclick(function() {
        var _li = $(this).closest('li');
        if ($(_li).find('ul').length) {
            $(_li).toggleClass('open');
        }
    });

    // 点击切换树选择
    $('.tree li > .indicator').click(function() {
        $(this).closest('li').toggleClass('open');
    });

    // 点击切换选择状态
    $('.tree li > .checkstate').click(function() {
        var _li = $(this).closest('li');
        var state = getNodeState(_li);
        var dest = 'checked';
        if (state == 'checked') {
            dest = 'unchecked';
        }

        // 关联设置
        setNode(_li, dest, true);
        saveTree(_li);
    });
}

// related: 是否影响关联节点
function setNode(node, state, related) {
    var checkbox = $(node).find(' > div.checkstate');
    var id = $(node).data('id');
    // console.log('change ' + id + ' to ' + state);
    checkbox.removeClass('unchecked').removeClass('checked').removeClass('mixed').addClass(state);

    // 如果target-tree 那么就要影响required-tree
    if ($(node).closest('.tree').is('#target-tree')) {
        var related_node = $('#required-tree').find('li[data-id=' + id + ']');
        if (state == 'checked' || state == 'mixed') {
            related_node.removeClass('missing');
        } else {
            related_node.addClass('missing');
            //setNode(related_node, 'unchecked', true);
            saveTree(related_node);
        }
    }

    // 如果影响关联节点就设置父节点和子节点
    if (related) {
        setChildren(node, state);
        setParent(node, state);
    }
}

// 获取节点当前状态
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

function setParent(node, state) {
    var parent = $(node).parent().closest('.tree li').get(0);
    // 父节点可能不存在
    if (parent) {
        var state = calcNodeState(parent);
        // 设置父节点
        setNode(parent, state);
        // 递归设置祖父节点
        setParent(parent, state);
    }
}

// 根据子节点的选择状态计算当前状态
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

    // 遍历设置所有子节点
    $(node).find('ul > li').each(function() {
        setNode(this, state);
        // 递归子节点
        setChildren(this, state);
    });
}

function saveTree(node) {
    var tree = $(node).closest('.tree');
    var ids = [ ];

    // 取帐套节点
    var sobs = tree.find(' > li');

    // 检测是否全选状态
    var allchecked = true;
    for (var i = 0; i< sobs.length; i++) {
        var sob = sobs[i];
        var state = getNodeState(sob);
        if (state != 'checked') {
            allchecked = false;
            break;
        }
    }
    
    if (allchecked) {
        // 全选和 [ 0 ] 等价
        ids.push(0);
    } else {
        for (var i = 0; i < sobs.length; i++) {
            var sob = sobs[i];
            var state = getNodeState(sob);

            // console.log('sob ' + $(sob).find(' > span').text() + ' was ' + state);

            // missing 隐藏跳过保存
            if ($(sob).is('.missing'))
                continue;
            
            // 如果帐套未选中则跳过继续
            if (state == 'unchecked') 
                continue;

            // 取类别
            var categories = $(sob).find('> ul > li');
            for (var j = 0; j < categories.length; j++) {
                var cate = categories[j];
                var state = getNodeState(cate);
                
                // console.log('category ' + $(cate).find(' > span').text() + ' was ' + state);

                // missing 隐藏跳过保存
                if ($(cate).is('.missing'))
                    continue;
            
                // 跳过未选中的类别
                if (state == 'unchecked') 
                    continue;

                // 类别选中，则跳过子类别
                if (state == 'checked') {
                    ids.push($(cate).data('id'));
                    continue;
                }

                // 取二级类别
                var sub_categories = $(cate).find(' > ul > li');
                for (var l = 0; l < sub_categories.length; l++) {
                    var sub_cate = sub_categories[l];
                    var state = getNodeState(sub_cate);
                    
                    // console.log('sub category ' + $(sub_cate).find('> span').text() + ' was ' + state);

                    // missing 隐藏跳过保存
                    if ($(sub_cate).is('.missing'))
                        continue;
                    
                    // 记录选中的二级类别
                    if (state == 'checked') {
                        ids.push($(sub_cate).data('id'));
                    }
                }
            }
        }
    }
    
    $(tree).prev('input[type=hidden]').val(JSON.stringify(ids));
}
