@extends('mainpage')

@section('index')
<div class="container container-table">
	<!-- <div class="row vertical-center-row"> -->
		<div class="row">

			<div class="col-xs-4 col-md-offset-1">
			  	<div class="panel panel-default">

				  <table class="table">
				    <thead>
				      <tr>
				        <th>Sort by location (SUSPENDED first)</th>
				        
				      </tr>
				    </thead>
				    <tbody>
				      <tr>
				        <td>
				        	@foreach ($search as $rez)
								<table style="width:100%" class="table table-striped">
								  <tr>
								    <td>BB:</td>
								    <td>{{$rez->po}} <b>{{substr($rez->bbname, -3)}}</b></td>		
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
								    <td>Box created:</td>
								    <td>{{substr($rez->boxdate, 0, 19)}}</td>		
								  </tr>
								  <tr>
								    <td>Num of Box:</td>
								    <td>{{$rez->numofbb}}</td>		
								  </tr>
								  <tr style="border-bottom:1px solid #000">
								    <td>Location:</td>
								    {{--<td><h4><span style="color:blue"><b>{{$rez->location}}</b></span></h4></td>--}}
								    <td><span style="color:blue"><b>{{$rez->location}}</b></span></td>
								  </tr>
								</table>
							@endforeach
				        </td>
				      </tr>
				    </tbody>
				  </table>
				  </div>
			</div>

			<div class="col-xs-2">

			</div>

			<div class="col-xs-4">
			  	<div class="panel panel-default">
					


				  <table class="table">
				    <thead>
				      <tr>
				        
				        <th>Sort by box created date (Older first)</th>
				      </tr>
				    </thead>
				    <tbody>
				      <tr>
				        <td>
				        	@foreach ($search_by_date as $rez2)
								<table style="width:100%" class="table table-striped">
								  <tr>
								    <td>BB:</td>
								    <td>{{$rez2->po}} <b>{{substr($rez2->bbname, -3)}}</b></td>		
								  </tr>
								  <tr>
								    <td>SKU:</td>
								    <td>{{$rez2->style}} / {{$rez2->color}}-<span style="color:red;"><b>{{$rez2->size}}</b></span></td>		
								  </tr>
								  <tr>
								    <td>PCS:</td>
								    <td>{{$rez2->qty}}</td>		
								  </tr>
								  <tr>
								    <td>Box created:</td>
								    <td>{{substr($rez2->boxdate, 0, 19)}}</td>
								  </tr>
								  <tr>
								    <td>Num of Box:</td>
								    <td>{{$rez2->numofbb}}</td>		
								  </tr>
								  <tr style="border-bottom:1px solid #000">
								    <td>Location:</td>
								    {{--<td><h4><span style="color:blue"><b>{{$rez2->location}}</b></span></h4></td>--}}
								    <td><span style="color:blue"><b>{{$rez2->location}}</b></span></td>
								  </tr>
								</table>
							@endforeach
				        </td>
				      </tr>
				    </tbody>
				  </table>
				

				 </div>
			</div>

			<div class="col-xs-6 col-md-offset-3">
				<br>
				<div class="">
						<a href="{{url('/search2')}}" class="btn btn-default btn-lg center-block">Search again</a>
				</div>
				<br>
				<div class="">
						<a href="{{url('/removebb')}}" class="btn btn-default btn-lg center-block">Remove BB form Stock</a>
				</div>
				<br>
				<div class="">
						<a href="{{url('/')}}" class="btn btn-default btn-lg center-block">Back to main menu</a>
				</div>
			</div>
		</div>

	<!-- </div> -->
</div>
@endsection