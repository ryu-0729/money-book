@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">{{ __('商品名') }}</th>
                        <th scope="col">{{ __('1個あたりの金額') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($userItems as $item)
                        <tr>
                            <th>{{ $item->name }}</th>
                            <th>{{ $item->price }}{{ __('円') }}</th>
                        </tr>
                    @empty
                        <tr>
                            <th>{{ __('登録した商品はありません') }}</th>
                        </tr>
                    @endforelse

                    {{ $userItems->links() }}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection