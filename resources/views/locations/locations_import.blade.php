@extends('mainpage')

@section('first')
<div class="container container-table">
	<div class="row">
		<div class="text-center col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel panel-default">
				<div class="panel-heading">Import locations</div>
				
				{!! Form::open(['files'=>'True', 'method'=>'POST', 'action'=>['locationsController@post_locations'] ]) !!}
					<div class="panel-body">
						{!! Form::file('file', ['class' => 'center-block']) !!}
					</div>
					<div class="panel-body">
						{!! Form::submit('Import list', ['class' => 'btn btn-warning center-block']) !!}
					</div>
					
				{!! Form::close() !!}

				<!-- <hr> -->
			</div>
							

			</div>
		</div>
		
	</div>
</div>

	

@endsection