mySetlist.controller('AllArtistsController', ['$scope', '$route', 'artist',  function ($scope, $route, artist) {
    
    $scope.allArtists;
    
	 artist.getAll().$promise.then(function(result){
        console.log(result);
        $scope.allArtists = result;
    });

}]);