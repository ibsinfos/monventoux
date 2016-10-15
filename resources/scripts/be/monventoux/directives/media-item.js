app.directive('mediaItem', [
    function() {
        return {
            restrict : 'A',
            link     : function(scope, element, attrs) {
                element.on('click', function(e) {
                    e.preventDefault();

                    scope.showOverlay(attrs.type, attrs.href);
                    //                    var overlay = $('.media-overlay');
                    //                    overlay.addClass(attrs.type);
                })
            }
        };
    }]);