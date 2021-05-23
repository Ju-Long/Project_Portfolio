$(document).ready(function () {
    var type = "signup";
    $(".signin").hide();

    $(".signin").submit(() => {
        let email = $(".signin .email").val();
        let password = $(".signin .password").val();

        $.get("https://babasama.com/api/signin", {
            email: email,
            password: password
        }, (data, textStatus, jqXHR) => {
            console.log(data);
        }, "JSON");
        return false;
    });

    $(".signup").submit(() => {
        let username = $(".signup .username").val()
        let email = $(".signup .email").val();
        let password = $(".signup .password").val();

        $.post("https://babasama.com/api/signup", {
            username: username,
            email: email,
            password: password
        }, (data, textStatus, jqXHR) => {
            console.log(data);
        }, "JSON");
        return false;
    });

    $(".switch-signin").click(() => {
        $(".signup").hide();
        $(".signin").show();
    });

    $(".switch-signup").click(() => {
        $(".signup").show();
        $(".signin").hide();
    });
});