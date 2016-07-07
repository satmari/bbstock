@extends('mainpage')

@section('index')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Search BB</div>
				<br>
				<div class="">
						<a href="{{url('/status/find')}}" class="btn btn-success btn-lg center-block">Search and delete BB by status (on module, using, closed)</a>
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