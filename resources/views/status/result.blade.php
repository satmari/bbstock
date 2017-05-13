@extends('mainpage')

@section('index')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">BB status</div>
				<br><br>
				<div>
					Deleted:<p style="font-size: 30px;"> {{ $boxdeleted }}	</p>
					<hr>
					Not deleted<p style="font-size: 20px;"> {{ $boxleft }}	</p>
				</div>
				<br>
				<hr>

				<div class="">
						<a href="{{url('/')}}" class="btn btn-default btn-lg center-block">Back to main menu</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection