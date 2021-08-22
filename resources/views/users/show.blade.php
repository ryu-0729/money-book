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
                <div class="card-header">{{ __('マイページ') }}</div>

                <div class="card-body">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="card-text">{{ $user->email }}</p>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">{{ __('編集') }}</a>
                </div>
            </div>
            <div class="card bg-light bg-primary mb-3 mx-auto text-center" style="margin-top: 20px;">
                <div class="card-header">{{ __('最近の購入商品確認') }}</div>
                <div class="card-body">
                    <h5 class="card-title">最近購入登録した商品の確認ができます</h5>
                    <p class="card-text">
                        <a href="{{ route('history') }}" class="btn btn-primary">{{ __('購入登録履歴へ') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
