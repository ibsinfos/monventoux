/*
 global baseurl
 */
app.controller('ImagesController', [

    '$scope',

    function($scope) {

        $scope.showOverlay = function(type, src) {
            $scope.$broadcast('showOverlay', [type, src]);
        };

        $scope.closeOverlay = function() {
            $scope.$broadcast('hideOverlay');
        }
    }]);

