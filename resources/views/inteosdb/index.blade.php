@extends('mainpage')

@section('index')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">1. Find BB in Inteos database</div>
				
				{!! Form::open(['url' => 'inteosdb']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">

				<div class="panel-body">
					<p>Location of Inteos: </p>
					{!! Form::select('inteosdb_new', array('1'=>'Subotica','2'=>'Kikinda','3'=>'Senta'), $inteosdb, array('class' => 'form-control')); !!} 
				</div>

				<div class="panel-body">
					{!! Form::input('number', 'inteos_bb_code', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>

				<div class="panel-body">
					{!! Form::submit('Find BB', ['class' => 'btn btn-success btn-lg center-block']) !!}
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