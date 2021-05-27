<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <title></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <style type="text/css">
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            div {
                display: grid;
                align-items: center;
                justify-content: space-around;
                height: 50vh;
                background: url('https://babasama.com/portfolio/img/polar_night.jpeg') no-repeat;
                background-size: 100vw 100vh;
            }
            h2 {
                font-weight: bold;
                text-align: center;
                text-decoration: underline;
                color: white;
            }
            a {
                text-align: center;
                padding: 5vw 5vh;
                text-decoration: none;
                border-radius: 10px;
                border: 1px solid black;
                color: white;
            }
        </style>
    </head>
    <body>
        <div>
            <h2>Please Confirm Your Email Address</h2>
            <a href="https://babasama.com/confirm-signup?token={{ $random_str }}">Click Here</a>
        </div>
    </body>
</html>