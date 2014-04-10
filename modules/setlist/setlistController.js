mySetlist.controller('SetlistController', ['$scope', '$route', 'setlist',  
	function ($scope, $route, setlist) {
	    $scope.setlist;
	    setlist.get($route.current.params.id).$promise.then(function(result){
	        console.log(result);
	        $scope.setlist = result;
	    }); 
	}
]);