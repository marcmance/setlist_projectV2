mySetlist.controller('ArtistController', ['$scope', '$route', 'artist',  function ($scope, $route, artist) {
    
    $scope.artist;
    $scope.allArtists;
    
    artist.get($route.current.params.id).$promise.then(function(result){
        console.log(result);
        $scope.artist = result;
    });

/*    artist.getAll().$promise.then(function(result){
        console.log(result);
        $scope.allArtists = result;
    });*/


}]);