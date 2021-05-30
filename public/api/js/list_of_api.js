$(document).ready(() => {
    const location = {latitude: 0, longitude: 0};
    getLocation()

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
            $.get("https://babasama.com/api/get_quote", {},
                (data) => {
                    data_display(data, id);
                }, "JSON");
        } else {
            $.post("https://babasama.com/api/education", {
                type: id,
                lat: location.latitude,
                long: location.longitude
            }, (data) => {
                  data_display(data, id);
            }, "JSON");
        }
    });

    const data_display = (data, id) => {
        let count = 0;
        let msg = "";
        data.forEach(i => {
            msg += `<code class='item-no'>${count}: </code>\n`;
            if (id === "get_nearest_bus_stop") {
                msg += `<code class='item-data'><code class='item-data-key'>BusStopCode: </code><code class='item-data-value int'>${i.BusStopCode}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>Description: </code><code class='item-data-value string'>${i.Description}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>RoadName: </code><code class='item-data-value string'>${i.RoadName}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>Latitude: </code><code class='item-data-value int'>${i.Latitude}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>Longitude: </code><code class='item-data-value int'>${i.Longitude}</code></code>\n`;
            } else if (id === "get_bus_arrival_time") {
                msg += `<code class='item-data'><code class='item-data-key'>ServiceNo: </code><code class='item-data-value string'>${i.ServiceNo}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>Operator: </code><code class='item-data-value string'>${i.Operator}</code></code>\n`;
                i.NextBus.forEach(n => {
                    msg += `<code class='item-data'><code class='item-data-key'>OriginCode: </code><code class='item-data-value int'>${n.OriginCode}</code></code>\n`;
                    msg += `<code class='item-data'><code class='item-data-key'>DestinationCode: </code><code class='item-data-value int'>${n.DestinationCode}</code></code>\n`;
                    msg += `<code class='item-data'><code class='item-data-key'>EstimatedArrival: </code><code class='item-data-value string'>${n.EstimatedArrival}</code></code>\n`;
                    msg += `<code class='item-data'><code class='item-data-key'>Latitude: </code><code class='item-data-value int'>${n.Latitude}</code></code>\n`;
                    msg += `<code class='item-data'><code class='item-data-key'>Longitude: </code><code class='item-data-value int'>${n.Longitude}</code></code>\n`;
                    msg += `<code class='item-data'><code class='item-data-key'>Feature: </code><code class='item-data-value string'>${n.Feature}</code></code>\n`;
                    msg += `<code class='item-data'><code class='item-data-key'>Load: </code><code class='item-data-value string'>${n.Load}</code></code>\n`;
                    msg += `<code class='item-data'><code class='item-data-key'>Type: </code><code class='item-data-value string'>${n.Type}</code></code>\n`;
                    msg += `<code class='item-data'><code class='item-data-key'>VisitNumber: </code><code class='item-data-value int'>${n.VisitNumber}</code></code>\n`;
                });
            } else if (id === "get_bus_route") {
                msg += `<code class='item-data'><code class='item-data-key'>BusStopCode: </code><code class='item-data-value int'>${i.BusStopCode}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>ServiceNo: </code><code class='item-data-value string'>${i.ServiceNo}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>Description: </code><code class='item-data-value string'>${i.Description}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>Direction: </code><code class='item-data-value int'>${i.Direction}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>Distance: </code><code class='item-data-value int'>${i.Distance}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>Latitude: </code><code class='item-data-value int'>${i.Latitude}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>Longitude: </code><code class='item-data-value int'>${i.Longitude}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>Operator: </code><code class='item-data-value string'>${i.Operator}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>RoadName: </code><code class='item-data-value string'>${i.RoadName}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>StopSequence: </code><code class='item-data-value int'>${i.StopSequence}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>WD_FirstBus: </code><code class='item-data-value int'>${i.WD_FirstBus}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>WD_LastBus: </code><code class='item-data-value int'>${i.WD_LastBus}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>SAT_FirstBus: </code><code class='item-data-value int'>${i.SAT_FirstBus}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>SAT_LastBus: </code><code class='item-data-value int'>${i.SAT_LastBus}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>SUN_FirstBus: </code><code class='item-data-value int'>${i.SUN_FirstBus}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>SUN_LastBus: </code><code class='item-data-value int'>${i.SUN_LastBus}</code></code>\n`;
            } else if (id === "get_bus_stop_data") {
                msg += `<code class='item-data'><code class='item-data-key'>BusStopCode: </code><code class='item-data-value int'>${i.BusStopCode}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>Description: </code><code class='item-data-value string'>${i.Description}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>RoadName: </code><code class='item-data-value string'>${i.RoadName}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>Latitude: </code><code class='item-data-value int'>${i.Latitude}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>Longitude: </code><code class='item-data-value int'>${i.Longitude}</code></code>\n`;
            } else if (id === "get_bus_data") {
                msg += `<code class='item-data'><code class='item-data-key'>ServiceNo: </code><code class='item-data-value string'>${i.ServiceNo}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>OriginCode: </code><code class='item-data-value int'>${i.OriginCode}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>DestinationCode: </code><code class='item-data-value int'>${i.DestinationCode}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>Category: </code><code class='item-data-value string'>${i.Category}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>Direction: </code><code class='item-data-value int'>${i.Direction}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>LoopDesc: </code><code class='item-data-value string'>${i.LoopDesc}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>Operator: </code><code class='item-data-value string'>${i.Operator}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>AM_Offpeak_Freq: </code><code class='item-data-value int'>${i.AM_Offpeak_Freq}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>AM_Peak_Freq: </code><code class='item-data-value int'>${i.AM_Peak_Freq}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>PM_Offpeak_Freq: </code><code class='item-data-value int'>${i.PM_Offpeak_Freq}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>PM_Peak_Freq: </code><code class='item-data-value int'>${i.PM_Peak_Freq}</code></code>\n`;
            } else if (id === "get_random_quote") {
                msg += `<code class='item-data'><code class='item-data-key'>author: </code><code class='item-data-value string'>${i.author}</code></code>\n`;
                msg += `<code class='item-data'><code class='item-data-key'>text: </code><code class='item-data-value string'>${i.text}</code></code>\n`;
            }
            count++;
        }); 
        $(".result-content").html(msg);  
    }
});

const data = 
{ datamall: {
    get_nearest_bus_stop: {
        displaylink: 'https://babasama.com/api/get_nearest_bus_stop'
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
}}