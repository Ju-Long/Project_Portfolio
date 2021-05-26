@extends('api.template.auth')

@section('input')

<div class="inputs">
    <form class="input-form signup">
        <header>Create an account</header>
        <input name="username" type="text" class="input-box username" placeholder="Please enter your username"/>
        <input name="email" type="email" class="input-box email" placeholder="Please enter your email"/>
        <input name="password" type="password" class="input-box password" placeholder="Please enter your password"/>
        <div id="error"></div>
        <button class="input-btn">Sign up</button>
        <p>Already have an account? <a class="switch-signin">Sign in</a></p>
    </form>
    <form class="input-form signin">
        <header>Login to your account</header>
        <input name="email" type="email" class="input-box email" placeholder="Please enter your email"/>
        <input name="password" type="password" class="input-box password" placeholder="Please enter your password"/>
        <button class="input-btn">Sign in</button>
        <p>Dont have an account? <a class="switch-signup">Sign up</a></p>
        <a href="https://babasama.com/api/dashboard/forget_password">forget password?</a>
    </form>
</div>

<script src="../../api/js/signup.signin.js"></script>
    
@endsection