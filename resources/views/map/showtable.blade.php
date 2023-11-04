@extends('mainpage')

@section('first')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">

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
			<th>Qty</th>
			<th>Qty of BB</th>
			<th data-sortable="true">Location</th>
			<th data-sortable="true">Status</th>
			<th data-sortable="true">Bagno</th>
			<th data-sortable="true">Palet</th>
			<th data-sortable="true">Updated at</th>
			<th data-sortable="true">BB Destination</th>
			<th>test</th>
			<th>test</th>
			<th></th>
			<th></th>
		</tr>
		
	</thead>
	<tbody class="searchable">
		@foreach ($bbstock as $bb)	
		<tr>
			<td>{{ $bb->bbname  }}</td>
			<td>{{ $bb->style }}</td>
			<td>{{ $bb->color }}</td>
			<td>{{ $bb->size }}</td>
			<td>{{ $bb->qty }}</td>
			<td>{{ $bb->numofbb }}</td>
			<td>{{ $bb->location }}</td>
			<td>{{ $bb->status }}</td>
			<td>{{ $bb->bagno }}</td>
			<td>{{ $bb->pallet }}</td>
			<td>{{ substr($bb->updated_at,0,16)}}</td>
			<td>{{ $bb->destination }}</td>
			<td>
				@if ($bb->bb_ready == 'NOT READY')
					<span style='color:red'>{{ $bb->bb_ready }}</span> 
				@else
					<span style='color:green'>{{ $bb->bb_ready }}</span> 
				@endif
			</td>
			<td><a href="{{ url('/view_op/'.$bb->bbcode) }}" class="btn btn-sucess btn-xs center-block">View OP</a></td>
			<td><a href="{{ url('/bbstock/'.$bb->id.'/delete')}}" class="btn btn-danger btn-xs ">Remove</a></td>
			<td><a href="{{ url('/bbstock/'.$bb->id.'/delete_pallet')}}" class="btn btn-warning btn-xs ">Remove Pallet</a></td>
		</tr>
		@endforeach	
	</tbody>
</table>
</div>
</div>
</div>

@endsection