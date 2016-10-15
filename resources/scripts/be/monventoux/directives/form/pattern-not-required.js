app.directive('patternNotRequired', [
    function() {

        function validate(element, patternerrormsg) {

            if(element.validity.patternMismatch) {
                element.setCustomValidity(patternerrormsg);
            }
            else {
                element.setCustomValidity('');
            }
        }

        return {
            restrict : 'A',
            link     : function(scope, element, attrs) {
                if(element.value != '') {
                    element.on('invalid', function() {
                        validate(element[0], attrs.patternerrormsg);
                        return true;
                    });

                    element.on('blur', function() {
                        validate(element[0], attrs.patternerrormsg);
                        return true;
                    });
                    element.on('input', function() {
                        validate(element[0], attrs.patternerrormsg);
                        return true;
                    });
                }
            }
        }
    }
]);