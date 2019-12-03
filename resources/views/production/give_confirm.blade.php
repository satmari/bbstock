@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Confirmation</div>
				<br>
					{!! Form::open(['method'=>'POST', 'url'=>'/give_confirm']) !!}

						{!! Form::hidden('id', $id, ['class' => 'form-control']) !!}

						<div class="panel-body">
						<p>Give to : <span style="color:red;">*</span></p>
						
							{!! Form::select('location_new', ['' => ''] + $locations, null,['class' => 'form-control']) !!}
						
						</div>
												
						{!! Form::submit('Confirm', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/')}}" class="btn btn-default center-block">Back</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection