mySetlist.config(['$routeProvider', 
    function ($routeProvider) {
    	$routeProvider.when('/setlist/artists', 
            {
                templateUrl: '/modules/setlist/views/setlistArtists.html',
                controller: 'SetlistArtistsController'
            }
        )
        .when('/setlist/:id', 
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