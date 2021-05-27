<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Dashboard - API DataCenter</title>
        <link rel="stylesheet" href="../api/css/index.css">
        <link rel="stylesheet" href="../api/css/nav.css">
        <link rel="stylesheet" href="../api/css/dashboard.css">
    
        {{-- jquery --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
    
        {{-- fontawesome --}}
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-yJpxAFV0Ip/w63YkZfDWDTU6re/Oc3ZiVqMa97pi8uPt92y0wzeK3UFM2yQRhEom" crossorigin="anonymous">
    
        {{-- anychart --}}
        <script src="https://cdn.anychart.com/releases/8.9.0/js/anychart-base.min.js"></script>

        {{-- prettify --}}
        <script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>
        
    </head>
<body>
    <div class="navbar">
        <div class="nav-brand">
            <a href="/api/dashboard">API Datacenter</a>
        </div>
        <ul class="nav-list">
            <li class="nav-item active"><a href="" class="nav-link"><i class="fad fa-columns"></i> DashBoard</a></li>
            <li class="nav-item"><a href="" class="nav-link"><i class="fad fa-list-alt"></i> API List</a></li>
            <li class="nav-item"><a href="" class="nav-link"><i class="fad fa-book-spells"></i> Documentations</a></li>
            <li class="nav-item"><a href="" class="nav-link"><i class="fad fa-question-circle"></i> FAQs</a></li>
        </ul>
    </div>
    @yield('main')
</body>
</html>