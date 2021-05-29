@extends('api.template.index')

@section('documentations')
    <div class="content documentations">
        <header>Documentations</header>
        <p class="pure">I want to write with datamall API</p>
        <div class="body">
            <div class="select-wrapper">
                <div class="select">
                    <div class="select-trigger">
                        <span>get_nearest_bus_stop</span>
                        <i class="fa-solid fa-sort-down"></i>
                    </div>
                    <div class="options">
                        <span class="option selected" id="get_nearest_bus_stop">get_nearest_bus_stop</span>
                        <span class="option" id="get_bus_arrival_time">get_bus_arrival_time</span>
                        <span class="option" id="get_bus_route">get_bus_route</span>
                        <span class="option" id="get_bus_stop_data">get_bus_stop_data</span>
                        <span class="option" id="get_bus_data">get_bus_data</span>
                        <span class="option" id="get_random_quote">get_random_quote</span>
                    </div>
                </div>
            </div>
            <div class="codes">
                <div class="codes-lang">
                    <span id="php">php</span>
                    <span id="js">js</span>
                    <span id="php">php</span>
                    <span id="php">php</span>
                    <span id="php">php</span>
                    <span id="php">php</span>
                </div>
                <div class="codes-body">
    
                </div>
            </div>
        </div>
    </div>
    <script src="http://localhost:8000/api/js/documentations.js"></script>
@endsection