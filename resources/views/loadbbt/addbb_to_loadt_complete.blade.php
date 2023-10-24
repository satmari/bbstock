@extends('mainpage')

@section('index')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Scan pallet  </div>
				
				{!! Form::open(['url' => 'addbb_to_loadt_complete']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">

					{!! Form::hidden('location', $location, ['class' => 'form-control']) !!}
					{!! Form::hidden('inteosdb', $inteosdb, ['class' => 'form-control']) !!}
					
				<div class="panel-body">
					{!! Form::text('pallet', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>
				
				<div class="panel-body">
					{!! Form::submit('Confirm', ['class' => 'btn btn-success btn-lg center-block']) !!}
				</div>
				
				@if(isset($msg))
					<span style="color:red">{{ $msg }}</span>
				@endif
				
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