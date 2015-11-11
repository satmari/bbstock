@extends('mainpage')

@section('first')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				{{--<div class="panel-heading">Home</div>--}}
				
				<div class="panel-body">
					<div class="">
						<a href="{{url('/inteosdb')}}" class="btn btn-success btn-lg center-block">Add BB to Stock</a>
					</div>
				</div>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/search')}}" class="btn btn-primary btn-lg center-block">Search BB</a>
					</div>
				</div>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/removebb')}}" class="btn btn-danger btn-lg center-block">Remove BB form Stock</a>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
@endsection
