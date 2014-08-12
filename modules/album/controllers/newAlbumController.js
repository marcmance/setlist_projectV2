mySetlist.controller('NewAlbumController', ['$scope', '$route', 'album', 'artist',  function ($scope, $route, album, artist) {
    
    $scope.album = {
        album_name: '',
        artist_id: '',
        songs: []
    };

    $scope.artists = {};
    $scope.songsSpliced = false;

    artist.getAll().$promise.then(function(result){
        console.log(result);
        $scope.artists = result;
    });


    $scope.onSelectChange = function() {
        console.log($scope.album.artist_id);
    }

    $scope.insertAlbum = function() {
        $scope.album.songs = [];
        var split = $scope.album.songs_temp.split("\n");
        for(var n in split) {
            $scope.album.songs.push({name: split[n]});
        }

        $scope.songsSpliced = true;

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