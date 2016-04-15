@extends('mainpage')

@section('first')

<div class="container container-table">
<big><b>All Boxes</b></big>	

<table class="table table-bordered table-condensed">
	<thead>
		<tr>
			<th>BB name</th>
			<th>Qty of BB</th>
			<th></th>
		</tr>
		
	</thead>
	<tbody>
		@foreach ($bbstock as $bb)	
		<tr>
			<td>{{ substr($bb->bbname, -8)  }}</td>
			<td>{{ $bb->numofbb }}</td>
			<td><a href="{{url('/bbstock/'.$bb->id.'/delete')}}" class="btn btn-danger btn-xs ">Remove</a></td>
		</tr>
		@endforeach	
	</tbody>
</table>
</div>

@endsection