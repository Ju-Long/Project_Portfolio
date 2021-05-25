$(document).ready(() => {
    $(".signin").hide();
    var passwordformat=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,30}$/;

    $(".input-box").keypress((e) => { 
        if (e.keyCode > 0) {
            $(".input-box").css("color", "#000000")
            $(".input-box").removeClass("error");
        }
    });

    $(".signin").submit(() => {
        let email = $(".signin .email").val();
        let password = $(".signin .password").val();

        if (!email) {
            $(".input-box.email").addClass("error");
            return false;
        }
        if (!password) {
            $(".input-box.password").addClass("error");
            return false;
        }

        $.get("https://babasama.com/api/login", {
            email: email,
            password: password
        }, (data) => {
            if (data !== []) 
                window.location.replace("https://babasama.com/api/dashboard")
            else {
                $(".input-box").addClass("error");
            }
        }, "JSON");
        return false;
    });

    $(".signup").submit(() => {
        let username = $(".signup .username").val()
        let email = $(".signup .email").val();
        let password = $(".signup .password").val();

        if (!username) { 
            $(".input-box.username").addClass("error");
            return false;
        }
        if (!email) {
            $(".input-box.email").addClass("error");
            return false;
        }
        if (!password) {
            $(".input-box.password").addClass("error");
            return false;
        }
        if (username.contains(" "))
        if (!password.match(passwordformat)) {
            $(".input-box.password").addClass("error");
            $(".input-box.password").val("");
            $(".signup .password").attr("placeholder", "Invalid format: please enter more than 6 character and only have at least 1 captial letter, 1 non captial letter, 1 number, 1 special character and no space.")
            return false;
        }

        $.post("https://babasama.com/api/signup", {
            username: username,
            email: email,
            password: password
        }, (data) => {
            console.log(data);
        }, "JSON");
        return false;
    });

    $(".switch-signin").click(() => {
        $(".input-box").val("");
        $(".input-box").removeClass("error");
        $(".signup").hide();
        $(".signin").show();
    });

    $(".switch-signup").click(() => {
        $(".input-box").val("");
        $(".input-box").removeClass("error");
        $(".signup").show();
        $(".signin").hide();
    });
});