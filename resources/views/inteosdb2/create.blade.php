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
					
				{{-- {!! Form::open(['url' => 'bbstock/create']) !!} --}}
				{!! Form::open(['url' => 'create_bb2']) !!}

				{!! Form::hidden('BlueBoxCode', $BlueBoxCode) !!}
				{!! Form::hidden('BlueBoxNum', $BlueBoxNum) !!}
				{!! Form::hidden('BoxQuant', $BoxQuant) !!}
				{!! Form::hidden('BoxDate', $BoxDate) !!}
				{!! Form::hidden('POnum', $POnum) !!}
				{!! Form::hidden('SMVloc', $SMVloc) !!}
				{!! Form::hidden('Variant', $Variant) !!}
				{!! Form::hidden('ClrDesc', $ClrDesc) !!}
				{!! Form::hidden('StyCod', $StyCod) !!}
				{!! Form::hidden('ColorCode', $ColorCode) !!}
				{!! Form::hidden('Size', $Size) !!}
				{!! Form::hidden('Bagno', $Bagno) !!}

				<div class="panel-body">
					<p>Number of BB:</p>
					{!! Form::select('QtyofBB', array('1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5, '6'=>6), $QtyofBB, array('class' => 'form-control')); !!} 
				</div>
				
				<div class="panel-body">
					<p>BB Location: </p>
					{!! Form::text('BBLocation', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}

				</div>
					

				<div class="panel-body">
					{!! Form::submit('Add BB to Stock', ['class' => 'btn btn-success btn-lg center-block']) !!}
				</div>

				@if (isset($msg))
					<span style="color:red">{{ $msg }}</span>
				@endif

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