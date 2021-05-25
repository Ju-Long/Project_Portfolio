
$(document).ready(() => {
    $(".signin").hide();
    var passwordformat=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,30}$/;

    $(".input-box").keypress((e) => { 
        if (e.keyCode > 0) {
            $(".input-box").removeClass("error");
            $("#error").removeClass("show")
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
        if (!/^[0-9a-zA-Z_.-]{6,20}$/.test(username)) {
            $(".input-box.username").addClass("error");
            $(".input-box.username").val("");
            $("#error.username").addClass("show");
            return false;
        }
        if (!/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,30}$/.test(password)) {
            $(".input-box.password").addClass("error");
            $(".input-box.password").val("");
            $("#error.password").addClass("show");
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