@extends('mainpage')

@section('first')

<div class="container container-table">
	<big><b>{{$id}}</b></big>

	<table class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th>
					
				</th>
				<th>
					F
				</th>
				<th>
					E
				</th>
				<th>
					D
				</th>
				<th>
					C
				</th>
				<th>
					B
				</th>
				<th>
					A
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<b>6</b>
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-F-6")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-E-6")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-D-6")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-C-6")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-B-6")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-A-6")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
			</tr>
			<tr>
				<td>
					<b>5</b>
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-F-5")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-E-5")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-D-5")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-C-5")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-B-5")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-A-5")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
			</tr>
			<tr>
				<td>
					<b>4</b>
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-F-4")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-E-4")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-D-4")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-C-4")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-B-4")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-A-4")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
			</tr>
			<tr>
				<td>
					<b>3</b>
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-F-3")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-E-3")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-D-3")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-C-3")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-B-3")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-A-3")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
			</tr>
			<tr>
				<td>
					<b>2</b>
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-F-2")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-E-2")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-D-2")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-C-2")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-B-2")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-A-2")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
			</tr>
			<tr>
				<td>
					<b>1</b>
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-F-1")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-E-1")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-D-1")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-C-1")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-B-1")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
				<td>
					@foreach ($bbstockbygroup as $bb)
						@if ($bb->location == "$id-A-1")
							
						{{ substr($bb->bbname, -8) }} --> <b>{{$bb->numofbb}}</b><br>

						@endif
					@endforeach
				</td>
			</tr>
		</tbody>
	</table>




</div>

@endsection