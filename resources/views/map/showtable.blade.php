@extends('mainpage')

@section('first')

<div class="container container-table">
<big><b>All Boxes</b></big>	

<div class="input-group"> <span class="input-group-addon">Filter</span>
	<input id="filter" type="text" class="form-control" placeholder="Type here...">
</div>
<table class="table table-condensed table-bordered" id="sort" >
	<thead>
		<tr>
			<th data-sortable="true" >BB name</th>
			<th>Qty of BB</th>
			<th></th>
		</tr>
		
	</thead>
	<tbody class="searchable">
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