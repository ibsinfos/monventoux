detector.directive('deviceClass', ['jkDetectionClassesService', '_',
    function(service, _) {
        return {
            restrict : 'AC',
            link     : function(scope, element) {
                var deviceClasses = service.getDeviceClass().split(',');
                _.each(deviceClasses, function(c) {
                    element.addClass(c);
                });

            }
        };
    }]);