$(document).ready(() => {
    var api_data = "";
    var graph_data = [];
    $.get("https://babasama.com/api/dashboard/data", {},
        (data) => {
            data.forEach(i => {
                graph_data.push([i.times_a_day, i.day]);
                api_data += `<li class='list-item'>${i.IP_address}: <span>${i.times_a_month}</span></li>`
            });
            display_graph();
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

