mySetlist.controller('NewArtistController', ['$scope', '$route', 'artist',  function ($scope, $route, artist) {
    
    $scope.artist = {
        artist_name: ''
    };

    $scope.showMsg = false;
    $scope.message = '';

    $scope.insertArtist = function() {
        artist.post($scope.artist).$promise.then(function(result){
        	$scope.artist.artist_name = '';
        	$scope.showMsg = true;
        	$scope.message = 'Artist successfully posted!';
    	},
    	function(error) {
    		$scope.showMsg = true;
        	$scope.message = error.data.error_message;
        	$scope.artist.artist_name = '';
    	});
    }

}]);