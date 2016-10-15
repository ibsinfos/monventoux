detector.directive('browserClass', ['jkDetectionClassesService', '_',
    function(service, _) {
        return {
            restrict : 'AC',
            link     : function(scope, element) {
                var browserClasses = service.getBrowserClass().split(',');
                _.each(browserClasses, function(c) {
                    element.addClass(c);
                });

            }
        };
    }]);