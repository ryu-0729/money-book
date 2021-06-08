@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="input-group">
				<div class="form-outline">
					{!! Form::open(['action' => ['Money'], 'method' => 'get']) !!}
						{{ Form::select('month', $buyItemMonth, '', ['class' => 'form-control']) }}
						{{ Form::submit('金額集計', ['class' => 'btn btn-primary']) }}
					{!! Form::close() !!}
				</div>
			</div>

			<h1>{{ __('合計金額は') }}{{ $totalPrice }}{{ __('円') }}</h1>

			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">{{ __('購入商品名') }}</th>
						<th scope="col">{{ __('購入個数') }}</th>
						<th scope="col">{{ __('金額') }}</th>
						<th scope="col">{{ __('購入月') }}</th>
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
						</tr>
					@endforeach

					{{ $buyItems->links() }}
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection