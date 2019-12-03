@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Enter target</div>
				<br>
					{!! Form::open(['method'=>'POST', 'url'=>'/target_enter']) !!}

						{!! Form::hidden('line', $line, ['class' => 'form-control']) !!}
						{!! Form::hidden('komesa', $komesa, ['class' => 'form-control']) !!}
						{!! Form::hidden('style', $style, ['class' => 'form-control']) !!}
						{!! Form::hidden('color', $color, ['class' => 'form-control']) !!}
						{!! Form::hidden('req_type', $req_type, ['class' => 'form-control']) !!}
							
						<div class="panel-body">						
							<p>Po / Komesa: <b>{{ $komesa }}</b></p>
							<p>Style: <b>{{ $style }}</b></p>
							<p>Color: <b>{{ $color }}</b></p>
						</div>

						<div class="panel-body">
						<p>Target Qty: <span style="color:red;">*</span></p>
						
							{!! Form::input('number', 'target', null,['class' => 'form-control']) !!}
						
						</div>
												
						{!! Form::submit('Confirm', ['class' => 'btn  btn-success center-block']) !!}

						@if(isset($msg))
						<div class="alert alert-danger" role="alert">
							  {{ $msg }}
						</div>
						@endif

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