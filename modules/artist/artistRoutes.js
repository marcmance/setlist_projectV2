mySetlist.config(['$routeProvider', 
    function ($routeProvider) {
    	$routeProvider.when('/artist/:id', 
            {
                templateUrl: '/modules/artist/views/artist.html',
                controller: 'ArtistController'
            }
        )
    }
]);