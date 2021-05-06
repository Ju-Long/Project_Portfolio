$(document).ready(function () {

    let display = "";
    movie.forEach(i => {
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
    $(".movie .txt-section").html(display);

    var width = "75vw";
    $(".movie").scroll(function () { 
        if ($(this).scrollTop() > 1471) {
            $(".movie .img-section img:first-child").attr("src", "../img/movie/CoverPageV2.png");
            // $(".movie-bg").attr("src", "../img/transparent.png");
            $(".movie-bg").hide();
        }
        if ($(this).scrollTop() < 1471) {
            $(".movie .img-section img:first-child").attr("src", "../img/transparent.png");
            // $(".movie-bg").attr("src", "../img/movie/CoverPageV2.png");
            $(".movie-bg").show();
        }
        getPosition($(this).scrollTop());
    });
    getPosition = (position) => {
        // console.log(position);
        if (position < 860) {
            width = "75vw";
        } else if (position < 1001) {
            width = "74vw";
        } else if (position < 1143) {
            width = "73vw";
        } else if (position < 1284) {
            width = "72%";
        } else if (position < 1426) {
            width = "71vw";
        } else if (position < 1469) {
            width = "70vw";
        } else if (position > 2000) {
            $(".movie .XD-demo iframe").attr("src", "https://xd.adobe.com/embed/d6c12cac-7d27-4609-a4bb-fa18c71f1253-8392/");
        } else if (position < 1995) {
            $(".movie .XD-demo iframe").removeAttr("src");
        }
        $(".movie-bg").css("width", width);
    }
});