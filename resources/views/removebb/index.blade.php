@extends('mainpage')

@section('index')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Remove BB form Stock</div>
				
				@if(isset($msg))
				<h4 style="color:red;">{{ $msg }}</h4>
				@endif
							
				{!! Form::open(['url' => 'removebb\destroy']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
				
				<div class="panel-body">
					{!! Form::input('number', 'bb_to_remove', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>

				{{--
				<div class="panel-body">
					{!! Form::submit('Remove BB', ['class' => 'btn btn-danger btn-lg center-block']) !!} 
				</div>
				--}}
				@include('errors.list')
				{!! Form::close() !!}
				<hr>

				{{-- 
				<input id="proba" type="text" class="form-control" name="proba">
				<div id="display"></div>
				--}}

				@if(isset($bb_to_remove_array_unique))
					<table class="table">
						<thead>
							<td>BB name</td>
							<td>BB qty</td>
						</thead>

					@foreach($bb_to_remove_array_unique as $array)
						<tr>
							<td>
							@foreach($array as $key => $value)
								@if($key == 'bbname')
						    		{{ $value }}
						    	@endif
						    @endforeach
					   		</td>
					   		<td>
							@foreach($array as $key => $value)
								@if($key == 'numofbb')
						    		{{ $value }}
						    	@endif
						    @endforeach
					   		</td>
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

				{!! Form::open(['url' => 'removebb\destroybb']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">


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