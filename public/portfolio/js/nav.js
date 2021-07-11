$(document).ready(function () {
    $(".nav-item").click(function () { 
        $(".nav-item.active").removeClass("active");
        $(this).addClass("active");
    });

    $("#github").click(function () {
        window.location.href = "/#home"
    });

    $("#movie .app-title button").click(function() {
        window.location = "/apps/#movie"
    });

    $("#airport .app-title button").click(function () { 
        window.location = "/apps/#airport"
    });

    $("#gymlog .app-title button").click(function () { 
        window.location = "/apps/#gymlog"
    });

    if (getLocation() === "movie" || getLocation() === "airport" || getLocation() === "gymlog") {
        $(".navbar").addClass("active");
    }

    $(".navbrand").click(function () { 
        window.location = "/";
    });
});