@extends('mainpage')

@section('index')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Success</div>
				<br>
				<h4 style="color:green;">BB succesfuly removed form Stock</h4>
				<hr>
				<div class="">
						<a href="{{url('/')}}" class="btn btn-default btn-lg center-block">Back to main menu</a>
				</div>

				@include('errors.list')
			</div>
		</div>
	</div>
</div>
@endsection