@extends('layouts.master')
@section('title', '商品搜尋')
@section('content')
<main>
    <div class="main-content">
        @foreach ($merchandises as $merchandise)
            <div class="content-box">
                <h2 class="merchandise-name">{{ $merchandise->name }}</h2>
                <a href="/merchandise/{{ $merchandise->id }}/show">
                    <img src="/images/{{ $merchandise->photo }}" class="merchandise-photo">
                </a>
                <div class="merchandise-price">
                    NT$ <b>{{ $merchandise->price }}</b> 元
                </div>
            </div>
        @endforeach
    </div>
</main>
@endsection