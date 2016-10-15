app.directive('resize', [

    '_',
    'jkBroadcastService',
    'Broadcasts',

    function(_, broadcastCenter, Broadcasts) {

        var resizeHandler = function() {
            broadcastCenter.$broadcast(Broadcasts.WINDOW_RESIZE_EVENT);
            broadcastCenter.$broadcast(Broadcasts.WINDOW_SCROLL_EVENT);
        };

        var throttledHandler = _.throttle(resizeHandler, 50);

        return {
            restrict : 'A',
            link     : function(scope) {
                $(window).on('resize', throttledHandler);
                scope.$on('$destroy', function() {
                    $(window).off('resize', throttledHandler);
                });

            }
        };
    }]);