@extends('mainpage')

@section('content')
<div class="container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Location:</div>
				<br>
					{!! Form::model($location , ['method' => 'POST', 'url' => 'locations/'.$location->id /*, 'class' => 'form-inline'*/]) !!}

					
					<div class="panel-body">
						<span>Location : <span style="color:red;">*</span></span>
						{!! Form::input('string', 'location', null, ['class' => 'form-control']) !!}
					</div>
					<div class="panel-body">
						<span>Location Type: <span style="color:red;">*</span></span>
						{!! Form::select('location_type', array(''=>'','STOCK'=>'STOCK','MODULE/LINE'=>'MODULE/LINE','RECEIVING'=>'RECEIVING'), null, array('class' => 'form-control')); !!} 
					</div>

					<div class="panel-body">
						<span>Location Destination: <span style="color:red;">*</span></span>
						{!! Form::select('location_dest', array(''=>'','SUBOTICA'=>'SUBOTICA','KIKINDA'=>'KIKINDA','LAZAREVAC'=>'LAZAREVAC','SENTA'=>'SENTA','VALJEVO'=>'VALJEVO','KAYRA'=>'KAYRA'), null, array('class' => 'form-control')); !!} 
					</div>
					

					<div class="panel-body">
						{!! Form::submit('Save', ['class' => 'btn btn-success center-block']) !!}
					</div>

					@include('errors.list')

					{!! Form::close() !!}
					<br>
					
					{{-- 
					{!! Form::open(['method'=>'POST', 'url'=>'/locations/delete/'.$location->id]) !!}
					{!! Form::hidden('id', $location->id, ['class' => 'form-control']) !!}
					{!! Form::submit('Delete', ['class' => 'btn  btn-danger btn-xs center-block']) !!}
					{!! Form::close() !!}
					--}}
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/locations')}}" class="btn btn-default">Back</a>
					</div>
				</div>
					
			</div>
		</div>
	</div>
</div>

@endsection