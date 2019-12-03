@extends('mainpage')

@section('index')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Search BB</div>
				
				{!! Form::open(['url' => 'search']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
				{{--
				<p>BB code: </p>
				<div class="panel-body">
					{!! Form::input('number', 'bb_code', null, ['class' => 'form-control']) !!}
				</div>
				--}}
				<p>Po: </p>
				<div class="panel-body">
					{!! Form::input('number', 'po', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>
				<p>Size: </p>
				<div class="panel-body">
					{{--{!! Form::input('string', 'size', null, ['class' => 'form-control']) !!}--}}
					{!! Form::select('size', array(''=>'any','XS'=>'XS','S'=>'S','M'=>'M','L'=>'L','XL'=>'XL','XXL'=>'XXL','M/L'=>'M/L','S/M'=>'S/M','XS/S'=>'XS/S','2'=>'2','3-4'=>'3-4','5-6'=>'5-6','7-8'=>'7-8','9-10'=>'9-10','11-12'=>'11-12','SSHO'=>'SSHO','MSHO'=>'MSHO','XSSHO'=>'XSSHO'), '', array('class' => 'form-control')); !!} 
				</div>

				<div class="panel-body">
					{!! Form::submit('Search BB', ['class' => 'btn btn-primary btn-lg center-block']) !!}
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