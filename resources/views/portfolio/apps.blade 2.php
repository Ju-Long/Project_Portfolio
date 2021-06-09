<!DOCTYPE html>
<html lang="en">

<head>
    @include('portfolio/header')
</head>

<body>
    <div class='overall'>
        <img src="../portfolio/img/polar_night.jpeg" class="background-img">
        <main>
            @include('portfolio/nav')
            <div class="content">
                @include('portfolio/screens/projects/movie')
                @include('portfolio/screens/projects/airport')
                @include('portfolio/screens/projects/gymlog')
            </div>
        </main>
    </div>
    <script src="../portfolio/js/index.js"></script>
    <script src="../portfolio/js/view.js"></script>
    <script src="../portfolio/js/nav.js"></script>
    <script src="../portfolio/js/movie.js"></script>
    <script src="../portfolio/js/airport.js"></script>
    <script src="../portfolio/js/gymlog.js"></script>
    <script src="../portfolio/js/faviconColor.js"></script>
</html>
