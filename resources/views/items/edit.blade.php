@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('登録商品編集') }}
                    <a class="btn btn-outline-success" style="margin-left: 20px;" href="{{ route('item_tags.create') }}">{{ __('タグ登録へ') }}</a>
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

                    {!! Form::open(['action' => ['ItemController@update', $item->id], 'method' => 'put']) !!}

                        <div class="form-group row">
                            {{ Form::label('name', '商品名', ['class' => 'col-md-4 col-form-label text-md-right']) }}
                            
                            <div class="col-md-6">
                                {{ Form::text('name', $item->name, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('price', '商品価格', ['class' => 'col-md-4 col-form-label text-md-right']) }}
                            
                            <div class="col-md-6">
                                {{ Form::number('price', $item->price, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('tagId', '商品タグ', ['class' => 'col-md-4 col-form-label text-md-right']) }}

                            <div class="col-md-6">
                                @if (!empty($itemTag))
                                    {{ Form::select('tagId', $tagName, $itemTag->item_tag_id, ['class' => 'form-control']) }}
                                @else
                                    {{ Form::select('tagId', $tagName, '', ['class' => 'form-control']) }}
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('subTagId', 'サブタグ', ['class' => 'col-md-4 col-form-label text-md-right']) }}

                            <div class="col-md-6">
                                @if (!empty($subItemTag))
                                    {{ Form::select('subTagId', $tagName, $subItemTag->item_tag_id, ['class' => 'form-control']) }}
                                @else
                                    {{ Form::select('subTagId', $tagName, '', ['class' => 'form-control']) }}
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {{ Form::submit('登録商品更新', ['class' => 'btn btn-primary']) }}
                            </div>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection