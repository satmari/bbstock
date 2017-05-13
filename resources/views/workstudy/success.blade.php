@extends('mainpage')

@section('create')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Success</div>
				<br>
				<h4 style="color:green;">BB successfuly added on Stock</h4>
				<hr>
				<p>BB name: {{$bbname}}</p>
				<p>Komesa: {{$po}}</p>
				<p>Style: {{$style}}</p>
				<p>Variant: {{$color}}-{{$size}}</p>
				<p>Qty: {{$qty}}</p>
				<p>Number of boxes: {{$numofbb}}</p>
				<p>Location: {{$location}}</p>
				
				<br>
				<div class="">
						<a href="{{url('/workstudy')}}" class="btn btn-success btn-lg">Add new BB</a>
				</div>
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/')}}" class="btn btn-default btn-lg center-block">Back to main menu</a>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
@endsection