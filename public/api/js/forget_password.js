$(document).ready(() => {
    var emailregex = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/
    $(".pin").hide();
    $(".password").hide();

    $(".input-box.email input").keypress(() => { emailvalidate(); });
    $(".input-box.email input").change(() => { emailvalidate(); });

    const emailvalidate = () => {
        if (emailregex.test($(".input-box.email input").val())) {
            $(".input-box.email button").addClass("proceed");
            $(".input-box.email button").removeAttr("disabled");
            return true;
        } else {
            $(".input-box.email button").removeClass("proceed");
            $(".input-box.email button").attr("disabled", "");
            return false;
        }};
    
    emailvalidate();
    var pin;
    var tries = 10;

    $(".input-box.email button").click(() => { 
        if (emailvalidate()) {
            $.post("https://babasama.com/api/generate_code", {
                email: $(".input-box.email input").val()
            }, (data) => {
                    pin = data[0].output
            }, "JSON");
            $(".pin").show();
            $(".email").hide();

            setTimeout(() => {
                if (Number($(".input-box.pin input").val()) != pin)
                    alert("time to enter the pin have run out. please try again")
            }, 300000);
        }
    });

    $(".input-box.pin input").keypress(() => { pinvalidate(); });
    $(".input-box.pin input").change(() => { pinvalidate(); });

    const pinvalidate = () => {
        if (Number($(".input-box.pin input").val()) > 99999 && Number($(".input-box.pin input").val()) < 1000000) {
            $(".input-box.pin button").addClass("proceed");
            $(".input-box.pin button").removeAttr("disabled");
            return true;
        } else {
            $(".input-box.pin button").removeClass("proceed");
            $(".input-box.pin button").attr("disabled", "");
            return false;
        }};

    $(".input-box.pin button").click(() => {
        if (pin == $(".input-box.pin input").val()) {
            $(".pin").hide();
            $(".password").show();
        } else {
            if (tries > 0) {
                tries--;
                alert(`Wrong pin being entered. please try again. you still have ${tries} tries left`);
            } else 
                window.location.href = "https://babasama.com/api/dashboard/forget_password";
        }
    });

    $(".input-box.password input").keypress(() => { passwordvalidate(); });
    $(".input-box.password input").change(() => { passwordvalidate(); });

    const passwordvalidate = () => {
        if (!/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,30}$/.test($(".input-box.password input"))) {
            $(".input-box.password button").addClass("proceed");
            $(".input-box.password button").removeAttr("disabled");
            return true;
        } else {
            $(".input-box.password button").removeClass("proceed");
            $(".input-box.password button").attr("disabled", "");
            return false;
        }
    }

    $(".input-box.password button").click(() => {
        if (!$(".input-box.email input").val() && $(".input-box.pin input").val() != pin) 
            window.location.href = "https://babasama.com/api/dashboard/forget_password"
        
        let email = $(".input-box.email input").val();
        let password = passwordvalidate() ? $(".input-box.password input").val() : "";

        if (password) {
            $.post("https://babasama.com/api/update_password", {
                email: email,
                password: password
            }, (data) => {
                if (data == 1) {
                    alert("password successfully updated");
                    setTimeout(() => {
                        window.location.href = "https://babasama.com/api/dashboard"
                    }, 3000);
                } else {
                    alert("password update failed. please try again.");
                    setTimeout(() => {
                        window.location.href = "https://babasama.com/api/dashboard/forget_password"
                    }, 3000);
                }
            }, "JSON");}
    });
});