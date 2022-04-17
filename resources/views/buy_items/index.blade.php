@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1>{{ __('購入商品一覧') }}</h1>

            <h2>
                <a class="btn btn-outline-success" href="{{ route('monies') }}">{{ __('金額集計ページへ') }}</a>
                <a class="btn btn-outline-success" href="{{ route('buy_items.create') }}">{{ __('購入商品登録') }}</a>
            </h2>

            @if (session('message'))
                <div class="alert alert-primary" role="alert">
                    {{ session('message') }}
                </div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">@sortablelink('name', '購入商品名')</th>
                        <th scope="col">@sortablelink('quantity', '購入個数')</th>
                        <th scope="col">@sortablelink('price', '合計金額')</th>
                        <th scope="col">@sortablelink('month', '購入月')</th>
                        <th scope="col">商品タグ</th>
                        <th scope="col">サブタグ</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($userBuyItems as $item)
                        <tr>
                            <th>
                                <a href="{{ route('buy_items.show', $item->id) }}">{{ $item->name }}</a>
                            </th>
                            <th>{{ $item->quantity }}{{ __('個') }}</th>
                            <th>{{ $item->price }}{{ __('円') }}</th>
                            <th>{{ $item->month }}{{ __('月') }}</th>
                            <th class="text-success">{{ $item->item_tag_name }}</th>
                            <th class="text-success">{{ $item->sub_item_tag_name }}</th>
                        </tr>
                    @empty
                        <tr>
                            <th>{{ __('購入した商品はありません') }}</th>
                        </tr>
                    @endforelse

                </tbody>
            </table>
            {!! $userBuyItems->appends(\Request::except('page'))->render('pagination::bootstrap-4') !!}
        </div>
    </div>
</div>
@endsection