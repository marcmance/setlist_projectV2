mySetlist.controller('UserController', ['$scope', '$route', 'user',  function ($scope, $route, user) {
    $scope.user;
    user.get($route.current.params.id).$promise.then(function(result){
        console.log(result);
        $scope.user = result;
    }); 
}]);