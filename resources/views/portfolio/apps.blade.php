<!DOCTYPE html>
<html lang="en">

<head>
    @include('portfolio/header')
</head>

<body>
    <div class='overall'>
        <img src="https://babasama.com/portfolio/img/polar_night.jpeg" class="background-img">
        <main>
            @include('portfolio/nav')
            <div class="content">
                @include('portfolio/screens/projects/movie')
                @include('portfolio/screens/projects/airport')
                @include('portfolio/screens/projects/gymlog')
            </div>
        </main>
    </div>
    <script src="https://babasama.com/portfolio/js/index.js"></script>
    <script src="https://babasama.com/portfolio/js/view.js"></script>
    <script src="https://babasama.com/portfolio/js/nav.js"></script>
    <script src="https://babasama.com/portfolio/js/movie.js"></script>
    <script src="https://babasama.com/portfolio/js/airport.js"></script>
    <script src="https://babasama.com/portfolio/js/gymlog.js"></script>
    <script src="https://babasama.com/portfolio/js/faviconColor.js"></script>
</html>
