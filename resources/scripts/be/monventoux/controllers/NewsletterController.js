/*
 global baseurl
 */
app.controller('NewsletterController', [

    '$scope',
    '$http',

    function($scope, $http) {

        var fd = {};
        fd.email = '';
        $scope.formdata = fd;
        $scope.posturl = baseurl + '/mv16api/newsletter';

        $scope.postForm = function() {
            $('.submitbutton').addClass('loading disabled');

            $http({
                method : 'POST',
                url    : $scope.posturl,
                data   : {
                    'email'  : $scope.formdata.email,
                    '_token' : $scope.formdata.token

                }
            })
                .then(function(formdata) {
                    $('.submitbutton').removeClass('loading disabled');
                    $('#newslettermessage').html(formdata.data.message);

                    if(formdata.data.success) {
                        $('#form').slideUp('fast', function() {
                            $('#form').addClass('hide');
                        });
                        gaTrack('/nieuwsbrief-inschrijven', 'Nieuwsbrief formulier ingevuld');
                    }
                },
                function(errordata) {
                    $('.submitbutton').removeClass('loading disabled');
                    $('#newslettermessage').text(errordata.data.message);
                    gaTrack('/nieuwsbrief-inschrijven/fout', 'Nieuwsbrief formulier fout!');
                });
        };

    }]);

