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