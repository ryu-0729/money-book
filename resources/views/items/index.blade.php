@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1>{{ __('商品一覧') }}</h1>

            <h2>
                <a class="btn btn-outline-success" href="{{ route('items.create') }}">{{ __('商品登録') }}</a>
                <a class="btn btn-outline-success" href="{{ route('item_tags.create') }}">{{ __('タグ登録') }}</a>
            </h2>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">@sortablelink('name', '商品名')</th>
                        <th scope="col">@sortablelink('price', '商品価格')</th>
                        <th scope="col">{{ __('商品タグ') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($userItems as $item)
                        <tr>
                            <th>
                                <a href="{{ route('items.show', $item->id) }}">{{ $item->name }}</a>
                            </th>
                            <th>{{ $item->price }}{{ __('円') }}</th>
                            @forelse ($item->itemTags as $tag)
                                <th class="text-success">{{ $tag->tag_name }}</th>
                            @empty
                                <th>＊タグはありません</th>
                            @endforelse
                        </tr>
                    @empty
                        <tr>
                            <th>{{ __('登録した商品はありません') }}</th>
                        </tr>
                    @endforelse

                    {!! $userItems->appends(\Request::except('page'))->render() !!}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection