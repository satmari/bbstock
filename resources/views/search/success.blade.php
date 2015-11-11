@extends('mainpage')

@section('index')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Search results</div>
				<br>
				{{--<h4 style="color:green;">BB succesfuly find in Stock</h4>--}}
				<hr>
				@foreach ($search as $rez)
					{{--<p>{{$rez->bbname}}</p>--}}
					{{--
					<h4><b>{{$rez->po}}</b></h4>
					<p>{{$rez->style}} / {{$rez->color}}-<span style="color:red;">{{$rez->size}}</span> / {{$rez->qty}} / {{$rez->numofbb}}</p>
					<h4><span style="color:blue"><b>{{$rez->location}}</b></span></h4>
					--}}
					<table style="width:100%" class="table table-striped">
					  <tr>
					    <td>BB:</td>
					    <td><b>{{$rez->po}}</b></td>		
					  </tr>
					  <tr>
					    <td>SKU:</td>
					    <td>{{$rez->style}} / {{$rez->color}}-<span style="color:red;"><b>{{$rez->size}}</b></span></td>		
					  </tr>
					  <tr>
					    <td>PCS:</td>
					    <td>{{$rez->qty}}</td>		
					  </tr>
					  <tr>
					    <td>Num of Box:</td>
					    <td>{{$rez->numofbb}}</td>		
					  </tr>
					  <tr>
					    <td>Location:</td>
					    {{--<td><h4><span style="color:blue"><b>{{$rez->location}}</b></span></h4></td>--}}
					    <td><span style="color:blue"><b>{{$rez->location}}</b></span></td>
					  </tr>

					</table>
					<hr>
				@endforeach

				<hr>
				<div class="">
						<a href="{{url('/search')}}" class="btn btn-default btn-lg center-block">Search again</a>
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