@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('購入商品登録') }}
                    <a class="btn btn-outline-success" style="margin-left: 20px;" href="{{ route('buy_items.index') }}">{{ __('購入商品一覧へ') }}</a>
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

                    {!! Form::open(['action' => ['BuyItemController@store'], 'method' => 'post']) !!}

                        <div class="form-group row">
                            {{ Form::label('name', '商品名', ['class' => 'col-md-4 col-form-label text-md-right']) }}

                            <div class="col-md-6">
                                {{ Form::select('name', $itemsName, '', ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('quantity', '購入個数', ['class' => 'col-md-4 col-form-label text-md-right']) }}

                            <div class="col-md-6">
                                {{ Form::number('quantity', '', ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('month', '購入月', ['class' => 'col-md-4 col-form-label text-md-right']) }}

                            <div class="col-md-6">
                                {{ Form::number('month', '', ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('price', '金額入力', ['class' => 'col-md-4 col-form-label text-md-right']) }}

                            <div class="col-md-6">
                                {{ Form::number('price', '', ['class' => 'form-control']) }}
                                <small class="text-danger">{{ __('※金額を手入力したい場合のみ入力してください') }}</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('priceOne', '商品1個あたりの金額', ['class' => 'col-md-4 col-form-label text-md-right']) }}

                            <div class="col-md-6">
                                {{ Form::text('priceOne', '商品を選択してください', ['class' => 'form-control', 'readonly']) }}
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {{ Form::submit('購入商品登録', ['class' => 'btn btn-primary']) }}
                            </div>
                        </div>
                    
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('DOMContentLoaded', function() {
        $('#name').on('change', function() {
            // 商品のIDを取得
            const itemId = $('#name').val();
            $.ajax({
                type : 'GET',
                url  : 'one_item_price',
                data : {itemId : itemId}
            }).done(function(result) {
                // 1個当たりの金額フォームに表示
                $('#priceOne').val(result);
            });
        });
    });
</script>
@endsection