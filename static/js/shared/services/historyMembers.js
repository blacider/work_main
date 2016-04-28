(function() {
    /**
     * 读写历史审批人的service，用户提交时，将审批人id 存在cookie 中，选择审批人时，从这里读出之前操作过的审批人
     *
     */
    var modHistoryMembers = angular.module('historyMembers', []);

    // service is a constructor will be instanced as a singleton;
    modHistoryMembers.service('historyMembersManagerService', function() {
        this.__expires__ = 60;
        this.__prefix__ = 'history_members';
        this.key = window.__UID__ + '_' + this.__prefix__;
        this.getArray = function(members) {
            var str_ids = $.cookie(this.key) || '';
            var uids = str_ids.split(',');
            var rs = [];
            for (var i = 0; i < uids.length; i++) {
                var id = uids[i];
                var one = _.find(members, {
                    id: id
                });
                if (one) {
                    one._in_sug_ = true;
                    rs.push(one);
                }
            }
            return rs;
        };

        this.removeById = function (id) {
            var str_ids = $.cookie(this.key) || '';
            var uids = str_ids.split(',');
            var index  = uids.indexOf(id);
            uids = uids.splice(index, 1);
            $.cookie(this.key, uids.join(','), {
                expires: this.__expires__
            });
        };

        this.append = function(ids) {
            var ids = ids.split(',');
            var str_ids = $.cookie(this.key) || '';
            var uids = str_ids.split(',');
            uids = [].concat(ids, uids);
            uids = _.unique(uids);
            $.cookie(this.key, uids.join(','), {
                expires: this.__expires__
            });
        };

    });
}());