app.directive('requiredConfirmfield', [
    function() {

        function validate(element, confirm, errormsg) {
            if(element.value !== confirm.val()) {
                element.setCustomValidity(errormsg);
            }
            else {
                element.setCustomValidity('');
            }
        }

        return {
            restrict : 'A',
            link     : function(scope, element, attrs) {

                console.log(attrs.confirmfield);

                element.on('invalid', function() {
                    validate(element[0], $(attrs.confirmfield), attrs.errormsg);
                    return true;
                });

                element.on('blur', function() {
                    validate(element[0], $(attrs.confirmfield), attrs.errormsg);
                    return true;
                });
                element.on('input', function() {
                    validate(element[0], $(attrs.confirmfield), attrs.errormsg);
                    return true;
                });
            }
        }
    }
]);