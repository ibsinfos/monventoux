app.directive('togglemenu', [

    function() {

        return {
            restrict : 'A',
            link     : function(scope, element) {
                var button = element.find('.button');
                var i = button.find('i.fa');
                button.on('click', function() {
                    element.toggleClass('open');
                    var isopen = element.hasClass('open');

                    if(isopen) {
                        i.removeClass('fa-navicon').addClass('fa-close');
                    } else {
                        i.removeClass('fa-close').addClass('fa-navicon');
                    }
                });

            }
        };
    }]);