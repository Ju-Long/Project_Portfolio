$(document).ready(function () {

    let display = "";
    airport.forEach(i => {
        display += "<section>";
        display += "<strong>" + i.header + "</strong>";
        if (i.header === "SWOT Analysis") {
            display += "<div class='row'>";
            (i.message).forEach(n => {
                display += "<div>";
                display += "<strong>" + n.subheader + "</strong>";
                display += "<p>" + n.content + "</p>";
                display += "</div>";
            });
            display += "</div>";
        } else {
            display += "<p>" + i.message + "</p>";
        }
        display += "</section>"
    });
    $(".airport .txt-section").html(display);

    var width = "80vw";
    $(".airport").scroll(function () { 
        if ($(this).scrollTop() > 1307) {
            $(".airport .img-section img:first-child").attr("src", "../img/airport/CoverPage.png");
            // $(".movie-bg").attr("src", "../img/transparent.png");
            $(".airport-bg").hide();
        }
        if ($(this).scrollTop() < 1307) {
            $(".airport .img-section img:first-child").attr("src", "../img/transparent.png");
            // $(".movie-bg").attr("src", "../img/movie/CoverPageV2.png");
            $(".airport-bg").show();
        }
        getPosition($(this).scrollTop());
    });
    getPosition = (position) => {
        // console.log(position);
        if (position < 814) {
            width = "80vw";
        } else if (position < 912) {
            width = "79vw";
        } else if (position < 1011.2) {
            width = "78vw";
        } else if (position < 1109) {
            width = "77vw";
        } else if (position < 1208) {
            width = "76vw";
        } else if (position < 1307) {
            width = "75vw";
        } else if (position > 2000) {
            $(".airport .XD-demo iframe").attr("src", "https://xd.adobe.com/view/7fb2bde4-dde0-494d-90a7-ffda63cf21e5-2ae1/");
        } else if (position < 1995 ) {
            $(".airport .XD-demo iframe").removeAttr("src");
        }
        $(".airport-bg").css("width", width);
    }
}); 