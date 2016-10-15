app.directive('required', [
    function() {
        return {
            restrict : 'A',
            link     : function(scope, element) {

                element.on('invalid', function() {

                    var self = element[0];

                    if(self.value == '') {
                        self.setCustomValidity('Dit veld is verplicht');
                    }
                    else {
                        self.setCustomValidity('');
                    }
                    return true;
                });
            }
        }
    }
]);