mySetlist.controller('NewArtistController', ['$scope', '$route', 'artist',  function ($scope, $route, artist) {
    
    $scope.artist = {
        artist_name: ''
    };

    $scope.insertArtist = function() {
        artist.post($scope.artist).$promise.then(function(result){;
        	console.log("what up doge? " + result);
    	});
    }

}]);