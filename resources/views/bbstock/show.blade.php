@extends('mainpage')

@section('create')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">BB: {{$bb->bbname}}</div>
				<br>
				<p>BB name: {{$bb->bbname}}</p>
				<p>BB code: {{$bb->bbcode}}</p>
				<p>Komesa: {{$bb->po}}</p>
				<p>Style: {{$bb->style}}</p>
				<p>Variant: {{$bb->color}}-{{$bb->size}}</p>
				<p>Qty: {{$bb->qty}}</p>
				<p>Number of boxes: {{$bb->numofbb}}</p>
				<p>Location: {{$bb->location}}</p>
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/bbstock/'.$bb->id.'/edit')}}" class="btn btn-warning btn-lg center-block">Edit this BB</a>
					</div>
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