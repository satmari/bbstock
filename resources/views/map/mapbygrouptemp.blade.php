@extends('mainpage')

@section('first')

<div class="container container-table">
<big><b>{{$id}}</b></big>	

@foreach ($bbstockbygroup as $bb)		
	<table class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th>BB name</th>
				<th>Qty of BB</th>
			</tr>
			
		</thead>
		<tbody>
			<tr>
				<td>{{ substr($bb->bbname, -8)  }}</td>
				<td>{{ $bb->numofbb }}</td>
			</tr>
		</tbody>
	</table>
@endforeach



</div>

@endsection