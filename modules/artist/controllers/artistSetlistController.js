
mySetlist.controller('ArtistSetlistController', ['$scope', '$route', '$location', 'artist',  function ($scope, $route, $location, artist) {
    
    $scope.artist;
    $scope.allArtists;
    
    artist.get($route.current.params.id).$promise.then(function(result){
        console.log(result);

        if(result.setlists <= 0) {
        	$location.path("/setlist/artists");
        }
        else {
        	$scope.artist = result;
        }
        

    });

}]);