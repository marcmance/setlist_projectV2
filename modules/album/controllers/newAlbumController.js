mySetlist.controller('NewAlbumController', ['$scope', '$route', 'album', 'artist',  function ($scope, $route, album, artist) {
    
    $scope.album = {
        album_name: '',
        artists: {},
        songs: []
    };

    artist.getAll().$promise.then(function(result){
        console.log(result);
        $scope.album.artists = result;
    });

    $scope.testArray = [{test: "hello"}, {test:'hello'}];

    $scope.insertAlbum = function() {

        var split = $scope.album.songs_temp.split("\n");
        for(var n in split) {
            $scope.album.songs.push({name: split[n]});
        }

/*        artist.post($scope.artist).$promise.then(function(result){
        	$scope.artist.artist_name = '';
        	$scope.showMsg = true;
        	$scope.message = 'Artist successfully posted!';
    	},
    	function(error) {
    		$scope.showMsg = true;
        	$scope.message = error.data.error_message;
        	$scope.artist.artist_name = '';
    	});*/
    }

}]);