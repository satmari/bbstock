@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">2. Scan BB &nbsp <span class="label label-info text-huge">Function: <big>{{ $function }} </big></span></div>
				
				@if (isset($msg))
					<span style="color:red">{{ $msg }}</span>
				@endif

				{!! Form::open(['url' => 'prepare_scan']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">

				{!! Form::hidden('rnumber', $rnumber, ['class' => 'form-control']) !!}
				{!! Form::hidden('username', $username, ['class' => 'form-control']) !!}
				{!! Form::hidden('function', $function, ['class' => 'form-control']) !!}

				<div class="panel-body">
					<p>Location of Inteos: </p>
					{!! Form::select('inteosdb_new', array('1'=>'Subotica','2'=>'Kikinda'), $inteosdb, array('class' => 'form-control')); !!} 
				</div>

				<div class="panel-body">
    					{!! Form::input('number', 'bb', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
   				</div>
				
				<div class="panel-body">
					{!! Form::submit('Confirm', ['class' => 'btn btn-success btn-lg center-block']) !!}
				</div>

				@include('errors.list')

				{!! Form::close() !!}

				<hr>

				@if(isset($bbaddarray))
					<table class="table">
						<thead>
							<td>BB scaned list</td>
							<td></td>
							
						</thead>

					@foreach($bbaddarray as $array)
						<tr>
							<td>
							@foreach($array as $key => $value)
								@if($key == 'bbname')
						    		{{ $value }}
						    	@endif
						    @endforeach
					   		</td>
					   		<td></td>
					   		
					    </tr>

					@endforeach

						<tfoot>
						
						</tfoot>
					</table>
				@endif

				{!! Form::open(['url' => 'prepare_confirm']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				{!! Form::hidden('rnumber', $rnumber, ['class' => 'form-control']) !!}
				{!! Form::hidden('username', $username, ['class' => 'form-control']) !!}
				{!! Form::hidden('function', $function, ['class' => 'form-control']) !!}

				<div class="panel-body">
					{!! Form::submit('Confirm list', ['class' => 'btn btn-danger btn-lg center-block']) !!}
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