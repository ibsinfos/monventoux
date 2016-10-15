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

