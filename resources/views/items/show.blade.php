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

            <div class="card">
                <div class="card-header">{{ __('商品詳細') }}</div>

                <div class="card-body">
                    <h5 class="card-title">{{ __('商品名：')}}{{ $item->name }}</h5>
                    <p class="card-text">{{ __('商品価格：') }}{{ $item->price }}{{ __('円') }}</p>
                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-primary">{{ __('編集') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection