@extends('mainpage')

@section('content')
<div class="container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">Edit operation:
				<!-- {!! Form::open(['method'=>'POST', 'url'=>'/extra_op_delete/'.$data->id]) !!}
				{!! Form::hidden('id', $data->id, ['class' => 'form-control' ]) !!}
				{!! Form::submit('Set as NOT ACTIVE', ['class' => 'btn  btn-danger btn-xs center-block' ,'disabled' => 'disabled']) !!}
				{!! Form::close() !!} -->
				</div>
				<br>
					{!! Form::model($data , ['method' => 'POST', 'url' => 'extra_op_update' ]) !!}

					<div class="panel-body">
						
					
						{!! Form::hidden('id', $data->id, ['class' => 'form-control']) !!}
						
						<div class="panel-body">
						<p>Operation: <span style="color:red;">*</span></p>
							{!! Form::input('string', 'operation', $data->operation, ['class' => 'form-control']) !!}
						</div>

						<div class="panel-body">
							{!! Form::submit('Save', ['class' => 'btn btn-success center-block']) !!}
						</div>

					@include('errors.list')

					{!! Form::close() !!}
					
					
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/extra_op')}}" class="btn btn-default">Back</a>
					</div>
				</div>
					
			</div>
		</div>
	</div>
</div>

@endsection