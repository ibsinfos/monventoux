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
