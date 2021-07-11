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
            <label class="link">
                
            </label>
            <pre class="result-content">
                
            </pre>
        </div>
    </div>

    <script src="https://babasama.com/api/js/list_of_api.js"></script>
@endsection