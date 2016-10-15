$(document).ready(function(){

	updateNationality();
	toggleCMLidnummer();

	$('#nationaliteit').change(function(){
		updateNationality();
	});

	$('#cmlid').change(function(){
		toggleCMLidnummer();
	});

	// index
	$( ".datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "-100:+0"
	});
});

function toggleCMLidnummer(){
	if ( $('#cmlid').is(':checked') ){
		$('#cmlidnummer').slideDown();
		$('label[for="'+$('#cmlidnummer').attr('id')+'"]').slideDown();
	}else{
		$('#cmlidnummer').hide().val(''); 
		$('label[for="'+$('#cmlidnummer').attr('id')+'"]').slideUp();
	}
}


function updateNationality(){
	var value = $('#nationaliteit').val();
	$('#sofinummer').hide();
	$('label[for="'+$('#sofinummer').attr('id')+'"]').hide();
	$('#rijksregisternummer').hide();
	$('label[for="'+$('#rijksregisternummer').attr('id')+'"]').hide();
	if (value == 'BE'){
		$('#rijksregisternummer').slideDown();
		$('label[for="'+$('#rijksregisternummer').attr('id')+'"]').slideDown();
		$('#sofinummer').val('');
	}else if(value == 'NL'){
		$('#sofinummer').slideDown();
		$('label[for="'+$('#sofinummer').attr('id')+'"]').slideDown();
		$('#rijksregisternummer').val('');
	}else{
		$('#rijksregisternummer').val('');
		$('#sofinummer').val('');
	}
}




angular.module('fastclick', []).factory('FastClick', function() {
    return window.FastClick;
});
// http://stackoverflow.com/a/14968873
angular.module('underscore', []).factory('_', function() {
    return window._; // assumes underscore has already been loaded on the page
});
/* global ga */
var app = angular.module('monventoux', ['jkDeviceDetector', 'jkBroadcastCenter', 'fastclick']);

app.config(['$interpolateProvider', function(provider) {
    provider.startSymbol('{[{');
    provider.endSymbol('}]}');
}]);

// Function to track a virtual page view
function gaTrack(path, title) {
    ga('set', { page: path, title: title });
    ga('send', 'pageview');
}

function gaTracker(id){
    $.getScript('//www.google-analytics.com/analytics.js'); // jQuery shortcut
    window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
    ga('create', id, 'auto');

    // first page track
    ga('send', 'pageview');
}

app.run(['FastClick', function(FastClick) {

    $(document).ready(function() {
        FastClick.attach(document.body);
        $('input, textarea').placeholder();

        var script = document.createElement('script');
        script.src = '//www.google-analytics.com/ga.js';
        document.getElementsByTagName('head')[0].appendChild(script);

        gaTracker('UA-26506605-2');

    });
}]);
app.constant('Broadcasts', {
    'WINDOW_SCROLL_EVENT' : 'event.window.scroll',
    'WINDOW_RESIZE_EVENT' : 'event.window.resize',
    'VIEW_CONTENT_LOADED' : 'router.state.loaded',
    'SCROLL_TO_SECTION'   : 'home.scroll.section',
    'START_VIDEO'         : 'event.video.start',
    'STOP_VIDEO'          : 'event.video.stop'
});
app.constant('Genders', {
    'UNISEX' : 'Unisex',
    'MALE'   : 'Heren',
    'FEMALE' : 'Dames',
});
app.constant('LocalStorageKeys', {

});
/*
 global baseurl
 */
app.controller('ImagesController', [

    '$scope',

    function($scope) {

        $scope.showOverlay = function(type, src) {
            $scope.$broadcast('showOverlay', [type, src]);
        };

        $scope.closeOverlay = function() {
            $scope.$broadcast('hideOverlay');
        }
    }]);


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


/*
 global baseurl
 */
