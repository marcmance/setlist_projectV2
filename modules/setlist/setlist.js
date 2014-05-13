mySetlist.factory('setlist', ['$resource', 'baseUrl',

    function ($resource, baseUrl) {
        return {
            service: function (urlMod) {
                return $resource(baseUrl + 'setlist/' + urlMod,
                    {},
                    {
                        'get': {
                            method: 'GET'
                            /*
                            headers: {
                                'X-CSRF-Token': sessionStorage.get('csrf')
                            }*/
                        },
                        'getAll': {
                            method: 'GET',
                            isArray: true
                            /*
                            headers: {
                                'X-CSRF-Token': sessionStorage.get('csrf')
                            }*/
                        },
                        'post': {
                            method: 'POST'
                        }
                    }
                );
            },
            get : function (setlistId) {
                var urlMod = setlistId;
                return this.service(urlMod).get({},
                    function (response) {
                        return response;
                    },
                    function (failed) {
                        return failed;
                    }
                );
            },
            getAll : function (userId) {
                return this.service('').getAll({},
                    function (response) {
                        return response;
                    },
                    function (failed) {
                        return failed;
                    }
                );
            },
            post : function () {
                return this.service().post({},
                    function (response) {
                        return response;
                    },
                    function (failed) {
                        return failed;
                    }
                );
            }
        };
    }
]);