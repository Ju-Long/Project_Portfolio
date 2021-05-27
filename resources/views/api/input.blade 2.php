@extends('api.template.auth')

@section('input')

<div class="inputs">
    <form class="input-form signup">
        <header>Create an account</header>
        <input name="username" type="text" class="input-box username" placeholder="Please enter your username"/>
        <div id="error" class="username"hm>Please only enter numbers, english characters and _ and -</div>
        <input name="email" type="email" class="input-box email" placeholder="Please enter your email"/>
        <input name="password" type="password" class="input-box password" placeholder="Please enter your password"/>
        <div id="error" class="password">Invalid format: please enter more than 6 character and only have at least 1 captial letter, 1 non captial letter, 1 number, 1 special character and no space.</div>
        <button class="input-btn">Sign up</button>
        <p>Already have an account? <a class="switch-signin">Sign in</a></p>
    </form>
    <form class="input-form signin">
        <header>Login to your account</header>
        <input name="email" type="email" class="input-box email" placeholder="Please enter your email"/>
        <input name="password" type="password" class="input-box password" placeholder="Please enter your password"/>
        <button class="input-btn">Sign in</button>
        <p>Dont have an account? <a class="switch-signup">Sign up</a></p>
    </form>
</div>
    
@endsection