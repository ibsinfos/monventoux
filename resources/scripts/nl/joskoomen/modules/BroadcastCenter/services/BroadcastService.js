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
