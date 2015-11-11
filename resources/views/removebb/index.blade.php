@extends('mainpage')

@section('index')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Remove BB form Stock</div>
				
				{!! Form::open(['url' => 'removebb\destroy']) !!}

				<div class="panel-body">
					{!! Form::input('number', 'bb_to_remove', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>

				<div class="panel-body">
					{!! Form::submit('Remove BB', ['class' => 'btn btn-danger btn-lg center-block']) !!}
				</div>

				@include('errors.list')

				{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>
@endsection