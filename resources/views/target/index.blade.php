@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Enter komesa</div>
				<br>
					{!! Form::open(['method'=>'POST', 'url'=>'/target_confirm']) !!}

						{!! Form::hidden('line', $line, ['class' => 'form-control']) !!}

						{{-- 
						<div class="panel-body">
						<p>PO / Komsesa : <span style="color:red;">*</span></p>
							{!! Form::text('komesa', null, ['id' => 'po','class' => 'form-control']) !!}
						</div>
						--}}

						<div class="panel-body">
						<p>Komesa: <span style="color:red;">*</span></p>
							<select name="komesa" class="chosen"> {{-- form-control --}}
								<option value="" selected></option>
							@foreach ($rel_po as $line)
								<option value="{{ $line->po }}" 
									

									>{{ $line->po }}
								</option>
							@endforeach
							</select>
						</div>

						<div class="panel-body">
						<p>Request type: <span style="color:red;">*</span></p>
						
							{!! Form::select('req_type', ['' => '','Ongoing style' => 'Ongoing style', 'New style' => 'New style'], null,['class' => 'form-control']) !!}
						
						</div>
												
						{!! Form::submit('Confirm', ['class' => 'btn  btn-success center-block']) !!}

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