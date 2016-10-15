detector.directive('osClass', ['jkDetectionClassesService', '_',
    function(service, _) {
        return {
            restrict : 'AC',
            link     : function(scope, element) {
                var osClasses = service.getOSClass().split(',');
                _.each(osClasses, function(c) {
                    element.addClass(c);
                });
            }
        };
    }]);