$(document).ready(function () {
    $("main").addClass("homepage");

    $("#home").click(function () { 
        if(!$("#home").hasClass("active")) {
            window.location = "/#home";
            setView(getLocation());
        }
    });

    $("#apps").click(function () { 
        if(!$("#apps").hasClass("active")) {
            window.location = "/#apps";
            setView(getLocation());
        }
    });

    $("#contact").click(function () {
        if(!$("#contact").hasClass("active")) {
            window.location = "/#contact";
            setView(getLocation());
        }
    });

    $(".apps").hide();
    $(".contact").hide();

    removeMainClass = () => {
        $(".nav-item.active").removeClass("active");
        $("main").removeClass("homepage");
        $("main").removeClass("appspage");
        $("main").removeClass("contactpage");
        $("main").removeClass("appscontentpage");
        $(".home").hide();
        $(".apps").hide();
        $(".contact").hide();
        $(".movie").hide();
        $(".airport").hide();
        $(".gymlog").hide();
    }

    getLocation = () => {
        var curr = window.location.href;
        return curr.split("#")[1];
    }

    setView = (location) => {
        if (location === "home") {
            removeMainClass();
            $("title").html("Home");
            $("#home").addClass("active");
            $("main").addClass("homepage");
            $(".home").show();
        } else if (location === "apps") {
            removeMainClass();
            $("title").html("Apps");
            $("#apps").addClass("active");
            $("main").addClass("appspage");
            $(".apps").show();
        } else if (location === "contact") {
            removeMainClass();
            $("title").html("Contact");
            $("#contact").addClass("active");
            $("main").addClass("contactpage");
            $(".contact").show();
        } else if (location === "movie") {
            removeMainClass();
            $("title").html("Movie");
            $("#apps").addClass("active");
            $("main").addClass("appscontentpage");
            $(".movie").show();
        } else if (location === "airport") {
            removeMainClass();
            $("title").html("Airport");
            $("#apps").addClass("active");
            $("main").addClass("appscontentpage");
            $(".airport").show();
        } else if (location === "gymlog") {
            removeMainClass();
            $("title").html("Gym Log");
            $("#apps").addClass("active");
            $("main").addClass("appscontentpage");
            $(".gymlog").show();
        }
    }

    setView(getLocation());

    window.addEventListener('hashchange', function() {
        setView(getLocation());
      }, false);
});