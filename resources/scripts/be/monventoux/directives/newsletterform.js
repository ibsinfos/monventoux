app.directive('newsletterform', [
    function() {
        return {
            restrict : 'EA',
            link     : function(scope, element) {
                element.on('submit', function(e) {
                    e.preventDefault();
                    scope.postForm();
                });
            }
        };
    }]);