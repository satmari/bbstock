@extends('mainpage')

@section('create')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Edit BB: {{$bb->bbname}}</div>
				<br>
				
				{!! Form::model($bb , ['method' => 'PATCH', 'url' => 'bbstock/'.$bb->id]) !!}

				<div class="panel-body">
					<span>BB Code:</span>
					{!! Form::input('number', 'bbcode', null, ['class' => 'form-control']) !!}
				</div>
				<div class="panel-body">
					<span>BB Name:</span>
					{!! Form::input('string', 'bbname', null, ['class' => 'form-control']) !!}
				</div>
				<div class="panel-body">
					<span>Komesa:</span>
					{!! Form::input('string', 'po', null, ['class' => 'form-control']) !!}
				</div>
				<div class="panel-body">
					<span>Style:</span>
					{!! Form::input('string', 'style', null, ['class' => 'form-control']) !!}
				</div>
				<div class="panel-body">
					<span>Color:</span>
					{!! Form::input('string', 'color', null, ['class' => 'form-control']) !!}
				</div>
				<div class="panel-body">
					<span>Size:</span>
					{{-- {!! Form::select('size', array(''=>'','XS'=>'XS','S'=>'S','M'=>'M','L'=>'L','XL'=>'XL','XXL'=>'XXL','M/L'=>'M/L','S/M'=>'S/M','XS/S'=>'XS/S','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','3-4'=>'3-4','5-6'=>'5-6','7-8'=>'7-8','9-10'=>'9-10','11-12'=>'11-12','LSHO'=>'LSHO','SSHO'=>'SSHO','MSHO'=>'MSHO','XSSHO'=>'XSSHO','XLSHO'=>'XLSHO','TU'=>'TU','1/2'=>'1/2','3/4'=>'3/4'), '', array('class' => 'form-control')); !!} --}}
					{!! Form::input('string', 'size', null, ['class' => 'form-control']) !!}
				</div>
				<div class="panel-body">
					<span>Qty:</span>
					{!! Form::input('number', 'qty', null, ['class' => 'form-control']) !!}
				</div>
				<div class="panel-body">
					<span>Number of BB:</span>
					{{--{!! Form::select('QtyofBB', array('1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'6'=>6), null, array('class' => 'form-control')); !!}  --}}
					{!! Form::input('number', 'numofbb', null, ['class' => 'form-control']) !!}
				</div>
				<div class="panel-body">
					<span>BB Location: </span>
					{!! Form::input('string', 'location', null, ['class' => 'form-control']) !!}
				</div>
				<div class="panel-body">
					{!! Form::submit('Edit BB', ['class' => 'btn btn-warning btn-lg center-block']) !!}
				</div>

				@include('errors.list')

				{!! Form::close() !!}

				<hr>
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