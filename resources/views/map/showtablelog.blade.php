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
			<th>Po</th>
			<th>Style</th>
			<th>Color</th>
			<th>Size</th>
			<th>Qty</th>
			<th>Location</th>

			<th>Box created</th>
			<th>Box removed from BBstock</th>
		</tr>
		
	</thead>
	<tbody class="searchable">
		@foreach ($bbstock as $bb)	
		<tr>
			<td>{{ substr($bb->bbname, -9)  }}</td>
			<td>{{ $bb->numofbb }}</td>
			<td>{{ $bb->po }}</td>
			<td>{{ $bb->style }}</td>
			<td>{{ $bb->color }}</td>
			<td>{{ $bb->size }}</td>
			<td>{{ $bb->qty }}</td>
			<td>{{ $bb->location }}</td>

			<td>{{ $bb->boxdate }}</td>
			<td>{{ $bb->created_at }}</td>
			
		</tr>
		@endforeach	
	</tbody>
</table>
</div>

@endsection