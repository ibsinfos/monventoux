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
