@extends('api.template.index')

@section('main')
    <div class="content dashboard">
        <div class="top">
            <header>Dashboard</header>
            <div class="user">
                <strong>{ Welcome {{$username}} }</strong>
                <div class="user-dropdown">
                    <span id="account-setting">Account Settings</span>
                    <span id="seek-assistance"><a href="mailto:support@babasama.com">Seek Assistance</a></span>
                    <span id="signout"><a href="https://babasama.com/api/signout">Signout</a></span>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="display">
                <div class="account-setting">
                    <div class="top-left-button">
                        <i class="fa-duotone fa-arrow-left"></i>
                        Back
                    </div>
                    <header>Account Settings</header>
                    <div class="account-setting-body">
                        <div class="row">
                            <span>
                                <i class="fa-duotone fa-user username"></i> Username: 
                            </span>
                            <div>
                                <input type="text" value="{{ $username }}" id="username">
                                <i class="fa-duotone fa-check username"></i>
                            </div>
                        </div>
                        <div class="row">
                            <span>
                                <i class="fa-duotone fa-envelope-open email"></i> Email: 
                            </span>
                            <div>
                                <input type="email" value="{{ $email }}" id="email">
                                <i class="fa-duotone fa-check email"></i>
                            </div>
                        </div>
                        <div class="row">
                            <span>
                                <i class="fa-duotone fa-unlock-keyhole password"></i> Password: 
                            </span>
                            <div>
                                <input type="password" value="{{ $password }}" id="password">
                                <i class="fa-duotone fa-check password"></i>
                            </div>
                        </div>
                        <div class="row">
                            <span>
                                <i class="fa-duotone fa-key-skeleton apikey"></i> User API Key: 
                            </span>
                            <div>
                                <input type="text" value="{{ $user_api_key }}" disabled>
                                <i class="fa-duotone fa-lock-keyhole"></i>
                            </div>
                        </div>
                        <div class="row">
                            <span>
                                <i class="fa-duotone fa-key-skeleton datamall"></i> 
                                DataMall API Key
                            </span>
                            <div>
                                <input type="text" value="{{ $datamall_api }}" id="datamall" placeholder="Please insert datamall api key">
                                <i class="fa-duotone fa-check datamall"></i>
                            </div>
                        </div>
                        <span class="get" style="display: none"><a href="https://datamall.lta.gov.sg/content/datamall/en/request-for-api.html" target="_blank">get DataMall API Key</a></span>
                    </div>
                </div>

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