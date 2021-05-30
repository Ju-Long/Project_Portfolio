@extends('api.template.index')

@section('main')
    <div class="content dashboard">
        <div class="top">
            <header>Dashboard</header>
            <div class="user">
                <strong>{ Welcome {{$username}} }</strong>
                <div class="user-dropdown">
                    <span class="account-setting">Account Settings</span>
                    <span class="seek-assistance">Seek Assistance</span>
                    <span class="logout"><a href="https://babasama.com/api/signout">Signout</a></span>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="display">
                <div class="api-data">
                    <div class="section">
                        <div class="section-header">
                            <i class="fa-duotone fa-layer-group"></i>
                             API calls that was made one month ago
                        </div>
                        <div class="section-body" id="graph">

                        </div>
                    </div>
                    <div class="section">
                        <div class="section-header">
                            <i class="fa-duotone fa-network-wired"></i>
                             IP Addresses that was made with the your API Key
                        </div>
                        <div class="section-body" id="list">

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <script src="https://babasama.com/api/js/dashboard.js"></script>
@endsection