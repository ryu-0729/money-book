@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $itemTag->tag_name }}{{ __('タグの編集') }}
                    <a class="btn btn-outline-success" style="margin-left: 20px;" href="{{ route('item_tags.create') }}">タグ追加</a>
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

                    {!! Form::open(['action' => ['ItemTagController@update', $itemTag->id], 'method' => 'put']) !!}

                        <div class="form-group row">
                            {{ Form::label('tag_name', 'タグ名', ['class' => 'col-md-4 col-form-label text-md-right']) }}

                            <div class="col-md-6">
                                {{ Form::text('tag_name', $itemTag->tag_name, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {{ Form::submit('タグ更新', ['class' => 'btn btn-primary']) }}
                            </div>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
