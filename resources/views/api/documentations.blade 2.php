@extends('api.template.index')

@section('documentations')
    <div class="content documentations">
        <header>Documentations</header>
        <p class="pure">I want to write with datamall API</p>
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
                <span id="js" class="active">js</span>
            </div>
            <div class="codes-body">
                <script src="https://gist.github.com/Ju-Long/6da6e37c8e0cd56dd46af06ea4416dba.js"></script>
                <script src="https://gist.github.com/Ju-Long/841aa72bb22f3c5759a0e246a8dc0704.js"></script>
                <script src="https://gist.github.com/Ju-Long/40d42b9d0a34d6db8b9864fc846a152c.js"></script>
                <script src="https://gist.github.com/Ju-Long/328d6033665a88138d308a155b6dae86.js"></script>
                <script src="https://gist.github.com/Ju-Long/d52eca25e449bc937173bb1432434f67.js"></script>
                <script src="https://gist.github.com/Ju-Long/1d1a29fc9639b0c0b25578da7f8f15ac.js"></script>
                <script src="https://gist.github.com/Ju-Long/e10a29a7e15c576250824f41b07bed99.js"></script>
                <script src="https://gist.github.com/Ju-Long/0031697c7d8c961c25c5081128168e3e.js"></script>
                <script src="https://gist.github.com/Ju-Long/13bdee12f45fe8d39eb69410ece48185.js"></script>
                <script src="https://gist.github.com/Ju-Long/a328a87fb89cd5689ffadf5cde4d6ccb.js"></script>
                <script src="https://gist.github.com/Ju-Long/3c1505843e3803c37d589f70fcae6524.js"></script>
                <script src="https://gist.github.com/Ju-Long/70e41e6ef1bfe21cd08ddeae061d5cbb.js"></script>
            </div>
            <div class="console-output">
                
            </div>
        </div>
    </div>
    <script src="https://babasama.com/api/js/documentations.js"></script>
@endsection