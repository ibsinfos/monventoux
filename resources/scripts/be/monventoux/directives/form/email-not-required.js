app.directive('emailNotRequired', [
    function() {
        return {
            restrict : 'A',
            link     : function(scope, element) {

                element.on('invalid', function() {

                        var self = element[0];

                        if(self.value != '') {
                            if(self.validity.typeMismatch) {
                                self.setCustomValidity('Vul hier een geldig e-mailadres in.');
                            }
                            else {
                                self.setCustomValidity('');
                            }
                        }
                        else {
                            self.setCustomValidity('');
                        }
                        return true;
                    }
                );
            }
        }
    }
]);