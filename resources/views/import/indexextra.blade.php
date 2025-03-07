@extends('mainpage')

@section('content')

<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">

			<div class="panel panel-default">
				<div class="panel-heading">Import Extra operation by Style
					<i><p>Coloums: Style, Operation</p></i>
				</div>
				
				{!! Form::open(['files'=>True, 'method'=>'POST', 'action'=>['importExtraController@postImportExtraStyle']]) !!}
					<div class="panel-body">
						{!! Form::file('file1', ['class' => 'center-block']) !!}
					</div>
					<div class="panel-body">
						{!! Form::submit('Import', ['class' => 'btn btn-warning center-block']) !!}
					</div>
					@include('errors.list')
				{!! Form::close() !!}

				<!-- <hr> -->
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Import Extra operation by Style and Size
					<i><p>Coloums: Style, Size, Operation</p></i>
				</div>
				
				{!! Form::open(['files'=>True, 'method'=>'POST', 'action'=>['importExtraController@postImportExtraStyleSize']]) !!}
					<div class="panel-body">
						{!! Form::file('file2', ['class' => 'center-block']) !!}
					</div>
					<div class="panel-body">
						{!! Form::submit('Import', ['class' => 'btn btn-warning center-block']) !!}
					</div>
					@include('errors.list')
				{!! Form::close() !!}

				<!-- <hr> -->
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Import Extra operation by SKU
					<i><p>Coloums: Style, Color, Size, Operation</p></i>
				</div>
				
				{!! Form::open(['files'=>True, 'method'=>'POST', 'action'=>['importExtraController@postImportExtraSKU']]) !!}
					<div class="panel-body">
						{!! Form::file('file3', ['class' => 'center-block']) !!}
					</div>
					<div class="panel-body">
						{!! Form::submit('Import', ['class' => 'btn btn-warning center-block']) !!}
					</div>
					@include('errors.list')
				{!! Form::close() !!}

				<!-- <hr> -->
			</div>


			
		

			<div class="panel panel-default">
				<div class="panel-body">
					<div class="">
						<a href="{{url('/')}}" class="btn btn-default btn-lg center-block">Back to main menu</a>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

@endsection