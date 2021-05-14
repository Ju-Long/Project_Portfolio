$(document).ready(function () {
    $(".instagram").click(function () { 
        window.open("https://www.instagram.com/babasama._/");
    });

    $(".linkedin").click(function () { 
        window.open("www.linkedin.com/in/ju-long");
    });

    $("img").on('contextmenu', function() {
        return false;
    });

    $(".form-name, .form-subject, .form-message").keypress(function (e) { 
        if (e.keyCode > 0) {
            $(this).css("color", "black");
            $(this).css("border", "none");
        }
    });

    $(".progress-btn").on("click", function () {

        let name = $(".form-name").val();
        let email = $(".form-email").val();
        let subject = $(".form-subject").val();
        let message = $(".form-message").val();

        if (!name) {
            $(".form-name").attr("placeholder", "no value")
            $(".form-name").css("color", "red");
            $(".form-name").css("border", "2px solid red");
        } if (!email) {
            $(".form-email").attr("placeholder", "no value")
        } if (!subject) {
            $(".form-subject").attr("placeholder", "no value")
            $(".form-subject").css("color", "red");
            $(".form-subject").css("border", "2px solid red");
        } if (!message) {
            $(".form-message").attr("placeholder", "no value")
            $(".form-message").css("color", "red");
            $(".form-message").css("border", "2px solid red");
        } 
        if (name && email && subject && message){
            var progressBtn = $(".progress-btn");

            if (!progressBtn.hasClass("active")) {
                progressBtn.addClass("active");
            }
            
            sendEmail(name, email, subject, message);
        }
    });

    $("#home").click(function() {
        var curr = window.location.href;
        if (curr.split("/")[3] === "apps") {
            window.location = "/#home"
        }
    });
    $("#apps").click(function() {
        var curr = window.location.href;
        if (curr.split("/")[3] === "apps") {
            window.location = "/#apps"
        }
    });
    $("#contact").click(function() {
        var curr = window.location.href;
        if (curr.split("/")[3] === "apps") {
            window.location = "/#contact"
        }
    });

    sendEmail = (name, email, subject, content) => {
        $.post("/email", 
            {
                name: name,
                email: email,
                subject: subject,
                content: content
            },
            function (data, status, xhr) {
                if (data === "email sent") {
                    $(".submit").html("Sent")
                    $(".submit").attr("disabled", true)
                    $(".form-name, .form-email, .form-subject, .form-message").attr("disabled", true)
                }
            });
    }

    if ($(window).width() < 500) {
        confirm("This website is currently build for desktop view. Mobile view is to be upcoming.")
    }
});