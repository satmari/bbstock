@extends('mainpage')

@section('index')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
			<div class="panel panel-default">
				<div class="panel-heading">Search for {{ $po }}</div>

				<br>
				<div>
					@if (isset($data[0]->id))
						PO: <b>{{ substr($data[0]->bbname,3,9) }}</b>
						<br>
						SKU: <b>{{ $data[0]->sku }}</b>
						<br>
					@endif
				</div>
				<br>
				<!-- <div class="input-group"> <span class="input-group-addon">Filter</span> -->
					<!-- <input id="filter" type="text" class="form-control" placeholder="Type here..."> -->
				<!-- </div> -->
				<table class="table table-striped table-bordered" id="sort">
					<thead>
						<tr>
							<th data-sortable="true" >BB</th>
							<!-- <th data-sortable="true" >SKU</th> -->
							<th data-sortable="true" >Loc</th>
							<th data-sortable="true" >Status</th>
							<th data-sortable="true" >Qty</th>
							<!-- <th data-sortable="true" >Updated at</th> -->
							<th data-sortable="true" >READY</th>
							<!-- <th></th> -->
						</tr>
					</thead>
					<tbody class="searchable">
						@foreach ($data as $line)	
						<tr>
							<td><span style="font-weight: bold;"><big>{{substr($line->bbname,12,3) }}</big></span></td>
							{{-- <td>{{ $line->sku  }}</td> --}}
							<td>{{ $line->location }}</td>
							<td>{{ $line->status }}</td>
							<td>{{ (int)$line->qty }}</td>
							{{-- <td>{{ substr($line->updated_at,0,16) }}</td> --}}
							<td>@if ($line->bb_ready == 'NOT READY')
									<span style='color:red'>
										<a href="{{ url('/view_op/'.$line->bbcode) }}" class="">
										{{ $line->bb_ready }}
										</a>
									</span> 
								@else
									<span style='color:green'>
										<a href="{{ url('/view_op/'.$line->bbcode) }}" class="">
											{{ $line->bb_ready }}
										</a>
									</span> 
								@endif
							</td>
							{{-- <td><a href="{{ url('/view_op/'.$line->bbcode) }}" class="btn btn-sucess btn-xs center-block">View OP</a></td> --}}
						</tr>
						@endforeach	
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection