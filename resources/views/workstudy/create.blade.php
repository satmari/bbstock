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
					
				{!! Form::open(['url' => 'workstudy/create']) !!}

				<div class="panel-body">
					<p>Number of BB: <span style="color:red">*</span></p>
					{!! Form::select('QtyofBB', array('1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5), null, array('class' => 'form-control')); !!} 
				</div>
				<h3>Location</h3>
				<div class="panel-body">
					<p>Module Row: <span style="color:red">*</span></p>
					{!! Form::select('BBLocation_row', array(''=>'','A'=>'A','B'=>'B','C'=>'C','D'=>'D'),null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>
				<div class="panel-body">
					<p>Module name: <span style="color:red">*</span></p>
					{!! Form::select('BBLocation_module', array(''=>'','001'=>'001','002'=>'002','003'=>'003','004'=>'004','005'=>'005','006'=>'006','007'=>'007','008'=>'008','009'=>'009','010'=>'010','011'=>'011','012'=>'012','013'=>'013','014'=>'014','015'=>'015','016'=>'016','017'=>'017','018'=>'018', '01d'=>'01d','02d'=>'02d','03d'=>'03d','04d'=>'04d','05d'=>'05d','06d'=>'06d','07d'=>'07d','08d'=>'08d','09d'=>'09d','10d'=>'10d','11d'=>'11d','12d'=>'12d','13d'=>'13d','14d'=>'14d','15d'=>'15d','16d'=>'16d','17d'=>'17d','18d'=>'18d' ), null , ['class' => 'form-control']) !!} 
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

				<br>
				<div class="">
						<a href="{{url('/')}}" class="btn btn-default btn-lg center-block">Back to main menu</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection