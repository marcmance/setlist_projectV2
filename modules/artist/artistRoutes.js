mySetlist.config(['$routeProvider', 
    function ($routeProvider) {
    	$routeProvider.when('/artist/new', 
            {
                templateUrl: '/modules/artist/views/newArtist.html',
                controller: 'NewArtistController'
            }
        ).when('/artist/:id', 
            {
                templateUrl: '/modules/artist/views/artist.html',
                controller: 'ArtistController'
            }
        )
    }
]);