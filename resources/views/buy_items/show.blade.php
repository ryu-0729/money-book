@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('message'))
                <div class="alert alert-primary" role="alert">
                    {{ session('message') }}
                </div>
            @endif

            <div class="card text-center">
                <div class="card-header">
                    {{ __('購入商品詳細') }}
                    <a class="btn btn-outline-success" style="margin-left: 20px;" href="{{ route('buy_items.index') }}">{{ __('購入商品一覧へ') }}</a>
                </div>

                <div class="card-body">
                    <h5 class="card-title">{{ __('商品名：')}}{{ $buyItem->name }}</h5>
                    <p class="card-text">{{ __('購入個数：') }}{{ $buyItem->quantity }}{{ __('個') }}</p>
                    <p class="card-text">{{ __('合計金額：') }}{{ $buyItem->price }}{{ __('円') }}</p>
                    <a href="{{ route('buy_items.edit', $buyItem->id) }}" class="btn btn-primary" style="margin-bottom: 10px;">{{ __('編集') }}</a>
                    {!! Form::open(['action' => ['BuyItemController@destroy', $buyItem->id], 'method' => 'delete']) !!}
                        {{ Form::submit('購入商品削除', ['class' => 'btn btn-danger']) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection