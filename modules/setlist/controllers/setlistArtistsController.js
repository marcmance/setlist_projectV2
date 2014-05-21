mySetlist.controller('SetlistArtistsController', ['$scope', '$route', 'setlist',  
	function ($scope, $route, setlist) {
		$scope.artists = null;
		setlist.setlistArtists().$promise.then(function(result){
	        console.log(result);
	       	$scope.artists = result;
	    });  
	}
]);