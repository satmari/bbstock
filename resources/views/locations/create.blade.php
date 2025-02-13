@extends('mainpage')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-4 col-md-offset-4">
            <div class="panel panel-default">
				<div class="panel-heading">Add new Location</div>
				<br>
					{!! Form::open(['method'=>'POST', 'url'=>'/location_insert']) !!}

						<div class="panel-body">
						<p>Location : <span style="color:red;">*</span></p>
							{!! Form::text('location', null, ['class' => 'form-control']) !!}
						</div>
						<div class="panel-body">
						<p>Location type: <span style="color:red;">*</span></p>
							{!! Form::select('location_type', array(''=>'','STOCK'=>'STOCK','MODULE/LINE'=>'MODULE/LINE','RECEIVING'=>'RECEIVING'), null, array('class' => 'form-control')); !!} 
						</div>

						<div class="panel-body">
						<p>Location Destination: <span style="color:red;">*</span></p>
							{!! Form::select('location_dest', array(''=>'','SUBOTICA'=>'SUBOTICA','KIKINDA'=>'KIKINDA','LAZAREVAC'=>'LAZAREVAC','SENTA'=>'SENTA','VALJEVO'=>'VALJEVO','KAYRA'=>'KAYRA'), null, array('class' => 'form-control')); !!} 
						</div>
						
						{!! Form::submit('Add', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
				
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