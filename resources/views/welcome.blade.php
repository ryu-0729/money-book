@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">{{ __('ようこそ') }}</div>

                <div class="card-body">
                    <h5 class="card-title">{{ config('app.name', 'Laravel') }}{{ __('へ') }}</h5>
                    @guest
                        <p class="card-text">{{ __('ログインまたは新規登録をしてください') }}</p>
                        <a class="btn btn-primary" href="{{ route('login') }}">{{ __('Login') }}</a>
                        <p>{{ __('or') }}</p>
                        <a class="btn btn-primary" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endguest
                </div>
            </div>

            <div class="text-center text-success" style="margin-top: 50px;">
                <h1>MoneyBookでお金の管理をしよう！</h1>
                <h2>月ごとに使った金額を集計してくれる！</h2>
            </div>

            <div class="card" style="margin-bottom: 20px;">
                <img src="{{ asset('images/商品登録.png') }}" class="rounded mx-auto d-block" width="100%" height="300">
                <div class="card-body">
                    <h5 class="card-title">1.商品登録</h5>
                    <p class="card-text">商品名、1個単価の金額を登録！</p>
                    <p class="card-text"><small class="text-muted">タグ付けは後でも大丈夫！</small></p>
                </div>
            </div>

            <div class="card" style="margin-bottom: 20px;">
            <img src="{{ asset('images/購入商品登録.png') }}" class="rounded mx-auto d-block" width="100%" height="300">
                <div class="card-body">
                    <h5 class="card-title">2.購入商品登録</h5>
                    <p class="card-text">1.で登録していた商品を選択！</p>
                    <p class="card-text">その他、購入個数と購入月を入力！</p>
                    <p class="card-text"><small class="text-muted">次で最後！</small></p>
                </div>
            </div>

            <div class="card" style="margin-bottom: 20px;">
            <img src="{{ asset('images/金額集計.png') }}" class="rounded mx-auto d-block" width="100%" height="400">
                <div class="card-body">
                    <h5 class="card-title">3.金額集計</h5>
                    <p class="card-text">金額集計したい月を選択して金額集計ボタンをクリック！</p>
                    <p class="card-text">使った金額を集計してくれる！</p>
                    <p class="card-text"><small class="text-muted">タグごとで金額を見ることもできる！</small></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection