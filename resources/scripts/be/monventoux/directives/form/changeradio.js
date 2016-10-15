app.directive('changeradio', [
    function() {
        return {
            restrict : 'A',
            link     : function(scope, element, attrs) {

                element.on('click', function() {
                    $('.' + attrs.show).removeClass('hide');
                    $('.' + attrs.hide).addClass('hide');
                });
            }
        }
    }
]);