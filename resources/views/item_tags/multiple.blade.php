@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                {!! Form::open(['action' => ['ItemTagController@multipleTagsUpdate'], 'method' => 'put']) !!}
                <div class="card-header text-center">
                    {{ __('タグを選んで、タグ付けしたい商品を選択してください') }}
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        {{ Form::label('tag_id', 'タグ名', ['class' => 'col-md-4 col-form-label text-md-right']) }}

                        <div class="col-md-6">
                            {{ Form::select('tag_id', $itemTags, '', ['class' => 'form-control']) }}
                            <small class="text-danger">{{ __('サブタグを設定している商品は、サブタグがリセットされます') }}</small>
                        </div>
                    </div>

                    @foreach ($items as $itemKey => $itemValue)
                        <div class="form-check form-check-inline">
                            {{ Form::checkbox('item[]', $itemValue->id, false, ['class' => 'form-check-input', 'id' => $itemKey]) }}
                            {{ Form::label($itemKey, $itemValue->name, ['class' => 'form-check-label']) }}
                        </div>
                    @endforeach

                    <div class="text-center" style="margin-top: 10px;">
                        {{ Form::submit('選択完了', ['class' => 'btn btn-primary']) }}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection