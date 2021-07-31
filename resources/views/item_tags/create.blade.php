@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('商品タグ登録') }}
                    <a class="btn btn-outline-primary" style="margin-left: 20px;" href="{{ route('items.index') }}">{{ __('商品一覧へ') }}</a>
                    <a class="btn btn-outline-primary" style="margin-left: 20px;" href="{{ route('item_tags.index') }}">{{ __('タグ一覧へ') }}</a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('message'))
                        <div class="alert alert-primary" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    {!! Form::open(['action' => ['ItemTagController@store'], 'method' => 'post']) !!}

                        <div class="form-group row">
                            {{ Form::label('tag_name', 'タグ名', ['class' => 'col-md-4 col-form-label text-md-right']) }}

                            <div class="col-md-6">
                                {{ Form::text('tag_name', '', ['class' => 'form-control']) }}
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {{ Form::submit('タグ登録', ['class' => 'btn btn-primary']) }}
                            </div>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection