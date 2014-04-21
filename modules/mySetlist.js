var mySetlist = angular.module('mySetlist', ['ngResource', 'ngRoute', 'ngSanitize'])
.run(['$rootScope',

    function ($rootScope) {
     	
	}
]);

mySetlist.value('baseUrl', "/api/v1/");

mySetlist.config(['$routeProvider', 

    function ($routeProvider) {
    
        $routeProvider.when('/', 
            {
                templateUrl: '/modules/home.html',
                controller: 'TestController'
            }
        )
        .when('/hello', 
            {
                templateUrl: '/modules/home.html',
                controller: 'TestController2'
            }
        )
        .otherwise({ redirectTo: '/' });
    }
]);

