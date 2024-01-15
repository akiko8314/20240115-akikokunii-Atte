@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('header')
<header class="header__box">
    <h1 class="header__logo">Atte</h1>
    <nav class="header__nav">
        <ul>
            <li class="header__nav--list"><a href="{{ route('attendance.index') }}">ホーム</a></li>
            <li class="header__nav--list"><a href="">日付一覧</a></li>
            <li class="header__nav--list">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="logout__button" type="submit">ログアウト</button>
                </form>
            </li>
        </ul>
    </nav>
</header>
@endsection

@section('main')

<h2 class="work__title">{{ auth()->user()->name }}さんお疲れ様です！</h2>
<div class="work__button-box">
    <div class="work__button">
        <form action="{{ route('startWork') }}" method="POST">
            @csrf
            <button type="submit" @if($hasStartedWork || $hasStartedBreak) disabled @endif class="work__start">勤務開始</button>
        </form>
    </div>
    <div class="work__button">
        <form action="{{ route('endWork') }}" method="POST">
            @csrf
            <button type="submit" @if(!$hasStartedWork) disabled @endif class="work__end">勤務終了</button>
        </form>
    </div>
</div>
<div class="work__button-box">
    <div class="break__button">
        <form action="{{ route('startBreak') }}" method="POST">
            @csrf
            <button type="submit" @if($hasStartedBreak || !$hasStartedWork) disabled @endif class="break__start">休憩開始</button>
        </form>
    </div>
    <div class="break__button">
        <form action="{{ route('endBreak') }}" method="POST">
            @csrf
            <button type="submit" @if(!$hasStartedBreak) disabled @endif class="break__end">休憩終了</button>
        </form>
    </div>
</div>

@endsection