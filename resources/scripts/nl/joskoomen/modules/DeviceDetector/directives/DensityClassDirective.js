detector.directive('densityClass', ['jkDetectionClassesService', '_',
    function(service, _) {
        return {
            restrict : 'AC',
            link     : function(scope, element) {
                var densityClasses = service.getDensityClass().split(',');
                _.each(densityClasses, function(c) {
                    element.addClass(c);
                });

            }
        };
    }]);