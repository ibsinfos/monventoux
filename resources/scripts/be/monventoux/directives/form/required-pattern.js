app.directive('requiredPattern', [
    function() {

        function validate(element, patternerrormsg) {
            if(element.value == '') {
                element.setCustomValidity('Dit veld is verplicht');
            }
            else if(element.validity.patternMismatch) {
                element.setCustomValidity(patternerrormsg);
            }
            else {
                element.setCustomValidity('');
            }
        }

        return {
            restrict : 'A',
            link     : function(scope, element, attrs) {

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
]);