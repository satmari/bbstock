@extends('mainpage')

@section('first')

<div class="container container-table">
<big><b>Search for {{ $po }}</b></big>	

<div class="input-group"> <span class="input-group-addon">Filter</span>
	<input id="filter" type="text" class="form-control" placeholder="Type here...">
</div>
<table class="table table-striped table-bordered" id="sort"
data-show-export="true"
data-export-types="['excel']"
>
	<thead>
		<tr>
			<th data-sortable="true" >PO</th>
			<th data-sortable="true" >BB name</th>
			<th data-sortable="true" >Variant</th>
			<th data-sortable="true" >Style</th>
			<th data-sortable="true" >BB Qty</th>
			<th data-sortable="true" >BB Ready</th>
			<th data-sortable="true" >Marker</th>
			<th data-sortable="true" >Line</th>
			<th data-sortable="true" >Inteos Status</th>
			<th data-sortable="true" >BBStock Status</th>
			<th data-sortable="true" >BBStock Location</th>
			

		</tr>
		
	</thead>
	<tbody class="searchable">
		@foreach ($data as $line)	
		<tr>
			<td>{{ $line->POnum  }}</td>
			<td>{{ substr($line->BlueBoxNum, -3)  }}</td>
			<td>{{ $line->Variant }}</td>
			<td>{{ $line->StyCod }}</td>
			<td>{{ $line->BoxQuant }}</td>
			<td>
				@if (($line->SkuExtraOperations - $line->BBExtraOperations) == 0)
    				YES
				@else
    				NO
				@endif
			</td>
			<td>{{ $line->IDMarker }}</td>
			<td>{{ $line->ModNam }}</td>
			<td>{{ $line->Status }}</td>
			<td>{{ $line->BBStock_status }}</td>
			<td>{{ $line->BBStock_location }}</td>
			
			
		</tr>
		@endforeach	
	</tbody>
</table>
</div>

@endsection