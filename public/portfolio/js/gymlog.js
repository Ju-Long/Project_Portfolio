$(document).ready(function () {

    let display = "";
    gymlog.forEach(i => {
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
    $(".gymlog .txt-section").html(display);

    var width = "80vw";
    $(".gymlog").scroll(function () { 
        if ($(this).scrollTop() > 1307) {
            $(".gymlog .img-section img:first-child").attr("src", "../img/gymlog/CoverPage.png");
            // $(".movie-bg").attr("src", "../img/transparent.png");
            $(".gymlog-bg").hide();
        }
        if ($(this).scrollTop() < 1307) {
            $(".gymlog .img-section img:first-child").attr("src", "../img/transparent.png");
            // $(".movie-bg").attr("src", "../img/movie/CoverPageV2.png");
            $(".gymlog-bg").show();
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
            $(".gymlog .XD-demo iframe").attr("src", "https://xd.adobe.com/view/4e408f09-6ecc-4ba7-b4ba-1e143adbe06f-1b13/");
        } else if (position < 1995 ) {
            $(".gymlog .XD-demo iframe").removeAttr("src");
        }
        $(".gymlog-bg").css("width", width);
    }
}); 