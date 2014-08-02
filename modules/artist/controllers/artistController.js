mySetlist.controller('ArtistController', ['$scope', '$route', 'artist',  function ($scope, $route, artist) {
    
    $scope.artist;
    
	artist.get($route.current.params.id).$promise.then(function(result){
        $scope.artist = result;
    });

}]);
