@extends('mainpage')

@section('first')

<div class="container container-table">
<big><b>{{$id}}</b></big>	

<table class="table table-bordered table-condensed">
	<thead>
		<tr>
			<th>BB name</th>
			<th>Qty of BB</th>
			<!-- <th></th> -->
		</tr>
		
	</thead>
	<tbody>
		@foreach ($bbstockbygroup as $bb)	
		<tr>
			<td>{{ $bb->bbname  }}</td>
			<td>{{ $bb->numofbb }}</td>
			<!-- <td><a href="{{url('/bbstock/'.$bb->id.'/delete')}}" class="btn btn-default btn-lg center-block">Remove</a></td> -->
		</tr>
		@endforeach	
	</tbody>
</table>
</div>

@endsection