app.controller('WebshopController', [

    '$scope',
    'Genders',
    '_',

    function($scope, Genders, _) {

        $scope.items = {};
        $scope.products = [];
        $scope.totalprice = 0;
        $scope.collectlocation = 'tongerlo';
        $scope.sendcost = 0;
        $scope.discount = 0;
        $scope.subtotalprice = 0;
        $scope.memberdata = false;
        $scope.membercode = '';

        $scope.initBasket = function() {

            var items = $scope.items;
            items.count = [];
            items.size = [];
            items.name = [];
            items.gender = [];
            items.price = [];
            items.discount = [];

            for(var i = 1; i <= 4; i++) {

                items.count[i] = 0;
                items.size[i] = 'S';
                items.name[i] = $('#product-name' + i).val();
                items.price[i] = $('#product-price' + i).val();
                items.discount[i] = $('#product-discount' + i).val();
            }
            items.gender[1] = items.gender[3] = Genders.MALE;
            items.gender[2] = items.gender[4] = Genders.UNISEX;

            $('.basket-list').removeClass('hide');

        }
        $scope.changelocation = function() {
            if($scope.collectlocation == 'send') {
                $scope.sendcost = 8;
            }
            else {
                $scope.sendcost = 0;
            }
            var price = 0;

            _.each($scope.products, function(prod) {
                price += parseInt(prod.price);
            })

            $scope.subtotalprice = $scope.sendcost + price;
            $scope.totalprice = $scope.subtotalprice - $scope.discount;

            if(!$scope.$$phase) {
                $scope.$digest();
            }

        }
        $scope.changeMemberState = function() {
        }
        $scope.add = function(i) {

            var items = $scope.items;

            var product;
            var add = true;
            if(parseInt(items.count[i]) == 0) add = false;

            _.each($scope.products, function(prod) {
                if((prod.name == items.name[i]) &&
                    (prod.size == items.size[i]) &&
                    (prod.gender == items.gender[i])) {

                    product = prod;
                    product.count = parseInt(product.count) + parseInt(items.count[i]);
                    product.price = parseInt(product.price) + parseInt(items.count[i] * items.price[i]);
                    product.discount = parseInt(product.discount) + parseInt(items.count[i] * items.discount[i]);
                    add = false;
                }

            })

            if(add) {
                product = {
                    'id'       : makeid(),
                    'index'    : i,
                    'name'     : items.name[i],
                    'count'    : items.count[i],
                    'size'     : items.size[i],
                    'gender'   : items.gender[i],
                    'price'    : parseInt(items.count[i] * items.price[i]),
                    'discount' : parseInt(items.count[i] * items.discount[i])

                };

                $scope.products.push(product);
            }

            var subtotal = $scope.sendcost;
            var discount = 0;
            _.each($scope.products, function(prod) {
                subtotal += prod.price;
                /*
                if($scope.memberdata && ($scope.membercode.length > 2)) {
                    discount += prod.discount;
                }
                */
                discount += prod.discount;
            });

            $scope.subtotalprice = subtotal;
            $scope.discount = discount;
            $scope.totalprice = $scope.subtotalprice - $scope.discount;

            if(!$scope.$$phase) {
                $scope.$digest();
            }
        }

        $scope.remove = function(i) {
            var items = $scope.items;
            var hasremovable = false;
            var removable = undefined;
            _.each($scope.products, function(prod, index) {

                if((prod.name == items.name[i]) &&
                    (prod.size == items.size[i]) &&
                    (prod.gender == items.gender[i])) {
                    prod.i = index;
                    removable = prod;
                    hasremovable = true;
                }
            });
            if(hasremovable) {
                $scope.products.splice(removable.i, 1);

                var subtotal = 0;
                var discount = 0;
                _.each($scope.products, function(prod, index) {
                    subtotal += prod.price;
                    /*
                    if($scope.memberdata && ($scope.membercode.length > 2)) {
                        discount += prod.discount;
                    }
                    */
                    discount += prod.discount;
                });

                $scope.subtotalprice = subtotal;
                $scope.discount = discount;

                $scope.totalprice = $scope.subtotalprice - $scope.discount;

                if(!$scope.$$phase) {
                    $scope.$digest();
                }

            }

        };

        $scope.$watchGroup(['memberdata', 'membercode'], function() {
            /*
            var len = $scope.membercode.length > 2;
            var checked = $scope.memberdata;
            if(len && checked) {
                var discount = 0;
                _.each($scope.products, function(prod) {
                    discount += prod.discount;
                });
                $scope.discount = discount;
            }
            else {
                $scope.discount = 0;
            }
            */
            var discount = 0;
            _.each($scope.products, function(prod) {
                discount += prod.discount;
            });
            $scope.discount = discount;


            $scope.totalprice = $scope.subtotalprice - $scope.discount;
        });

        var makeid = function() {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for(var i = 0; i < 5; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }

        $scope.$on("$destroy", function() {
            alert('destroy');
            $scope.items = {};
            $scope.products = [];
            $scope.totalprice = 0;
            $scope.collectlocation = 'tongerlo';
            $scope.sendcost = 0;
            $scope.discount = 0;
            $scope.subtotalprice = 0;
            $scope.memberdata = false;
            $scope.membercode = '';
        });

    }])
;


app.directive('mediaItem', [
    function() {
        return {
            restrict : 'A',
            link     : function(scope, element, attrs) {
                element.on('click', function(e) {
                    e.preventDefault();

                    scope.showOverlay(attrs.type, attrs.href);
                    //                    var overlay = $('.media-overlay');
                    //                    overlay.addClass(attrs.type);
                })
            }
        };
    }]);
app.directive('mediaOverlay', [
    function() {
        return {
            restrict : 'A',
            link     : function(scope, element, attrs) {

                scope.$on('showOverlay', function(event, params) {

                    if(params[0] == 'video') {
                        element.find('iframe').attr('src', params[1]);
                    }
                    else {
                        //image
                        element.find('img').attr('src', params[1]);
                    }
                    element.removeClass('image video hide').addClass(params[0]);
                });

                scope.$on('hideOverlay', function() {
                    element.removeClass('image video').addClass('hide');
                    element.find('iframe').attr('src', '');
                    element.find('img').attr('src', '');
                });
            }
        };
    }]);
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
app.directive('removeItemButton', [

    '_',

    function(_) {

        return {
            restrict : 'A',
            link     : function(scope, element, attr) {
                element.on('click', function(e) {
                    e.preventDefault();

                    var index = attr.index;
                    scope.remove(index);

                });

                scope.$on('$destroy', function() {
                    element.off('click');
                });

            }
        };
    }]);
app.directive('resize', [

    '_',
    'jkBroadcastService',
    'Broadcasts',

    function(_, broadcastCenter, Broadcasts) {

        var resizeHandler = function() {
            broadcastCenter.$broadcast(Broadcasts.WINDOW_RESIZE_EVENT);
            broadcastCenter.$broadcast(Broadcasts.WINDOW_SCROLL_EVENT);
        };

        var throttledHandler = _.throttle(resizeHandler, 50);

        return {
            restrict : 'A',
            link     : function(scope) {
                $(window).on('resize', throttledHandler);
                scope.$on('$destroy', function() {
                    $(window).off('resize', throttledHandler);
                });

            }
        };
    }]);
app.directive('scroll', ['_', 'jkBroadcastService', 'Broadcasts',
    function(_, broadcastCenter, Broadcasts) {

        var scrollHandler = function(e) {
            broadcastCenter.$broadcast(Broadcasts.WINDOW_SCROLL_EVENT, [e]);
        };

        var throttledHandler = _.throttle(scrollHandler, 50);

        return {
            restrict : 'A',
            link     : function(scope) {
                $(window).on('scroll', throttledHandler);
                scope.$on('$destroy', function() {
                    $(window).off('scroll', throttledHandler);
                });

            }
        };
    }]);
app.directive('scrollfade', [

    '_',
    'jkBroadcastService',
    'Broadcasts',

    function(_, broadcastCenter, Broadcasts) {

        return {
            restrict : 'A',
            link     : function(scope, element) {

                broadcastCenter.$on(Broadcasts.WINDOW_SCROLL_EVENT, scope, function() {
                    var value = $(window).scrollTop();
                    if(value < 100) {
                        value = (100 - value) / 100;
                        element.css({'opacity' : value});
                        if(value <= 0) {
                            element.css({'opacity' : 1});
                        }
                    }
                    else {
                        element.css({'opacity' : 0});
                    }
                });
            }
        };
    }]);
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
app.factory('ApiService', ['$q', '$http', function($q, $http) {

    function _token() {
        var _defer = $q.defer();
        var _tried;
        var _feed;

        $http.get('/token.php').then(
            //success
            function(res) {
                _feed = res.data;
                _defer.resolve(_feed);
            },
            //fail
            function() {
                if(_tried < 5) {
                    _tried++;
                    return _token();
                }
                else {
                    _defer.reject();
                }
            }
        );

        return _defer.promise;
    }


    function _post(file) {
        var _defer = $q.defer();
        var _tried;
        var _feed;

        $http.post('/' + file + '.php').then(
            //success
            function(res) {
                _feed = res.data;
                _defer.resolve(_feed);
            },
            //fail
            function() {
                if(_tried < 5) {
                    _tried++;
                    return _post(file);
                }
                else {
                    _defer.reject();
                }
            }
        );

        return _defer.promise;
    }

    return {

        getToken    : function() {
            return _token();
        },
        postRequest : function(file) {
            return _post(file);
        },
    };
}
]);
app.factory('DataService', ['$q', '$http', function($q, $http) {

    function _loadJSON(file) {
        var _defer = $q.defer();
        var _tried;
        var _feed;

        $http.get('assets/json/' + file).then(
            //success
            function(res) {
                _feed = res.data;
                _defer.resolve(_feed);
            },
            //fail
            function() {
                if(_tried < 5) {
                    _tried++;
                    return _loadJSON(file);
                }
                else {
                    _defer.reject();
                }
            }
        );

        return _defer.promise;
    }

    return {

        loadHomeData : function() {
            return _loadJSON('home.json');
        },
        loadMainData : function() {
            return _loadJSON('main.json');
        },
        loadEventData : function() {
            return _loadJSON('event.json');
        },
        loadMatchData : function() {
            return _loadJSON('match.json');
        }


    };
}
]);
app.factory('LocalStorageService', function() {
    var _baseKey = 'be.monventoux';
    return {
        getItem    : function(itemName) {
            return localStorage.getItem(_baseKey + '.' + itemName);
        },
        hasItem    : function(itemName) {
            var item = localStorage.getItem(_baseKey + '.' + itemName);
            return item === null ? false : true;
        },
        setItem    : function(itemName, value) {
            localStorage.setItem(_baseKey + '.' + itemName, value);
        },
        removeItem : function(itemName) {
            localStorage.removeItem(_baseKey + '.' + itemName);
        },
        clear      : function() {
            localStorage.clear();
        }
    };

})
;


 /*
 The MIT License (MIT)

 Copyright (c) 2015 Jos Koomen

 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:

 The above copyright notice and this permission notice shall be included in all
 copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 SOFTWARE.
 */
var detector = angular.module('jkDeviceDetector', ['underscore']);
/*
 The MIT License (MIT)

 Copyright (c) 2015 Jos Koomen

 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:

 The above copyright notice and this permission notice shall be included in all
 copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 SOFTWARE.
 */
var broadcastCenter = angular.module('jkBroadcastCenter', ['underscore']);
app.directive('changeradio', [
    function() {
        return {
            restrict : 'A',
            link     : function(scope, element, attrs) {

                element.on('click', function() {
                    $('.' + attrs.show).removeClass('hide');
                    $('.' + attrs.hide).addClass('hide');
                });
            }
        }
    }
]);
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
detector.constant('jkIPhoneDiagonals', {
    'IPHONE_4'      : 576,
    'IPHONE_5'      : 651,
    'IPHONE_6'      : 765,
    'IPHONE_6_PLUS' : 844
});

detector.factory('jkDetectionClassesService', ['jkDetectionService', '_',
    function(detectionService, _) {

        var _devices = [
            {classes : 'iphone,iphone3g', check : detectionService.iphone3g},
            {classes : 'iphone,iphone4', check : detectionService.iphone4},
            {classes : 'iphone,iphone5', check : detectionService.iphone5},
            {classes : 'iphone,iphone6', check : detectionService.iphone6},
            {classes : 'iphone,iphone6plus', check : detectionService.iphone6plus},
            {classes : 'iphone', check : detectionService.iphone},
            {classes : 'ipod', check : detectionService.ipod},
            {classes : 'ipad', check : detectionService.ipad},
            {classes : 'nexus', check : detectionService.nexus},
            {classes : 'htc', check : detectionService.htc},
            {classes : 'sony', check : detectionService.sony},
            {classes : 'acer', check : detectionService.acer},
            {classes : 'lg', check : detectionService.lg},
            {classes : 'samsung', check : detectionService.samsung},
            {classes : 'nokia', check : detectionService.nokia},
            {classes : 'lenovo', check : detectionService.lenovo},
            {classes : 'huawei', check : detectionService.huawei}
        ];

        var _browsers = [
            {classes : 'msedge', check : detectionService.edge},
            {classes : 'webkit,chrome', check : detectionService.chrome},
            {classes : 'webkit,safari', check : detectionService.safari},
            {classes : 'mozilla,ff', check : detectionService.firefox},
            {classes : 'iemobile,iemobile9', check : detectionService.iemobile9},
            {classes : 'iemobile,iemobile10', check : detectionService.iemobile10},
            {classes : 'iemobile,iemobile11', check : detectionService.iemobile11},
            {classes : 'ie,ie8', check : detectionService.ie8},
            {classes : 'ie,ie9', check : detectionService.ie9},
            {classes : 'ie,ie10', check : detectionService.ie10},
            {classes : 'ie,ie11', check : detectionService.ie11},
            {classes : 'operamini', check : detectionService.operamini},
            {classes : 'opera', check : detectionService.opera}
        ];

        var _operatingSystems = [
            {classes : 'windows', check : detectionService.windows},
            {classes : 'windows,wp,wp7', check : detectionService.windowsphone7},
            {classes : 'windows,wp,wp8', check : detectionService.windowsphone8},
            {classes : 'windows,wp,wp10', check : detectionService.windowsphone10},
            {classes : 'ios,ios5', check : detectionService.ios5},
            {classes : 'ios,ios6', check : detectionService.ios6},
            {classes : 'ios,ios7', check : detectionService.ios7},
            {classes : 'ios,ios8', check : detectionService.ios8},
            {classes : 'ios,ios9', check : detectionService.ios9},
            {classes : 'ios', check : detectionService.ios},
            {classes : 'android,android2', check : detectionService.android2},
            {classes : 'android,android3', check : detectionService.android3},
            {classes : 'android,android4', check : detectionService.android4},
            {classes : 'android,android5', check : detectionService.android5},
            {classes : 'blackberry,playbook', check : detectionService.playbook},
            {classes : 'blackberry', check : detectionService.blackberry},
            {classes : 'macosx', check : detectionService.macosx}

        ];

        var _screenDensities = [
            {classes : 'low-density', check : detectionService.lowdensity},
            {classes : 'medium-density,half-retina', check : detectionService.halfretina},
            {classes : 'large-density,retina', check : detectionService.retina},
            {classes : 'xlarge-density,retina-hd', check : detectionService.retinahd},
            {classes : 'xxlarge-density,super-hd', check : detectionService.superhd}
        ];

        var _deviceFunctionals = [
            {classes : 'standalone', check : detectionService.standalone},
            {classes : 'touch', check : detectionService.touch},
            {classes : 'mobile', check : detectionService.mobile},
            {classes : 'desktop', check : detectionService.desktop}
        ];

        var _getClasses = function(array) {
            var find = _.find(array, function(record) {
                return record.check === true;
            });
            return find === undefined ? "" : find.classes;
        };

        return {

            getDeviceClass : function() {
                return _getClasses(_devices);
            },

            getBrowserClass : function() {
                return _getClasses(_browsers);
            },

            getOSClass : function() {
                return _getClasses(_operatingSystems);
            },

            getDensityClass : function() {
                return _getClasses(_screenDensities);
            },

            getFunctionalClasses : function() {
                var classes = [];
                _.each(_deviceFunctionals, function(functional) {
                    if(functional.check === true) {
                        classes.push(functional.classes);
                    }
                });
                return classes;
            },

            toString : function() {
                return 'jkDetectionClassesService';
            }

        };

    }]);

detector.factory('jkDetectionService', ['jkIPhoneDiagonals',
    function(iPhoneDiagonals) {

        var ua = navigator.userAgent.toLowerCase();

        var isiPhone = ua.indexOf('iphone') !== -1;
        var isiPad = ua.indexOf('ipad') !== -1;
        var isiPod = ua.indexOf('ipod') !== -1;
        var isiOS = isiPhone || isiPad || isiPod;

        var size = Math.floor(Math.sqrt(screen.width * screen.width + screen.height * screen.height));

        return {
            iphone         : isiPhone,
            iphone3g       : isiPhone && (window.devicePixelRatio === 1) && (size === iPhoneDiagonals.IPHONE_4 ),
            iphone4        : isiPhone && (window.devicePixelRatio === 2) && (size === iPhoneDiagonals.IPHONE_4 ),
            iphone5        : isiPhone && (size === iPhoneDiagonals.IPHONE_5 ),
            iphone6        : isiPhone && (size === iPhoneDiagonals.IPHONE_6 ),
            iphone6plus    : isiPhone && (size === iPhoneDiagonals.IPHONE_6_PLUS),
            ipod           : isiPod,
            ipad           : isiPad,

            nexus          : ua.indexOf('nexus') !== -1,
            htc            : ua.indexOf('htc') !== -1,
            sony           : ua.indexOf('sony') !== -1,
            acer           : ua.indexOf('acer') !== -1,
            lg             : ua.indexOf('lg') !== -1,
            nokia          : ua.indexOf('nokia') !== -1,
            lenovo         : ua.indexOf('lenovo') !== -1,
            samsung        : (ua.indexOf('gt-') !== -1) || (ua.indexOf('galaxy') !== -1) || (ua.indexOf('samsung') !== -1) || (ua.indexOf('sm-') !== -1) || (ua.indexOf('sch-') !== -1),
            huawei         : (ua.indexOf('huawei') !== -1) || (ua.indexOf('ascend') !== -1),

            ie             : ua.indexOf('msie') !== -1,
            ie8            : ua.indexOf('msie 8') !== -1,
            ie9            : ua.indexOf('msie 9') !== -1,
            ie10           : ua.indexOf('msie 10') !== -1,
            ie11           : ua.indexOf('rv:11') !== -1,
            edge           : ua.indexOf('edge/12') !== -1,
            iemobile       : ua.indexOf('iemobile') !== -1,
            iemobile9      : ua.indexOf('iemobile/9') !== -1,
            iemobile10     : ua.indexOf('iemobile/10') !== -1,
            iemobile11     : ua.indexOf('iemobile/11') !== -1,

            chrome         : (ua.indexOf('chrome') !== -1) || (ua.indexOf('crios') !== -1),
            firefox        : ua.indexOf('firefox') !== -1,
            safari         : ua.indexOf('safari') !== -1,
            opera          : ua.indexOf('opera') !== -1,
            operamini      : ua.indexOf('opera mini') !== -1,
            webkit         : ua.indexOf('webkit') !== -1,

            ios            : isiOS,
            ios5           : isiOS && (ua.indexOf('os 5') !== -1),
            ios6           : isiOS && (ua.indexOf('os 6') !== -1),
            ios7           : isiOS && (ua.indexOf('os 7') !== -1),
            ios8           : isiOS && (ua.indexOf('os 8') !== -1),
            ios9           : isiOS && (ua.indexOf('os 9') !== -1),

            android        : ua.indexOf('android') !== -1,
            android2       : ua.indexOf('android 2') !== -1,
            android3       : ua.indexOf('android 3') !== -1,
            android4       : ua.indexOf('android 4') !== -1,
            android5       : ua.indexOf('android 5') !== -1,

            windowsphone   : ua.indexOf('windows phone') !== -1,
            windowsphone7  : ua.indexOf('windows phone os 7') !== -1,
            windowsphone8  : ua.indexOf('windows phone 8') !== -1,
            windowsphone10 : ua.indexOf('windows phone 10') !== -1,

            blackberry     : ua.indexOf('bb10') !== -1,
            playbook       : ua.indexOf('playbook') !== -1,

            macosx         : ua.indexOf('mac os x') !== -1,
            windows        : ua.indexOf('windows nt') !== -1,

            lowdensity     : window.devicePixelRatio < 1,
            halfretina     : (window.devicePixelRatio > 1) && (window.devicePixelRatio < 2),
            retina         : window.devicePixelRatio === 2,
            retinahd       : window.devicePixelRatio === 3,
            superhd        : window.devicePixelRatio > 3,

            standalone     : ("standalone" in window.navigator) && (window.navigator.standalone === true),
            touch          : !!('ontouchstart' in window),

            portrait       : (window.orientation === -90) || (window.orientation === 90),
            landscape      : (window.orientation === 0) || (window.orientation === 180),

            mobile         : (typeof window.orientation !== 'undefined'),
            desktop        : (typeof window.orientation === 'undefined'),

            toString       : function() {
                return 'jkDetectionService';
            }
        };

    }]);

detector.directive('detectionClasses', ['jkDetectionClassesService', '_',
    function(service, _) {
        return {
            restrict : 'AC',
            link     : function(scope, element) {
                var classes = service.getFunctionalClasses();
                classes.push(service.getDeviceClass());
                classes.push(service.getDensityClass());
                classes.push(service.getBrowserClass());
                classes.push(service.getOSClass());

                _.each(classes, function(arr) {
                    _.each(arr.split(','), function(c) {
                        element.addClass(c);

                    });
                });
            }
        };
    }]);
detector.directive('browserClass', ['jkDetectionClassesService', '_',
    function(service, _) {
        return {
            restrict : 'AC',
            link     : function(scope, element) {
                var browserClasses = service.getBrowserClass().split(',');
                _.each(browserClasses, function(c) {
                    element.addClass(c);
                });

            }
        };
    }]);
detector.directive('densityClass', ['jkDetectionClassesService', '_',
    function(service, _) {
        return {
            restrict : 'AC',
            link     : function(scope, element) {
                var densityClasses = service.getDensityClass().split(',');
                _.each(densityClasses, function(c) {
                    element.addClass(c);
                });

            }
        };
    }]);
detector.directive('deviceClass', ['jkDetectionClassesService', '_',
    function(service, _) {
        return {
            restrict : 'AC',
            link     : function(scope, element) {
                var deviceClasses = service.getDeviceClass().split(',');
                _.each(deviceClasses, function(c) {
                    element.addClass(c);
                });

            }
        };
    }]);
detector.directive('functionalClasses', ['jkDetectionClassesService', '_',
    function(service, _) {
        return {
            restrict : 'AC',
            link     : function(scope, element) {
                var fClasses = service.getFunctionalClasses();
                _.each(fClasses, function(f) {
                    _.each(f.split(','), function(c) {
                        element.addClass(c);
                    });
                });
            }
        };
    }]);
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
broadcastCenter.factory('jkBroadcastService', ['_',
    function(_) {

        var _listeners = [];

        return {

            /**
             * Add a broadcast listener to the center.
             * @param name - Name of your event/broadcast
             * @param scope - Scope to attach. This is used for cleanup and removal (i suggest to add just $scope var)
             * @param handler - broadcast handler. Add parameters for each added data value in the $broadcast method
             *
             * @example jkBroadcastService.$on('myBroadcastMessage', $scope, $scope.handleMyBroadcastMessage);
             */
            $on : function(name, scope, handler) {
                _listeners.push({name : name, scope : scope.$id, handler : handler});
            },

            /**
             * Remove a broadcast listener to the center. When including the optional handler it only removes the listener connected to that handler.
             * @param name - Name of your event/broadcast
             * @param scope - Scope it's attached to. This is used for cleanup and removal (i suggest to add just $scope var)
             * @param handler - broadcast handler. Add parameters for each added data value in the $broadcast method (optional)
             *
             * @example jkBroadcastService.$off('myBroadcastMessage', $scope);
             * @example jkBroadcastService.$off('myBroadcastMessage', $scope, $scope.handleMyBroadcastMessage);
             */
            $off : function(name, scope, handler) {

                var arr = _listeners;

                if(handler === undefined) {
                    arr = _.reject(_listeners, function(item) {
                        return (item.name === name) && (scope.$id === item.scope);
                    });
                }
                else {

                    arr = _.reject(_listeners, function(item) {
                        return (item.name === name) && (scope.$id === item.scope) && (item.handler === handler);
                    });
                }
                _listeners = arr;
            },

            /**
             * Broadcast your event to all listeners
             * @param name - Name of your event/broadcast
             * @param data - array with parameters
             *
             * @example jkBroadcastService.$broadcast('myBroadcastMessage', [param1, param2]);
             */
            $broadcast : function(name, data) {
                if(data === undefined) data = {};
                _.each(_listeners, function(listener) {
                    if(listener !== undefined) {
                        if(listener.name === name) {
                            listener.handler.apply(this, data);
                        }
                    }
                });

            },

            /**
             * Remove all listeners for the scope. Call this on $destroy
             * @param scope - your scope object to clean
             *
             * @example jkBroadcastService.cleanScope($scope);
             */
            cleanScope : function(scope) {
                var arr = _.reject(_listeners, function(item) {
                    return item.scope === scope.$id;
                });
                _listeners = arr;
            },

            toString : function() {
                return 'jkBroadcastService: ' + _listeners.length;
            }
        };

    }]);
