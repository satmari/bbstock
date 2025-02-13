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

					@if (Auth::user()->name == 'magacin' OR Auth::user()->name == 'admin')
					<div class="panel-body">
						<div class="">
							<a href="{{url('/inteosdb')}}" class="btn btn-success btn-lg center-block"><br>Add BB to Stock<br><br></a>
						</div>
					</div>
					<!-- <br> -->
					<!-- <div class="panel-body">
						<div class="">
							<a href="{{url('/addmorebb')}}" class="btn btn-success btn-lg center-block"><br>Add multiple BB to Stock (Fiorano)<br><br></a>
						</div>
					</div>
					<br> -->
					<div class="panel-body">
						<div class="">
							<a href="{{url('/search2')}}" class="btn btn-primary btn-lg center-block"><br>Search BB<br><br></a>
						</div>
					</div>
					<!-- <br> -->
					<div class="panel-body">
						<div class="">
							<a href="{{url('/transitbb')}}" class="btn btn-warning btn-lg center-block"><br>Move BB to line<br><br></a>
						</div>
					</div>
					<!-- <br> -->
					<div class="panel-body">
						<div class="">
							<a href="{{url('/removebb')}}" class="btn btn-danger btn-lg center-block"><br>Remove BB from Stock<br><br></a>
						</div>
					</div>
					<!-- <br> -->
					{{-- 
					<div class="panel-body">
						<div class="">
							<a href="{{url('/loadbb')}}" class="btn btn-info btn-lg center-block"><br><span style="color:">Load truck</span><br><br></a>
						</div>
					</div>

					<br>
					<div class="panel-body">
						<div class="">
							<a href="{{url('/unloadbb')}}" class="btn btn-info btn-lg center-block"><br><span style="color:">Unload truck</span><br><br></a>
						</div>
					</div>
					--}}
					<div class="panel-body">
						<div class="">
							<a href="{{url('/loadbbt')}}" class="btn btn-info btn-lg center-block"><br><span style="color:">Load truck (NEW)</span><br><br></a>
						</div>
					</div>
					<!-- <br> -->
					<div class="panel-body">
						<div class="">
							<a href="{{url('/unloadbbt')}}" class="btn btn-info btn-lg center-block"><br><span style="color:">Unload truck (NEW)</span><br><br></a>
						</div>
					</div>
					<!-- <br> -->
					<div class="panel-body">
						<div class="">
							<a href="{{url('/select_pallet')}}" class="btn btn-info btn-lg center-block"><br><span style="color:">Transfer pallet (NEW)</span><br><br></a>
						</div>
					</div>
					<!-- 
					<div class="panel-body">
						<div class="">
							<p><b></b></p>
						</div>
					</div> -->
					@endif

				@endif
				
				
			</div>
		</div>
	</div>
</div>
@endsection
