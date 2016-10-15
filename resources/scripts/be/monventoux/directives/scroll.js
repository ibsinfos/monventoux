app.directive('scroll', ['_', 'jkBroadcastService', 'Broadcasts',
    function(_, broadcastCenter, Broadcasts) {

        var scrollHandler = function(e) {
            broadcastCenter.$broadcast(Broadcasts.WINDOW_SCROLL_EVENT, [e]);
        };

        var throttledHandler = _.throttle(scrollHandler, 50);

        return {
            restrict : 'A',
            link     : function(scope) {
                $(window).on('scroll', throttledHandler);
                scope.$on('$destroy', function() {
                    $(window).off('scroll', throttledHandler);
                });

            }
        };
    }]);