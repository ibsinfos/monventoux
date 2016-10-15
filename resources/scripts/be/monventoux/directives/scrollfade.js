app.directive('scrollfade', [

    '_',
    'jkBroadcastService',
    'Broadcasts',

    function(_, broadcastCenter, Broadcasts) {

        return {
            restrict : 'A',
            link     : function(scope, element) {

                broadcastCenter.$on(Broadcasts.WINDOW_SCROLL_EVENT, scope, function() {
                    var value = $(window).scrollTop();
                    if(value < 100) {
                        value = (100 - value) / 100;
                        element.css({'opacity' : value});
                        if(value <= 0) {
                            element.css({'opacity' : 1});
                        }
                    }
                    else {
                        element.css({'opacity' : 0});
                    }
                });
            }
        };
    }]);