mySetlist.factory('album', ['$resource', 'baseUrl',

    function ($resource, baseUrl) {

        return {

            service: function (urlMod) {
                return $resource(baseUrl + 'album/' + urlMod,
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
            get : function (albumId) {
                var urlMod = albumId;
                return this.service(urlMod).get({},
                    function (response) {
                        return response;
                    },
                    function (failed) {
                        return failed;
                    }
                );
            },
            getAll : function () {
                var urlMod = '';
                return this.service(urlMod).getAll({},
                    function (response) {
                        return response;
                    },
                    function (failed) {
                        return failed;
                    }
                );
            },
            post : function (postData) {
                console.log("json", postData);
                return this.service('').post(postData,
                    function (response) {
                        console.log("what the response?", response);
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