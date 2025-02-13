@extends('mainpage')

@section('index')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">2. Scan BB to <big><b>{{ $location }}</b></big></div>
				
				@if(isset($msg))
				<span style="color:red;">{{ $msg }}</span>
				@endif
							
				{!! Form::open(['url' => 'set_to_transit']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
				
				{!! Form::hidden('location', $location, ['class' => 'form-control']) !!}
				
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

					<table class="table">
						<thead>
							<th>BB name</th>
							<th></th>
							
						</thead>
						@if(isset($bbaddarray_unique_tr)) 
							@foreach($bbaddarray_unique_tr as $array)

								<tr>
									@foreach($array as $key => $value)
									
										@if($key == 'bbname') {{--@if($key == 'BlueBoxNum')--}}
										<td>
								    		{{ substr($value, -13,10) }} <b>{{ substr($value, -3) }}</b>
								    	</td>
								    	<td>
								    		{!! Form::open(['url' => 'remove_to_transit']) !!}
											<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
											{!! Form::hidden('location', $location, ['class' => 'form-control']) !!}
											{!! Form::hidden('bb', $value, ['class' => 'form-control']) !!}
											{!! Form::hidden('inteosdb', $inteosdb, ['class' => 'form-control']) !!}

											{!! Form::submit('X', ['class' => 'btn btn-outline-danger btn-sm ']) !!}
											@include('errors.list')
											{!! Form::close() !!}
										</td>
								    	@endif
								    
							   		@endforeach
							    </tr>

							@endforeach
						@endif
						</table>
				<hr>

				{!! Form::open(['url' => 'addbb_to_transit']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">

				{!! Form::hidden('location', $location, ['class' => 'form-control']) !!}
				{!! Form::hidden('inteosbd', $inteosdb, ['class' => 'form-control']) !!}

				<div class="panel-body">
					{!! Form::submit('Confirm BB list', ['class' => 'btn btn-danger btn-lg center-block']) !!}
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