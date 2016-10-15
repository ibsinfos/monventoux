// http://stackoverflow.com/a/14968873
angular.module('underscore', []).factory('_', function() {
    return window._; // assumes underscore has already been loaded on the page
});