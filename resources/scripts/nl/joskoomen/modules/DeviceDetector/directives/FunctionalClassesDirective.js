detector.directive('functionalClasses', ['jkDetectionClassesService', '_',
    function(service, _) {
        return {
            restrict : 'AC',
            link     : function(scope, element) {
                var fClasses = service.getFunctionalClasses();
                _.each(fClasses, function(f) {
                    _.each(f.split(','), function(c) {
                        element.addClass(c);
                    });
                });
            }
        };
    }]);