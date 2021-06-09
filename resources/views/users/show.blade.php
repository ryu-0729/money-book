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
        </div>
    </div>
</div>
@endsection