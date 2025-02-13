@extends('mainpage')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-6 col-md-offset-3">
            <div class="panel panel-default">
				<div class="panel-heading">Add new operation</div>
				<br>
					{!! Form::open(['method'=>'POST', 'url'=>'/extra_op_insert']) !!}

						<div class="panel-body">
						<p>Extra operation: <span style="color:red;">*</span></p>
							{!! Form::text('operation', null, ['class' => 'form-control']) !!}
						</div>
						
						{!! Form::submit('Save', ['class' => 'btn  btn-success center-block']) !!}

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