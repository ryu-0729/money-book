@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="input-group">
				<div class="form-outline" style="margin-left: 20px;">
					{!! Form::open(['action' => ['Money'], 'method' => 'get', 'class' => 'form-inline']) !!}
						<div class="form-group row">
							{{ Form::label('month', '購入月：', ['class' => 'form-label']) }}

							<div style="margin-right: 50px;">
								{{ Form::select('month', $buyItemMonth, '', ['class' => 'form-control']) }}
							</div>
						</div>

						<div class="form-group row" style="margin-right: 50px;">
							{{ Form::label('tagId', 'タグ名：', ['class' => 'form-label']) }}
							<div>
							{{ Form::select('tagId', $selectTagNames, '', ['class' => 'form-control']) }}
							</div>
						</div>

						<div class="form-group row">
							<div>
								{{ Form::submit('金額集計', ['class' => 'btn btn-success']) }}
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>

			<h1 style="margin-top: 20px;">{{ __('合計金額は') }}{{ $totalPrice }}{{ __('円') }}</h1>

			<h2>
				@if ($month)
					{{ $month }}月
				@endif
				@if ($tagName)
					タグ名：{{ $tagName }}
				@endif
			</h2>

			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">@sortablelink('name', '購入商品名')</th>
                        <th scope="col">@sortablelink('quantity', '購入個数')</th>
                        <th scope="col">@sortablelink('price', '合計金額')</th>
                        <th scope="col">@sortablelink('month', '購入月')</th>
						<th scope="col">商品タグ名</th>
						<th scope="col">サブタグ名</th>
					</tr>
				</thead>

				<tbody>
					@foreach ($buyItems as $item)
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
					@endforeach

				</tbody>
			</table>
			{!! $buyItems->appends(\Request::except('page'))->render('pagination::bootstrap-4') !!}
		</div>
	</div>
</div>
@endsection