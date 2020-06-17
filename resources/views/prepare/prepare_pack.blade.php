@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">1. Scan user card (R number)</div>
				
				@if (isset($msg))
					<span style="color:red">{{ $msg }}</span>
				@endif
				
				{!! Form::open(['url' => 'prepare_user']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
				
				{!! Form::hidden('function', 'PACK', ['class' => 'form-control']) !!}

				<div class="panel-body">
    					{!! Form::input('text', 'rnumber', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
   				</div>
				
				<div class="panel-body">
					{!! Form::submit('Confirm', ['class' => 'btn btn-success btn-lg center-block']) !!}
				</div>
				
				
				@include('errors.list')

				{!! Form::close() !!}
				
				<br>
				<div class="">
						<a href="{{url('/')}}" class="btn btn-default btn-lg center-block">Back to main menu</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection