@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">{{ __('購入商品名') }}</th>
                        <th scope="col">{{ __('購入個数') }}</th>
                        <th scope="col">{{ __('合計金額') }}</th>
                        <th scope="col">{{ __('購入月') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($userBuyItems as $item)
                        <tr>
                            <th>
                                <a href="#">{{ $item->name }}</a>
                            </th>
                            <th>{{ $item->quantity }}{{ __('個') }}</th>
                            <th>{{ $item->price }}{{ __('円') }}</th>
                            <th>{{ $item->month }}{{ __('月') }}</th>
                        </tr>
                    @empty
                        <tr>
                            <th>{{ __('購入した商品はありません') }}</th>
                        </tr>
                    @endforelse

                    {{ $userBuyItems->links() }}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection