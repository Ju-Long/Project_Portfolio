$(document).ready(() => {
    $(".signin").hide();
    const username_error_msg = "Please only enter numbers, english characters and _ and -";
    const password_error_msg = "Please enter more than 6 character and only have at least 1 captial letter, 1 non captial letter, 1 number, 1 special character and no space."

    $(".input-box").change(() => { 
        $(".input-box").removeClass("error");
        $("#error").removeClass("show");
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
        if (!/^[0-9a-zA-Z_.-]{6,20}$/.test(username)) {
            $(".input-box.username").addClass("error");
            $(".input-box.username").val("");
            $("#error").html(username_error_msg);
            $("#error").addClass("show");
            return false;
        }
        if (!/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,30}$/.test(password)) {
            $(".input-box.password").addClass("error");
            $(".input-box.password").val("");
            $("#error").html(password_error_msg);
            $("#error").addClass("show");
            return false;
        }

        $.post("https://babasama.com/api/signup", {
            username: username,
            email: email,
            password: password
        }, (data) => {
            if (data[0].output == "new user created") {
                alert("new user successfully created, please check your email to confirm your email address");
                setTimeout(() => {
                    window.location.replace("https://babasama.com/api/dashboard")
                }, 3000);
            } else  {
                $("#error").html(data[0].output);
                $("#error").addClass("show");
            }
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