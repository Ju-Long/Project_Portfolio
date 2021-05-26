@extends('api.template.auth')

@section('forget_password')

<div class="forget-password">
    <div class="input-box-container">
        <header>Forget Password</header>
        <div class="input-box email">
            <label for="email">Please enter your email:</label>
            <input type="email" name="email" class="email">
            <button disabled><i class="fad fa-arrow-circle-right"></i></button>
        </div>
        <div class="input-box pin">
            <label for="pin">Please enter your pin that was sent to your email:</label>
            <input type="number" name="pin" class="pin">
            <button disabled><i class="fad fa-arrow-circle-right"></i></button>
        </div>
        <div class="input-box password">
            <label for="password">Please enter your new password:</label>
            <input type="password" name="password" class="password">
            <button disabled><i class="fad fa-arrow-circle-right"></i></button>
        </div>
    </div>
</div>

<script src="../../api/js/forget_password.js"></script>
    
@endsection