@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">3. Choose operation <span class="label label-info text-huge">Function: <big>{{ $function }} </big></span></div>
				
				@if(isset($warning))

					<div class="alert alert-danger alert-dismissable fade in">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					    <strong>{{$warning}}</strong>
				    </div>

				@endif

				{!! Form::open(['method'=>'POST', 'url'=>'prepare_scan_fill_confirm']) !!}
				<meta name="csrf-token" content="{{ csrf_token() }}" />

				{!! Form::hidden('bbcode', $bbcode, ['class' => 'form-control']) !!}
				{!! Form::hidden('bbname', $bbname, ['class' => 'form-control']) !!}
				{!! Form::hidden('inteosdb', $inteosdb, ['class' => 'form-control']) !!}
				{!! Form::hidden('rnumber', $rnumber, ['class' => 'form-control']) !!}
				{!! Form::hidden('username', $username, ['class' => 'form-control']) !!}
				{!! Form::hidden('function', $function, ['class' => 'form-control']) !!}

				{!! Form::hidden('po', $po, ['class' => 'form-control']) !!}
				{!! Form::hidden('style', $style, ['class' => 'form-control']) !!}
				{!! Form::hidden('color', $color, ['class' => 'form-control']) !!}
				{!! Form::hidden('size', $size, ['class' => 'form-control']) !!}
				{!! Form::hidden('qty', $qty, ['class' => 'form-control']) !!}
				{!! Form::hidden('bagno', $bagno, ['class' => 'form-control']) !!}

				{!! Form::hidden('Variant', $Variant, ['class' => 'form-control']) !!}



				<div class="panel-body">

				<table style="width:100%">
				<th style="width:100%"></th>
				
				@foreach ($newarray as $line)
						
  						<tr>
  							<td style="width:90%">
  								<div class="checkbox">
							    	<label style="width: 90%;" type="button" class="btn check btn-default"  data-color="primary">
							      		<input type="checkbox" class="btn check" name="operation_code[]" value="{{ $line['operation_code'].'#'.$line['operation'] }}">  
							      		<input name="hidden[]" type='hidden' value="{{ $line['operation_code'].'#'.$line['operation'] }}"> 

							      		{{ $line['operation'] }}

										
							    	</label>
							  	</div>
  						 	</td>
  							
  						</tr>
  				@endforeach
  				
				</table>
			    
			  	<hr>
			  	<div class="checkbox">
			    	<label style="width: 30%;" type="button" class="btn check btn-warrning"  data-color="info">
			      		<input type="checkbox" class="btn check" id="checkAll"><b>Izaberi sve</b>
			    	</label>
			  	</div>
					
			  	<hr>
			    <div class="panel-body">
					{!! Form::submit('Confirm', ['class' => 'btn btn-success center-block']) !!}
				</div>

				@include('errors.list')
				{!! Form::close() !!}

				{{--
				<hr>
				<div class="panel-body">
					<a href="{{url('/')}}" class="btn btn-default center-block">Back</a>
				</div>
				--}}
				
			</div>
		</div>
	</div>
</div>
@endsection