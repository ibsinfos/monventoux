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
