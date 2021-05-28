$(document).ready(() => {
    const location = window.location.pathname;

    $(".nav-item.active").removeClass("active");
    if (location === "/api/dashboard") 
        $("#dashboard.nav-item").addClass("active");
    else if (location === "/api/education/list_of_api") 
        $("#list_of_api.nav-item").addClass("active");
});