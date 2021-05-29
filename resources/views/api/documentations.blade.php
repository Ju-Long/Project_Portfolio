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
                    <span class="option selected" data-value="get_nearest_bus_stop">get_nearest_bus_stop</span>
                    <span class="option" data-value="get_nearest_bus_stop">get_nearest_bus_stop</span>
                    <span class="option" data-value="get_nearest_bus_stop">get_nearest_bus_stop</span>
                </div>
            </div>
        </div>
    </div>
@endsection