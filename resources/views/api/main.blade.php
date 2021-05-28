@extends('api.template.index')

@section('main')
    <div class="content dashboard">
        <div class="api-data">
            <section class="graph">
                <div class="header">
                    
                </div>
                <div class="body">

                </div>
            </section>
        </div>
        <div class="user-info">
            <b class="username">Welcome {{ $username }}</b>
            <div class="user-items">
                <span><a href="">Account Settings</a></span>
                <span><a href="">Contact Us</a></span>
            </div>
            <b class="logout"> <a href="https://babasama.com/api/signout">Logout</a> </b>
        </div>
    </div>
@endsection