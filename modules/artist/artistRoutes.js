mySetlist.config(['$routeProvider', 
    function ($routeProvider) {
    	$routeProvider.when('/artist/new', 
            {
                templateUrl: '/modules/artist/views/newArtist.html',
                controller: 'NewArtistController'
            }
        ).when('/setlist/artist/:id', 
            {
                templateUrl: '/modules/artist/views/artistSetlist.html',
                controller: 'ArtistSetlistController'
            }
        ).when('/artists', 
            {
                templateUrl: '/modules/artist/views/allArtists.html',
                controller: 'AllArtistsController'
            }
        )
    }
]);