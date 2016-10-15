app.directive('removeItemButton', [

    '_',

    function(_) {

        return {
            restrict : 'A',
            link     : function(scope, element, attr) {
                element.on('click', function(e) {
                    e.preventDefault();

                    var index = attr.index;
                    scope.remove(index);

                });

                scope.$on('$destroy', function() {
                    element.off('click');
                });

            }
        };
    }]);