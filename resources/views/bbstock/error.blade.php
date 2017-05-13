@extends('mainpage')

@section('error')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Error!</div>
				<br>
				<h4 style="color:red;">This BB is already in Stock</h4>
				<hr>
				<div class="">
						<a href="{{url('/inteosdb')}}" class="btn btn-success btn-lg ">Add BB</a>
				</div>
				<br>
				<div class="">
						<a href="{{url('/removebb')}}" class="btn btn-danger btn-lg ">Remove BB</a>
				</div>
				<br>
				<div class="">
						<a href="{{url('/')}}" class="btn btn-default btn-lg center-block">Back to main menu</a>
				</div>

				@include('errors.list')

			</div>
		</div>
	</div>
</div>
@endsection