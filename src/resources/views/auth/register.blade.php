@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('header')
<header class="header__box">
    <h1 class="header__logo">Atte</h1>
</header>
@endsection

@section('main')

<h2 class="register__title">会員登録</h2>
<div class="register__form">
    <form class="form" action="{{ route('register') }}" method="post">
        @csrf
        <input type="text" name="name" placeholder="名前" value="{{ old('name') }}" required />
        <div class="form__error">
            @error('name')
            {{ $message }}
            @enderror
        </div>
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
        <input type="password" name="password_confirmation" id="pass2" placeholder="確認用パスワード" required />
        <div class="form__error">
            @error('password_confirmation')
            {{ $message }}
            @enderror
        </div>
        <div class="register__button">
            <button class="register__button-submit" type="submit">会員登録</button>
        </div>
    </form>
</div>
<div class="login__box">
    <p class="move__text">アカウントをお持ちの方はこちらから</p>
    <a class="move__button" href="{{ route('login') }}">ログイン</a>
</div>
@endsection
