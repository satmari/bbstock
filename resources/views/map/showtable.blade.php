@extends('mainpage')

@section('first')

<div class="container container-table">
<big><b>All Boxes</b></big>	

<div class="input-group"> <span class="input-group-addon">Filter</span>
	<input id="filter" type="text" class="form-control" placeholder="Type here...">
</div>
<table class="table table-striped table-bordered" id="sort"
data-show-export="true"
data-export-types="['excel']"
>
	<thead>
		<tr>
			<th data-sortable="true" >BB name</th>
			<th data-sortable="true" >Style</th>
			<th data-sortable="true" >Color</th>
			<th data-sortable="true" >Size</th>
			<th>Qty of BB</th>
			<th>Location</th>
			<th>Status</th>
			<th>Updated at</th>
			<th></th>
		</tr>
		
	</thead>
	<tbody class="searchable">
		@foreach ($bbstock as $bb)	
		<tr>
			<td>{{ substr($bb->bbname, -9)  }}</td>
			<td>{{ $bb->style }}</td>
			<td>{{ $bb->color }}</td>
			<td>{{ $bb->size }}</td>
			<td>{{ $bb->numofbb }}</td>
			<td>{{ $bb->location }}</td>
			<td>{{ $bb->status }}</td>
			<td>{{ $bb->updated_at }}</td>
			<td><a href="{{url('/bbstock/'.$bb->id.'/delete')}}" class="btn btn-danger btn-xs ">Remove</a></td>
		</tr>
		@endforeach	
	</tbody>
</table>
</div>

@endsection