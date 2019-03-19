@extends('mainpage')

@section('index')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Choose BB to remove, because two boxes have same id (from two Inteos)!</div>
				<br>
				@if (isset($msg))
				<h4 style="color:red;">{{ $msg }}</h4>
				@endif

				Choose?
				<br>
				<br>
				<div class="">
						<a href="{{url('/removebb_choose/'.$bbid0)}}" class="btn btn-danger btn-lg">{{ $bbname0 }}</a>
				</div>
				<br>
				<br>

				<div class="">
						<a href="{{url('/removebb_choose/'.$bbid1)}}" class="btn btn-danger btn-lg">{{ $bbname1 }}</a>
				</div>
				<br>
				{{--

				<hr>
				<div class="">
						<a href="{{url('/')}}" class="btn btn-default btn-lg center-block">Back to main menu</a>
				</div>

				--}}

				@include('errors.list')

			</div>
		</div>
	</div>
</div>
@endsection