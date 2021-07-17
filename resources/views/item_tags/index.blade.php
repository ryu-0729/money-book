@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1>{{ __('登録タグ一覧') }}</h1>
            <h2>
                <a href="{{ route('item_tags.create') }}">タグ追加</a>
            </h2>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">{{ __('タグ名') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($itemTags as $tag)
                        <tr>
                            <th>
                                <a href="#">{{ $tag->tag_name }}</a>
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