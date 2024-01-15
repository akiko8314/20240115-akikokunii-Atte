@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('header')
<header class="header__box">
    <h1 class="header__logo">Atte</h1>
    <nav class="header__nav">
        <ul>
            <li class="header__nav--list"><a href="#">ホーム</a></li>
            <li class="header__nav--list"><a href="#">日付一覧</a></li>
            <li class="header__nav--list"><a href="#">ログアウト</a></li>
        </ul>
    </nav>
</header>
@endsection

@section('main')
<h2 class="attendance__title">date</h2>
<div>
    <table class="attendance">
        <tr>
            <th>名前</th>
            <th>勤務開始</th>
            <th>勤務終了</th>
            <th>休憩時間</th>
            <th>勤務時間</th>
        </tr>
        @foreach($stamps as $stamp)
        <tr>
            <td>{{ $stamp->user->name }}</td>
            <td>{{ $stamp->clock_in }}</td>
            <td>{{ $stamp->clock_out }}</td>
            <td>{{ $stamp->break_time }}</td>
            <td>{{ $stamp->work_time }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection