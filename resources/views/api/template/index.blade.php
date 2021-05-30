<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>API DataCenter</title>
        <link rel="stylesheet" href="https://babasama.com/api/css/nav.css">
        <link rel="stylesheet" href="https://babasama.com/api/css/dashboard.css">
        <link rel="stylesheet" href="https://babasama.com/api/css/list_of_api.css">
        <link rel="stylesheet" href="https://babasama.com/api/css/documentations.css">
        <link rel="stylesheet" href="https://babasama.com/api/css/faqs.css">

        {{-- jquery --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
    
        {{-- fontawesome --}}
        <script src="https://kit.fontawesome.com/f442a7350f.js" crossorigin="anonymous"></script>
    
        {{-- anychart --}}
        <script src="https://cdn.anychart.com/releases/8.9.0/js/anychart-base.min.js"></script>
        
        <script src="https://babasama.com/api/js/nav.js"></script>
    </head>
<body>
    <div class="navbar">
        <div class="nav-brand">
            <a href="/api/dashboard">API Datacenter</a>
        </div>
        <ul class="nav-list">
            <li class="nav-item active" id="dashboard"><a href="https://babasama.com/api/dashboard" class="nav-link"><i class="fa-duotone fa-table-layout"></i> DashBoard</a></li>
            <li class="nav-item" id="list_of_api"><a href="https://babasama.com/api/education/list_of_api" class="nav-link"><i class="fa-duotone fa-rectangle-list"></i> API List</a></li>
            <li class="nav-item" id="documentations"><a href="https://babasama.com/api/education/documentations" class="nav-link"><i class="fa-duotone fa-book-open-cover"></i> Documentations</a></li>
            <li class="nav-item" id="faqs"><a href="https://babasama.com/api/education/FAQs" class="nav-link"><i class="fa-duotone fa-circle-question"></i> FAQs</a></li>
        </ul>
    </div>
    <main>
        <img src="https://babasama.com/api/img/main-bg.jpg" class="main-bg">
        @yield('main')
        @yield('list_of_api')
        @yield('documentations')
        @yield('faqs')
    </main>
</body>
</html>