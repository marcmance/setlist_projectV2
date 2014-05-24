mySetlist.filter('toFileName', function () {

    //usage
    //{{word | ext:'_'}}

    return function (input, ext) {
        if (!input) { return false; }

        return (input.split(' ').join('') + "." + ext).toLowerCase();
    };

});