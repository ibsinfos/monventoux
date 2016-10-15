app.directive('requiredEmail', [
    function() {

        function validate(element) {
            if(element.value == '') {
                element.setCustomValidity('Dit veld is verplicht');
            }
            else if(element.validity.typeMismatch) {
                element.setCustomValidity('Vul hier een geldig e-mailadres in.');
            }
            else {
                element.setCustomValidity('');
            }
        }

        return {
            restrict : 'A',
            link     : function(scope, element) {

                element.on('invalid', function() {
                    validate(element[0]);
                    return true;
                });

                element.on('blur', function() {
                    validate(element[0]);
                    return true;
                });
                element.on('input', function() {
                    validate(element[0]);
                    return true;
                });
            }
        }
    }
]);