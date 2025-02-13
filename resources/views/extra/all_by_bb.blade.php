@extends('mainpage')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">1. Select or scan BB 
					<p>2. Confirm ALL extra op for all BB from the list</p></div>
				
				{!! Form::open(['url' => 'all_by_bb_post']) !!}

				{!! Form::hidden('ses', $ses, ['class' => 'form-control']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">

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
				<p>Scan BB: <span style="color:red;">*</span></p>
					{!! Form::text('bbcode2', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>
				
				<div class="panel-body">
					{!! Form::submit('Next', ['class' => 'btn btn-success  center-block']) !!}
				</div>
				
				@if(isset($msg))
					<span style="color:red">{{ $msg }}</span>
				@endif
				@if(isset($msg1))
					<span style="color:green">{{ $msg1 }}</span>
				@endif
				@if(isset($msge))
					<span style="color:red">{{ $msge }}</span>
					<audio autoplay="true" style="display:none;">
						<source src="{{ asset('/css/2.wav') }}" type="audio/wav">
					</audio>
				@endif
				@if(isset($msgs))
					<span style="color:green">{{ $msgs }}</span>
					<audio autoplay="true" style="display:none;">
						<source src="{{ asset('/css/1.wav') }}" type="audio/wav">
					</audio>
				@endif
				
				@include('errors.list')
				{!! Form::close() !!}

				<hr>
				@if (isset($bblist[0]))

				<table class="table" >
					<thead>
						<tr>
							<td>BB</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					@foreach ($bblist as $d)
					<tr>
						<td>{{ $d->bbname }}</td>
						<td><a href="{{ url('remove_empextra3s/'.$d->id.'/'.$d->bbcode.'/'.$d->ses) }}" class="btn btn-xs btn-danger">X</a> </td>
					</tr>
					@endforeach
					<tr>
						<td>Total:
						</td>
					   	<td>
						<big><b>{{ count($bblist) }}</b></big>
					   	</td>
					</tr>
					</tbody>
				</table>
				<br>

					@if (isset($ses))
					{!! Form::open(['url' => 'all_by_bb_confirm']) !!}

					{!! Form::hidden('ses', $ses, ['class' => 'form-control']) !!}
					{!! Form::submit('Confirm all', ['class' => 'btn btn-warning center-block']) !!}
					
					@include('errors.list')
					{!! Form::close() !!}
					@endif

				@endif
				
				<br>
				<div class="">
						<a href="{{url('/all_by_bb')}}" class="btn btn-default btn-lg center-block">Back</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection