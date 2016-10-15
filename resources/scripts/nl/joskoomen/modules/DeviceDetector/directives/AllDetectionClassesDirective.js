detector.directive('detectionClasses', ['jkDetectionClassesService', '_',
    function(service, _) {
        return {
            restrict : 'AC',
            link     : function(scope, element) {
                var classes = service.getFunctionalClasses();
                classes.push(service.getDeviceClass());
                classes.push(service.getDensityClass());
                classes.push(service.getBrowserClass());
                classes.push(service.getOSClass());

                _.each(classes, function(arr) {
                    _.each(arr.split(','), function(c) {
                        element.addClass(c);

                    });
                });
            }
        };
    }]);