app.directive('mediaOverlay', [
    function() {
        return {
            restrict : 'A',
            link     : function(scope, element, attrs) {

                scope.$on('showOverlay', function(event, params) {

                    if(params[0] == 'video') {
                        element.find('iframe').attr('src', params[1]);
                    }
                    else {
                        //image
                        element.find('img').attr('src', params[1]);
                    }
                    element.removeClass('image video hide').addClass(params[0]);
                });

                scope.$on('hideOverlay', function() {
                    element.removeClass('image video').addClass('hide');
                    element.find('iframe').attr('src', '');
                    element.find('img').attr('src', '');
                });
            }
        };
    }]);