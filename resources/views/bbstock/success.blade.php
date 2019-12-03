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
				<p>BB name: {{$BlueBoxNum}}</p>
				<p>Komesa: {{$po}}</p>
				<p>Style: {{$StyCod}}</p>
				<p>Variant: {{$ColorCode}}-{{$Size}}</p>
				<p>Qty: {{$BoxQuant}}</p>
				<p>Number of boxes: {{$QtyofBB}}</p>
				<p>Location: {{$location}}</p>
				
				<br>
				<div class="">
						<a href="{{url('/inteosdb')}}" class="btn btn-success btn-lg">Add new BB</a>
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