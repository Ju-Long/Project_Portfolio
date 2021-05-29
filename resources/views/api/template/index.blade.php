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

        {{-- jquery --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
    
        {{-- fontawesome --}}
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-yJpxAFV0Ip/w63YkZfDWDTU6re/Oc3ZiVqMa97pi8uPt92y0wzeK3UFM2yQRhEom" crossorigin="anonymous">
    
        {{-- anychart --}}
        <script src="https://cdn.anychart.com/releases/8.9.0/js/anychart-base.min.js"></script>

        {{-- prettify --}}
        <script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>
        
        <script src="https://babasama.com/api/js/nav.js"></script>
    </head>
<body>
    <div class="navbar">
        <div class="nav-brand">
            <a href="/api/dashboard">API Datacenter</a>
        </div>
        <ul class="nav-list">
            <li class="nav-item active" id="dashboard"><a href="https://babasama.com/api/dashboard" class="nav-link"><i class="fad fa-columns"></i> DashBoard</a></li>
            <li class="nav-item" id="list_of_api"><a href="https://babasama.com/api/education/list_of_api" class="nav-link"><i class="fad fa-list-alt"></i> API List</a></li>
            <li class="nav-item" ><a href="" class="nav-link"><i class="fad fa-book-spells"></i> Documentations</a></li>
            <li class="nav-item"><a href="" class="nav-link"><i class="fad fa-question-circle"></i> FAQs</a></li>
        </ul>
    </div>
    <main>
        <img src="https://babasama.com/api/img/main-bg.jpg" class="main-bg">
        @yield('main')
        @yield('list_of_api')
        @yield('documentary')
        @yield('faqs')
    </main>
</body>
</html>