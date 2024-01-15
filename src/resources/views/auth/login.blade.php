@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('header')
<header class="header__box">
    <h1 class="header__logo">Atte</h1>
</header>
@endsection

@section('main')

<h3 class="login__title">ログイン</h3>
<div class="login__form">
    <form class="login__form__content" action="{{ route('login') }}" method="post">
        @csrf
        <input type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}" required />
        <div class="form__error">
            @error('email')
            {{ $message }}
            @enderror
        </div>
        <input type="password" name="password" id="pass" placeholder="パスワード" required />
        <div class="form__error">
            @error('password')
            {{ $message }}
            @enderror
        </div>
        <div class="login__button">
            <button class="login__button-submit" type="submit">ログイン</button>
        </div>
    </form>
</div>
<div class="register__box">
    <p class="move__text">アカウントをお持ちでない方はこちらから</p>
    <a class="move__button" href="{{ route('register') }}">会員登録</a>
</div>
@endsection