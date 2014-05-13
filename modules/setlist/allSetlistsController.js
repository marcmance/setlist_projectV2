mySetlist.controller('AllSetlistsController', ['$scope', '$route', 'setlist',  
	function ($scope, $route, setlist) {
		$scope.setlists = null;
	    setlist.getAll().$promise.then(function(result){
	        console.log(result);
	       $scope.setlists = result;

	    }); 

	}
]);