@extends('mainpage')

@section('index')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Add Location</div>
				
				@if(isset($msg))
				<h4 style="color:red;">{{ $msg }}</h4>
				@endif
							
				{!! Form::open(['url' => 'addbbsave']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
				
				<div class="panel-body">
					{!! Form::input('location', 'location', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>

				
				<div class="panel-body">
					{!! Form::submit('Confirm', ['class' => 'btn btn-danger btn-lg center-block']) !!} 
				</div>
				
				@include('errors.list')
				{!! Form::close() !!}
				<hr>

				
				<br>
				<div class="">
						<a href="{{url('/')}}" class="btn btn-default btn-lg center-block">Back to main menu</a>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection