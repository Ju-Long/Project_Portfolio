$(document).ready(() => {
    const location = {latitude: 0, longitude: 0};

    const getLocation = () => {
        if (navigator.geolocation)
            navigator.geolocation.getCurrentPosition((position) => {
                location.latitude = position.coords.latitude;
                location.longitude = position.coords.longitude;
            }, (error) => {
                switch (error.code) {
                    case error.PERMISSION_DENIED: 
                        alert('user denial');
                        break;
                    
                    case error.POSITION_UNAVAILABLE:
                        alert('position not available');
                        break;
                    
                    case error.TIMEOUT:
                        alert('timeout');
                        break;
                    
                    default:
                        alert('unknown error');
                }
            });
        else
            alert("Geolocation is not supported by this browser.")
    }
    
    $(".list-item").click((e) => { 
        let id = e.target.id;
        if (id === "get_nearest_bus_stop") {
            $(".link").html(data.datamall.get_nearest_bus_stop.displaylink);
            getLocation();
        } else if (id === "get_bus_arrival_time")
            $(".link").html(data.datamall.get_bus_arrival_timing.displaylink);
        else if (id === "get_bus_route")
            $(".link").html(data.datamall.get_bus_route.displaylink);
        else if (id === "get_bus_stop_data")
            $(".link").html(data.datamall.get_bus_stop_data.displaylink);
        else if (id === "get_bus_data")
            $(".link").html(data.datamall.get_bus_data.displaylink);
        if (id === "get_random_quote") {
            $(".link").html(data.quote.get_quote.displaylink);
            $.get("https://babasama.com/get_quote", {},
                (data) => {
                    console.log(data);
                }, "JSON");
        } else {
            $.post("https://babasama.com/api/website", {
                type: id,
                lat: location.latitude,
                long: location.longitude
            }, (data) => {
                console.log(data)        
            }, "JSON");
        }
    });

});

const data = 
{
    datamall: {
        get_nearest_bus_stop: {
            displaylink: 'https://babasama.com/api/get_nearest_bus_stop',
            test: "https://babasama.com/test"
        }, get_bus_arrival_timing: {
            displaylink: 'https://babasama.com/api/get_bus_arrival_timing'
        }, get_bus_route: {
            displaylink: 'https://babasama.com/api/get_bus_route'
        }, get_bus_data: {
            displaylink: 'https://babasama.com/api/get_bus_data'
        }, get_bus_stop_data: {
            displaylink: 'https://babasama.com/api/get_bus_stop_data'
        },
    }, quote: {
        get_quote: {
            displaylink: 'https://babasama.com/api/get_quote'
        }
    }
}