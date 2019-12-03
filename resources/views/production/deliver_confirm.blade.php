@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Confirmation</div>
				<br>

				<span>Do you want to deliver <b>{{ $count }} </b> box/boxes to <b>{{ $username }} </b> ?</span>

				<br>
				<br>

				<div class="">
						<a href="{{url('/deliver_confirm/'.$username)}}" class="btn btn-success center-block ">Yes</a>
				</div>
				<br>
				<div class="">
						<a href="{{url('/production')}}" class="btn btn-danger center-block">No</a>
				</div>
							
				<br>
				<hr>

				<div class="panel-body">
					<div class="">
						<a href="{{url('/')}}" class="btn btn-default center-block">Back</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection