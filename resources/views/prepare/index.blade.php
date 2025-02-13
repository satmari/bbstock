@extends('mainpage')

@section('first')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				{{--<div class="panel-heading">Home</div>--}}
				
				@if(isset($msg))
				{{ $msg }}
				@endif

				@if (Auth::guest())
				
				Please login first.

				@else

					@if (Auth::user()->name == 'cutting' OR Auth::user()->name == 'admin')
					<div class="panel-body">
						<div class="">
							<a href="{{url('/prepare_/PACK')}}" class="btn btn-success btn-lg center-block"><br>Pack BB<br><br></a>
						</div>
					</div>
					<br>
					<div class="panel-body">
						<div class="">
							<a href="{{url('/prepare_/FILL')}}" class="btn btn-primary btn-lg center-block"><br>Fill BB<br><br></a>
						</div>
					</div>
					
					<br>
					<div class="panel-body">
						<div class="">
							<a href="{{url('/prepare_table')}}" class="btn btn-warning btn-lg center-block"><br>Table<br><br></a>
						</div>
					</div>

					
					<div class="panel-body">
						<div class="">
							<p><b></b></p>
						</div>
					</div>
					@endif

				@endif
				
				
			</div>
		</div>
	</div>
</div>
@endsection
