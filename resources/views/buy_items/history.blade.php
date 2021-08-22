@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>{{ __('購入登録履歴') }}</h1>

            <div class="card">
                <div class="card-header text-center">
                    {{ __('直近の購入登録') }}
                </div>

                <div class="card-body text-center">
                    <h5 class="card-title">商品名：{{ $firstBuyItemHistory->name }}</h5>
                    <p class="card-text">登録日時：{{ $firstBuyItemHistory->updated_at->format('Y年m月d日') }}</p>
                    <p class="card-text">購入個数：{{ $firstBuyItemHistory->quantity }}個</p>
                    <p class="card-text">金額：{{ $firstBuyItemHistory->price }}円</p>
                </div>
            </div>

            <h2 style="margin-top: 20px;">最近の購入登録</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">購入商品名</th>
                        <th scope="col">購入個数</th>
                        <th scope="col">金額</th>
                        <th scope="col">日時</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($buyItemHistory as $buyItem)
                    <tr>
                        <th>{{ $buyItem->name }}</th>
                        <th>{{ $buyItem->quantity }}個</th>
                        <th>{{ $buyItem->price }}円</th>
                        <th>{{ $buyItem->updated_at->format('Y年m月d日') }}</th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
