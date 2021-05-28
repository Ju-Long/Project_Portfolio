@extends('api.template.index')

@section('list_of_api')
    <div class="content list_of_api">
        <div class="list">
            <header>List of API Available</header>
            <div class="list-api-box">
                <div class="datamall api-box">
                    <strong>Datamall</strong>
                    <ul class="datamall-list">
                        <li class="list-item" id="get_nearest_bus_stop">get_nearest_bus_stop</li>
                        <li class="list-item" id="get_bus_arrival_time">get_bus_arrival_time</li>
                        <li class="list-item" id="get_bus_route">get_bus_route</li>
                        <li class="list-item" id="get_bus_stop_data">get_bus_stop_data</li>
                        <li class="list-item" id="get_bus_data">get_bus_data</li>
                    </ul>
                </div>

                <div class="quote api-box">
                    <strong>Random Quote</strong>
                    <ul class="quote-list">
                        <li class="list-item" id="get_random_quote">get_random_quote</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="api">
            <div class="link">
                'https://babasama.com/api/get_nearest_bus_stop'
            </div>
            <pre class="result-content">
    <code class="item-no">0:</code>
    <code class="item-data"><code class="item-data-key">BusStopCode: </code><code class="item-data-value string">11111</code></code>
    <code class="item-data"><code class="item-data-key">Description: </code><code class="item-data-value string">"BEF TUAS STH AVE 14"</code></code>
    <code class="item-no">0:</code>
        <code class="item-data">BusStopCode: 11111</code>
        <code class="item-data">BusStopCode: 11111</code>
        <code class="item-data">BusStopCode: 11111</code>
            </pre>
        </div>
    </div>

    <script src="http://localhost:8000/api/js/list_of_api.js"></script>
@endsection