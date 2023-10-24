@extends('mainpage')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">2. Operations for BB <i>{{$bbname}}</i></div>
				
				<!-- {!! Form::open(['url' => 'op_by_bb_2']) !!} -->
				{!! Form::open(['url' => 'op_by_bb_confirm']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">

				{!! Form::hidden('ses', $ses, ['class' => 'form-control']) !!}
				{!! Form::hidden('bbcode', $bbcode, ['class' => 'form-control']) !!}
				{!! Form::hidden('bbname', $bbname, ['class' => 'form-control']) !!}

				@if (isset($operationlist[0]))

				<table class="table">
						<thead>
							<tr>
								<!-- <td>BB</td> -->
								<td>
									
									
								(Status) |  Operation</td>
							</tr>
						</thead>
						<tbody>
						@foreach ($operationlist as $d)
						<tr>
							<!-- <td>{{ $d->bbname }}</td> -->
							<td>
								<div class="checkbox">
									<label style="width: 100%;" type="button" class="btn check btn-default"  data-color="primary">
										<input type="checkbox" class="btn check" name="extraops[]" value="{{ $d->operation }}"
										@if($d->status == 'DONE')
								      		checked
								      	@endif
								      	>  
							      		<input name="hidden[]" type='hidden' value="{{ $d->operation }}"> 
							      		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							      		{{ $d->operation }}
							      	</label>
								</div>
							</td>
						</tr>
						@endforeach
						</tbody>
					</table>

				@endif

				<div class="checkbox">
			    	<label style="width: 30%;" type="button" class="btn check btn-warrning"  data-color="info">
			      		<input type="checkbox" class="btn check" id="checkAll"><b>Select all</b>
			    	</label>
			  	</div>
				
				{!! Form::submit('Confirm', ['class' => 'btn btn-warning center-block']) !!}
				
				@if(isset($msg))
				<span style="color:red">{{ $msg }}</span>
				@endif
				@if(isset($msg1))
					<span style="color:green">{{ $msg1 }}</span>
				@endif

				@include('errors.list')
				{!! Form::close() !!}
				
				
				<br>
				<div class="">
						<a href="{{url('/op_by_bb')}}" class="btn btn-default btn-lg center-block">Back</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection