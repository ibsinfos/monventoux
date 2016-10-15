app.factory('ApiService', ['$q', '$http', function($q, $http) {

    function _token() {
        var _defer = $q.defer();
        var _tried;
        var _feed;

        $http.get('/token.php').then(
            //success
            function(res) {
                _feed = res.data;
                _defer.resolve(_feed);
            },
            //fail
            function() {
                if(_tried < 5) {
                    _tried++;
                    return _token();
                }
                else {
                    _defer.reject();
                }
            }
        );

        return _defer.promise;
    }


    function _post(file) {
        var _defer = $q.defer();
        var _tried;
        var _feed;

        $http.post('/' + file + '.php').then(
            //success
            function(res) {
                _feed = res.data;
                _defer.resolve(_feed);
            },
            //fail
            function() {
                if(_tried < 5) {
                    _tried++;
                    return _post(file);
                }
                else {
                    _defer.reject();
                }
            }
        );

        return _defer.promise;
    }

    return {

        getToken    : function() {
            return _token();
        },
        postRequest : function(file) {
            return _post(file);
        },
    };
}
]);