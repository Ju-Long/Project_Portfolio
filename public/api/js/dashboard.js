$(document).ready(() => {
    var emailregex = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
    $(".api-data").addClass("show");
    var graph_data = [];
    $.get("https://babasama.com/api/dashboard/data_by_day", {},
        (data) => {
            data.forEach(i => {
                graph_data.push([i.date_of_calling, i.times_called]);
            });
            display_graph();
        }, "JSON"
    );

    $.get("https://babasama.com/api/dashboard/data_by_ip_address", {},
        (data) => {
            var api_data = "";
            data.forEach(i => {
                api_data += `<li class='list-item'>${i.ip_address}: <span>${i.count}</span></li>`;
            });
            $("#list.section-body").html(api_data);
        }, "JSON"
    );
    
    const display_graph = () => {
        const chart = anychart.column();
        const series = chart.column(graph_data);
        chart.title("");
    
        chart.xAxis().title("Date");
        chart.yAxis().title("Amount Called");
        chart.container("graph");
        chart.draw();
    }

    const passwordvalidate = (password) => {
        if (!/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,30}$/.test(password)) 
            return true;
        return false;
    }

    const emailvalidate = (email) => {
        if (emailregex.test(email)) 
            return true;
        return false;
    }

    $(".user strong").click(() => { 
        if ($(".user .user-dropdown").hasClass('active')) 
            $(".user .user-dropdown").removeClass('active');
        else 
            $(".user .user-dropdown").addClass('active');
    });

    $(".user-dropdown").click((e) => { 
        let id = e.target.id;
        $(".user-dropdown span").removeAttr("disabled");
        $(".user-dropdown span").removeClass("disabled");
        $(`.user-dropdown #${id}`).attr("disabled", "");
        $(`.user-dropdown #${id}`).addClass("disabled");
        $(".user .user-dropdown").removeClass('active');
        $(".display .show").removeClass("show");
        $(`.${id}`).addClass("show");
    });

    $(".account-setting-body .row div input").focus((e) => { 
        let id = e.target.id
        if (id === "username") 
            $("i.fa-user").addClass("active");
        else if (id === "email")
            $("i.fa-envelope-open").addClass("active");
        else if (id === "password")
            $("i.fa-unlock-keyhole").addClass("active");
        else if (id === "apikey")
            $("i.fa-key-skeleton").addClass("active");
    }).focusout(() => {
        $(".account-setting-body .row span i").removeClass("active");
    });

    $(".account-setting-body .row div input").on("input", (e) => {
        let id = e.target.id
        $(`.row div i.${id}.fa-check`).removeClass("fa-check");
        $(`.row div i.${id}`).addClass(["fa-loader", "fa-loader fa-spin-pulse"]);
        $(".top-left-button").addClass("loading");

        if (id === "username" && /^[0-9a-zA-Z_.-]{6,20}$/.test($("input#username").val())) 
            $.post("https://babasama.com/api/update_user_cred", {
                username: $("input#username").val()
            }, (data) => {
                if (data > 0) {
                    $(`.row div i.${id}.fa-loader.fa-spin-pulse`).removeClass(["fa-loader", "fa-spin-pulse"]);
                    $(`.row div i.${id}`).addClass("fa-check");
                    $(".top-left-button").removeClass("loading");
                } else {
                    alert('cannot be updated')
                }}, "text"
            );
        else if (id === "email" && emailvalidate($($("input#email").val())))
            $.post("https://babasama.com/api/update_user_cred", {
                email: $("input#email").val()
            }, (data) => {
                if (data > 0) {
                    $(`.row div i.${id}.fa-loader.fa-spin-pulse`).removeClass(["fa-loader", "fa-spin-pulse"]);
                    $(`.row div i.${id}`).addClass("fa-check");
                    $(".top-left-button").removeClass("loading");
                } else {
                    alert('cannot be updated')
                }}, "text"
            );
        else if (id === "password" && passwordvalidate($("input#password").val()))
            $.post("https://babasama.com/api/update_user_cred", {
                password: $("input#password").val()
            }, (data) => {
                if (data > 0) {
                    $(`.row div i.${id}.fa-loader.fa-spin-pulse`).removeClass(["fa-loader", "fa-spin-pulse"]);
                    $(`.row div i.${id}`).addClass("fa-check");
                    $(".top-left-button").removeClass("loading");
                } else {
                    alert('cannot be updated')
                }}, "text"
            );
        else if (id === "datamall")
            $.post("https://babasama.com/api/update_user_cred", {
                datamall: $("input#datamall").val()
            }, (data) => {
                if (data > 0) {
                    $(`.row div i.${id}.fa-loader.fa-spin-pulse`).removeClass(["fa-loader", "fa-spin-pulse"]);
                    $(`.row div i.${id}`).addClass("fa-check");
                    $(".top-left-button").removeClass("loading");
                } else {
                    alert('cannot be updated')
                }}, "text"
            );
    });

    $(".top-left-button").click(() => { 
        if ($(".top-left-button").hasClass("loading")) {
            alert("the data is still being saved. please wait for data to be synced.")
        } else {
            $(".user-dropdown span").removeAttr("disabled");
            $(".user-dropdown span").removeClass("disabled")
            $(".user .user-dropdown").removeClass('active');
            $(".display .show").removeClass("show");
            $(".api-data").addClass("show");
        }
    });
});

