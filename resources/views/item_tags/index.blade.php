@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1>{{ __('登録タグ一覧') }}</h1>

            @if (session('message'))
                <div class="alert alert-primary" role="alert">
                    {{ session('message') }}
                </div>
            @endif

            <h2>
                <a class="btn btn-outline-success" href="{{ route('item_tags.create') }}">タグ追加</a>
            </h2>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">{{ __('タグ名') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($itemTags as $tag)
                        <tr>
                            <th>{{ $tag->tag_name }}</th>
                            <th>
                                <a href="{{ route('item_tags.edit', $tag->id) }}" class="btn btn-primary">{{ __('タグ編集') }}</a>
                            </th>
                            <th>
                                {!! Form::open(['action' => ['ItemTagController@destroy', $tag->id], 'method' => 'delete']) !!}
                                    {{ Form::submit('タグ削除', ['class' => 'btn btn-danger']) }}
                                {!! Form::close() !!}
                            </th>
                        </tr>
                    @empty
                        <tr>
                            <th>{{ __('登録したタグはありません') }}</th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
