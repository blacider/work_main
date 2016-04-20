(function(exports) {
    exports.Utils = {
        nextTick: function(fn, delay) {
            setTimeout(function() {
                fn()
            }, delay || 0);
        },
        uid: function  () {
              function s4() {
                return Math.floor((1 + Math.random()) * 0x10000)
                  .toString(16)
                  .substring(1);
              }
              return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
                s4() + '-' + s4() + s4() + s4();
        },
        size: function  (obj, valid) {
            var count = 0;
            for(var i in obj) {
                if(obj[i] && valid) {
                    count++;
                }
            }
            return count;
        },
        queryString: function(string) {
            var parsed = {};
            string = (string !== undefined) ? string : window.location.search;
            if (typeof string === "string" && string.length > 0) {
                if (string[0] === '?') {
                    string = string.substring(1);
                }
                string = string.split('&');
                for (var i = 0, length = string.length; i < length; i++) {
                    var element = string[i],
                        eqPos = element.indexOf('='),
                        keyValue, elValue;
                    if (eqPos >= 0) {
                        keyValue = element.substr(0, eqPos);
                        elValue = element.substr(eqPos + 1);
                    } else {
                        keyValue = element;
                        elValue = '';
                    }
                    elValue = decodeURIComponent(elValue);
                    if (parsed[keyValue] === undefined) {
                        parsed[keyValue] = elValue;
                    } else if (parsed[keyValue] instanceof Array) {
                        parsed[keyValue].push(elValue);
                    } else {
                        parsed[keyValue] = [parsed[keyValue], elValue];
                    }
                }
            }
            return parsed;
        },
        JSONParse: function(string) {
            return (new Function('return ' + string))();
        },
        api: function(url, opts) {
            var def = $.Deferred();
            var hostname = 'https://api.cloudbaoxiao.com';

            var regSlashStart = /^\//;

            if(regSlashStart.test(url)) {
                url = url.replace(regSlashStart, '');
            }

            opts = $.extend({
                method: 'get',
                dataType: 'json',
                data: {},
                onError: function(rs) {
                    try {
                        var msg = rs['data']['msg'] || JSON.stringify(rs);
                        console.error(msg);
                    } catch(e) {}
                }
            }, opts);

            if(opts['env']) {
                // 防止线上代码用错api分支，wow
                if(location.host.indexOf('yunbaoxiao.com')>=0) {
                    opts['env'] = 'online';
                }
                url = [hostname, opts['env'], url].join('/');
            } else {
                url = '/' +  url;
            }

            $.ajax({
                method: opts['method'],
                dataType: opts['dataType'],
                url: url,
                headers: {
                    'X-REIM-JWT': window.__CBX_UTOKEN__
                },
                data: opts['data'],
                success: function(rs, succ) {
                    if (opts['dataType'] == 'text') {
                        return def.resolve.apply(null, arguments);
                    }
                    if (rs['status'] <= 0) {
                        opts.onError(rs)
                    }
                    def.resolve(rs);
                },
                error: function(e, opts) {
                    console.error('request error');
                    def.resolve.apply(null, arguments);
                }
            });
            return def.promise();
        },
        // 判断一个对象是否包含全部的kv
        isObjectContained: function (obj, kv) {
            for(pro in kv) {
                if(obj[pro] !== kv[pro]) {
                    return false;
                }
            }
            return true;
        },
        //批量更新数组
        updateArrayByQuery: function (arr, query, operation) {
            var rs = [];
            for(var i=0;i<arr.length;i++) {
                var item = arr[i];
                if(Utils.isObjectContained(item, query)) {
                    rs.push(rs);
                    if(typeof operation=='function') {
                        $.extend(item, operation());
                    } else {
                        $.extend(item, operation);
                    }
                }
            }
            return rs;
        }
    }
})(window);