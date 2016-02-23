@extends('mainpage')

@section('create')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">2. Add BB to Stock</div>
				<br>
				{{--<p>BB barcode: {{$BlueBoxCode}}</p>--}}
				<p>BB name: {{$BlueBoxNum}}</p>
				<p>Komesa: {{$POnum}}</p>
				<p>Style: {{$StyCod}}</p>
				<p>Variant: {{$Variant}}</p>
				<p>Qty: {{$BoxQuant}}</p>
					
				{{--
				<p>{{$ClrDesc}}</p>
				<p>{{$ColorCode}}</p>
				<p>{{$Size}}</p>
				--}}
				<hr>
					
				{!! Form::open(['url' => 'bbstock/create']) !!}

				<div class="panel-body">
					<p>Number of BB:</p>
					{!! Form::select('QtyofBB', array('1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5), null, array('class' => 'form-control')); !!} 
				</div>
				<div class="panel-body">
					<p>BB Location: </p>
					{!! Form::text('BBLocation', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>
					{!! Form::hidden('BlueBoxCode', $BlueBoxCode, ['class' => 'form-control']) !!}
					{!! Form::hidden('BlueBoxNum', $BlueBoxNum, ['class' => 'form-control']) !!}
					{!! Form::hidden('BoxQuant', $BoxQuant, ['class' => 'form-control']) !!}
					{!! Form::hidden('BoxDate', $BoxDate, ['class' => 'form-control']) !!}
					{!! Form::hidden('POnum', $POnum, ['class' => 'form-control']) !!}
					{!! Form::hidden('Variant', $Variant, ['class' => 'form-control']) !!}
					{!! Form::hidden('ClrDesc', $ClrDesc, ['class' => 'form-control']) !!}
					{!! Form::hidden('StyCod', $StyCod, ['class' => 'form-control']) !!}
					{!! Form::hidden('ColorCode', $ColorCode, ['class' => 'form-control']) !!}
					{!! Form::hidden('Size', $Size, ['class' => 'form-control']) !!}

				<div class="panel-body">
					{!! Form::submit('Add BB to Stock', ['class' => 'btn btn-success btn-lg center-block']) !!}
				</div>

				@include('errors.list')

				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection