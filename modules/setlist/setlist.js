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
                        'post': {
                            method: 'POST'
                        }
                    }
                );
            },
            get : function (userId) {
                var urlMod = userId;
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
                var urlMod = userId;
                return this.service(urlMod).get({},
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