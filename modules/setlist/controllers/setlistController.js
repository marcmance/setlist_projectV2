mySetlist.controller('SetlistController', ['$scope', '$route', 'setlist',  
	function ($scope, $route, setlist) {
	    $scope.setlist;
	    setlist.get($route.current.params.id).$promise.then(function(result){
	        console.log(result);
	        $scope.setlist = result;
	        //$scope.setlist.date = new Date($scope.setlist.date + " 03:00:00");
	    }); 

	    $scope.filters = { };

	    $scope.albumFilter = function(name) {
	    	if(name === $scope.filters.album_name ) {
	    		$scope.clearFilter();
	    	}
	    	else {
	    		$scope.filters.album_name = name;
	    	}
	    	
	    };

	    $scope.clearFilter = function() {
	    	$scope.filters.album_name = '';
	    };
	}
]);