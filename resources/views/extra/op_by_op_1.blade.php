@extends('mainpage')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">2. Select or scan BB
					<p>3. Confirm operation <i>{{$operation}}</i> for one or multiple BB</p></div>
				
				{!! Form::open(['url' => 'op_by_op_2']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">

				{!! Form::hidden('operation', $operation, ['class' => 'form-control']) !!}

				<div class="panel-body">
                    <p>Choose BB<i></i>: <span style="color:green;"></span></p>
                        <select name="bbcode1" class="chosen">
                            <option value="" selected></option>
                            @foreach ($bbs as $line)
                                <option value="{{ $line->bbcode }}">
                                    {{ $line->bbname }}
                                </option>
                            @endforeach
                        </select>
                </div>
                <div class="panel-body">
					{!! Form::submit('Add BB', ['class' => 'btn btn-success  center-block']) !!}
				</div>
                
                <div class="panel-body">
						<p>Scan BB: <span style="color:red;">*</span></p>
							{!! Form::text('bbcode2', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
						</div>
				
				@if(isset($msg))
					<span style="color:red">{{ $msg }}</span>
				@endif
				@if(isset($msg1))
					<span style="color:green">{{ $msg1 }}</span>
				@endif

				@include('errors.list')
				{!! Form::close() !!}
				
				<hr>
				@if (isset($bblist[0]))

				<table class="table" >
						<thead>
							<tr>
								<td>BB</td>
								<td>Extra op</td>
								<td></td>
							</tr>
						</thead>
						<tbody>
						@foreach ($bblist as $d)
						<tr>
							<td>{{ $d->bbname }}</td>
							<td>{{ $d->operation }}</td>
							<td><a href="{{ url('remove_empextra1s/'.$d->id.'/'.$d->ses.'/'.$d->operation) }}" class="btn btn-xs btn-danger">X</a> </td>
						</tr>

						@endforeach
						</tbody>
					</table>

				@endif

				@if (isset($ses))
				{!! Form::open(['url' => 'op_by_op_confirm']) !!}

				{!! Form::hidden('ses', $ses, ['class' => 'form-control']) !!}
				{!! Form::hidden('operation', $operation, ['class' => 'form-control']) !!}

				{!! Form::submit('Confirm all', ['class' => 'btn btn-warning center-block']) !!}
				
				@include('errors.list')
				{!! Form::close() !!}
				@endif
				
				<br>
				<div class="">
						<a href="{{url('/op_by_op')}}" class="btn btn-default btn-lg center-block">Back</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection