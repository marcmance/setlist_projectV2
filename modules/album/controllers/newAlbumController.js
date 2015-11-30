mySetlist.controller('NewAlbumController', ['$scope', '$route', 'album', 'artist',  function ($scope, $route, album, artist) {
    
    $scope.album = {
        album_name: '',
        artist_id: '',
        year: '',
        cover_art_url: '',
        songs: []
    };

    $scope.artists = {};
    $scope.songsSpliced = false;
    $scope.songs_temp;
    $scope.showMsg = false;

    artist.getAll().$promise.then(function(result){
        console.log(result);
        $scope.artists = result;
    });


    $scope.onSelectChange = function() {
        console.log($scope.album.artist_id);
    }

    $scope.insertAlbum = function() {
        $scope.album.songs = [];
        var split = $scope.songs_temp.split("\n");
        var i = 1;
        for(var n in split) {
            $scope.album.songs.push({song_name: split[n], tracking: i, artist_id: $scope.album.artist_id});
            i++;
        }

        $scope.songsSpliced = true;

        album.post($scope.album).$promise.then(function(result){
        	//$scope.artist.artist_name = '';
        	$scope.showMsg = true;
        	$scope.message = 'Album successfully posted!';
    	},
    	function(error) {
    		$scope.showMsg = true;
        	$scope.message = error.data.error_message;
            console.log(error);
        	//$scope.artist.artist_name = '';
    	});
    }

}]);