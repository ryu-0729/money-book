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
                <div class="card-header">
                    {{ __('商品詳細') }}
                    <a class="btn btn-outline-success" style="margin-left: 20px;" href="{{ route('items.index') }}">{{ __('商品一覧へ') }}</a>
                    <a class="btn btn-outline-success" style="margin-left: 5px;" href="{{ route('item_tags.create') }}">{{ __('タグ登録へ') }}</a>
                </div>

                <div class="card-body">
                    <h5 class="card-title">{{ __('商品名：')}}{{ $item->name }}</h5>
                    <p class="card-text">{{ __('商品価格：') }}{{ $item->price }}{{ __('円') }}</p>

                    @forelse ($item->itemTags as $tag)
                        <p class="card-text">{{ __('商品タグ：') }}{{ $tag->tag_name }}</p>
                    @empty
                        <p class="card-text">登録されているタグはありません</p>
                    @endforelse

                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-primary" style="margin-bottom: 10px;">{{ __('編集') }}</a>
                    {!! Form::open(['action' => ['ItemController@destroy', $item->id], 'method' => 'delete']) !!}
                        {{ Form::submit('登録商品を削除', ['class' => 'btn btn-danger']) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection