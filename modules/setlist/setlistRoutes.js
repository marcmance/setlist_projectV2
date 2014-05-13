mySetlist.config(['$routeProvider', 
    function ($routeProvider) {
    	$routeProvider.when('/setlist/:id', 
            {
                templateUrl: '/modules/setlist/views/setlist.html',
                controller: 'SetlistController'
            }
        )
        .when('/setlists/', 
            {
                templateUrl: '/modules/setlist/views/allSetlists.html',
                controller: 'AllSetlistsController'
            }
        )
    }
]);