(function(exports) {
	// ie8 check
	var CONST_LTE_IE8 = (function(userAgent) {
	    if (/MSIE\s+(6|7|8)\.0/.test(userAgent)) {
	        return true;
	    };
	    return false;
	})(navigator.userAgent);

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
            var host = window._CONST_API_DOMAIN_;
            // ie8 XDomainRequest CORS不支持 headers 和 get post 之外的方法
            if(CONST_LTE_IE8) {
            	host = location.protocol + '//' +  location.host;
            }

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
                        console.error(url, JSON.stringify(rs));
                    } catch(e) {}
                }
            }, opts);

            if(opts['cors']) { //true of false
                // ie8 XDomainRequest CORS不支持 headers 和 get post 之外的方法
                if(!host) {
                	return console.error(new Error('no api host is config'));
                }
                if(CONST_LTE_IE8) {
	                url = [host, 'apiproxy', url].join('/');
                } else {
                	url = host + url;
                	console.log('cors', opts.cors, url);
                }
            } else {
                url = '/' +  url;
            }

            var token = (opts['token']) ? opts['token'] : window.__USER_ACCESS_TOKEN__;
            $.ajax({
                type: opts['method'],
                dataType: opts['dataType'],
                url: url,
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'X-admin-api': 1
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
