mySetlist.config(['$routeProvider', 
    function ($routeProvider) {
    	$routeProvider.when('/user/:id', 
            {
                templateUrl: 'modules/user/views/user.html',
                controller: 'UserController'
            }
        )
    }
]);