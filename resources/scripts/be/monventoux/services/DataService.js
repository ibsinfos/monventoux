app.factory('DataService', ['$q', '$http', function($q, $http) {

    function _loadJSON(file) {
        var _defer = $q.defer();
        var _tried;
        var _feed;

        $http.get('assets/json/' + file).then(
            //success
            function(res) {
                _feed = res.data;
                _defer.resolve(_feed);
            },
            //fail
            function() {
                if(_tried < 5) {
                    _tried++;
                    return _loadJSON(file);
                }
                else {
                    _defer.reject();
                }
            }
        );

        return _defer.promise;
    }

    return {

        loadHomeData : function() {
            return _loadJSON('home.json');
        },
        loadMainData : function() {
            return _loadJSON('main.json');
        },
        loadEventData : function() {
            return _loadJSON('event.json');
        },
        loadMatchData : function() {
            return _loadJSON('match.json');
        }


    };
}
]);