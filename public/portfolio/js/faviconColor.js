$(document).ready(function () {

    if(window.matchMedia('(prefers-color-scheme:dark)').matches) {
        //dark
        let location = getLocation();
            switch (location) {
                case "movie":
                    $('#icon').attr('href', '../img/favicon/movie/light/favicon.png');
                    break;
                case "airport":
                    $('#icon').attr('href', '../img/favicon/airport/favicon.png');
                    break;
                default:
                    $('#icon').attr('href', '../img/favicon/light/favicon.png');
            }
    } else {
        //light
        switch (location) {
            case "movie":
                $('#icon').attr('href', '../img/favicon/movie/favicon.png');
                break;
            case "airport":
                $('#icon').attr('href', '../img/favicon/airport/favicon.png');
                break;
            default:
                $('#icon').attr('href', '../img/favicon/favicon.png');
        }
    }

    //check if system color scheme changes
    window.matchMedia('(prefers-color-scheme:dark)').addEventListener('change', event => {
        if (event.matches) {
            //dark
            let location = getLocation();
            switch (location) {
                case "movie":
                    $('#icon').attr('href', '../img/favicon/movie/light/favicon.png');
                    break;
                case "airport":
                    $('#icon').attr('href', '../img/favicon/airport/favicon.png');
                    break;
                default:
                    $('#icon').attr('href', '../img/favicon/light/favicon.png');
            }
        } else {
            //light
            switch (location) {
                case "movie":
                    $('#icon').attr('href', '../img/favicon/movie/favicon.png');
                    break;
                case "airport":
                    $('#icon').attr('href', '../img/favicon/airport/favicon.png');
                    break;
                default:
                    $('#icon').attr('href', '../img/favicon/favicon.png');
            }
        }
    });
});