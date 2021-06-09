@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">{{ __('ようこそ') }}</div>

                <div class="card-body">
                    <h5 class="card-title">{{ __('Money-Bookへ') }}</h5>
                    @guest
                        <p class="card-text">{{ __('ログインまたは新規登録をしてください') }}</p>
                        <a class="btn btn-primary" href="{{ route('login') }}">{{ __('Login') }}</a>
                        <p>{{ __('or') }}</p>
                        <a class="btn btn-primary" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection