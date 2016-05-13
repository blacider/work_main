(function() {
    var exchangeRate = angular.module('exchangeRate', []);
    exchangeRate.service('exchangeRateService', function() {
        this.rateMap = {
            'cny': '￥',
            'usd': '$',
            'eur': '€',
            'hkd': '$',
            'mop': '$',
            'twd': '$',
            'jpy': '￥',
            'ker': '₩',
            'gbp': '£',
            'rub': '₽',
            'sgd': '$',
            'php': '₱',
            'idr': 'Rps',
            'myr': '$',
            'thb': '฿',
            'cad': '$',
            'aud': '$',
            'nzd': '$',
            'chf': '₣',
            'dkk': 'Kr',
            'nok': 'Kr',
            'sek': 'Kr',
            'brl': '$'
        };
    });
}());