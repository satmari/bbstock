@extends('mainpage')

@section('index')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Add multiple BB to Stock</div>
				
				{!! Form::open(['url' => 'set_to_add2']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
				
				<div class="panel-body">
					<p>Location of Inteos: </p>
					{!! Form::select('inteosdb_new', array('1'=>'Subotica','2'=>'Kikinda','3'=>'Senta'), $inteosdb, array('class' => 'form-control')); !!} 
				</div>

				<div class="panel-body">
					{!! Form::input('number', 'bb_to_add', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>

				
				<div class="panel-body">
					{!! Form::submit('Add BB to list', ['class' => 'btn btn-danger btn-lg center-block']) !!} 
				</div>
				
				@include('errors.list')
				{!! Form::close() !!}
				<hr>

				
				@if(isset($bbaddarray_unique))
					<table class="table">
						<thead>
							<td>BB name</td>
							<td></td>
						</thead>

					@foreach($bbaddarray_unique as $array)
						<tr>
							<td>
							@foreach($array as $key => $value)
								@if($key == 'BlueBoxNum')
						    		{{ $value }}
						    	@endif
						    @endforeach
					   		</td>
					   		<td></td>
					    </tr>
					@endforeach

						<tfoot>
						<tr>
							<td>
								Total:
							</td>
					   		<td>
							<big><b>{{ $sumofbb }}</b></big>
					   		</td>
					    </tr>
						</tfoot>
					</table>
				@endif

				{!! Form::open(['url' => 'addbbloc2']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">


				<div class="panel-body">
					{!! Form::submit('Add list to location', ['class' => 'btn btn-danger btn-lg center-block']) !!}
				</div>

				@if(isset($msg))
					<h4 style="color:red;">{{ $msg }}</h4>
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