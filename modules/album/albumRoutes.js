mySetlist.config(['$routeProvider', 
    function ($routeProvider) {
    	$routeProvider.when('/album/new', 
            {
                templateUrl: '/modules/album/views/newAlbum.html',
                controller: 'NewAlbumController'
            }
        )/*.when('/album/:id', 
            {
                templateUrl: '/modules/artist/views/artist.html',
                controller: 'ArtistController'
            }
        )*/
    }
]);