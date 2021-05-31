$(document).ready(() => {
    var graph_data = [];
    $.get("https://babasama.com/api/dashboard/data", {},
        (data) => {
            console.log(data)
            data.forEach(i => {
                graph_data.push([i.day, i.times_a_day]);
            });
            console.log(graph_data);
            display_graph();
        }, "JSON"
    );

    $.get("https://babasama.com/api/dashboard/data2", {},
        (data) => {
            var api_data = "";
            data.forEach(i => {
                api_data += `<li class='list-item'>${i.IP_address}: <span>${i.times_a_month}</span></li>`;
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
});

