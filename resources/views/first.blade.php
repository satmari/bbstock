@extends('mainpage')

@section('first')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				{{--<div class="panel-heading">Home</div>--}}
				

				@if (Auth::guest())
				<div class="panel-body">
					<div class="">
						<a href="{{url('/inteosdb')}}" class="btn btn-success btn-lg center-block"><br>Add BB to Stock<br><br></a>
					</div>
				</div>
				<br><br><br>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/search2')}}" class="btn btn-primary btn-lg center-block"><br>Search BB<br><br></a>
					</div>
				</div>
				<br><br><br>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/removebb')}}" class="btn btn-danger btn-lg center-block"><br>Remove BB form Stock<br><br></a>
					</div>
				</div>

				<div class="panel-body">
					<div class="">
						<p><b>Paznja: Komese su prebacene sa 5 na 6 poslednjih brojeva i prilikom pretrage morate upisati 6 brojeva!!!</b></p>
					</div>
				</div>

				@else

					@if (Auth::user()->name == 'workstudy')
					<div class="panel-body">
						<div class="">
							<a href="{{url('/workstudy')}}" class="btn btn-success btn-lg center-block"><br><span style="color:black">Add SUSPENDED BB in production</span><br><br></a>
						</div>
					</div>
					<br><br><br>
					<div class="panel-body">
						<div class="">
							<a href="{{url('/search')}}" class="btn btn-primary btn-lg center-block"><br>Search BB<br><br></a>
						</div>
					</div>
					<br><br><br>
					<div class="panel-body">
						<div class="">
							<a href="{{url('/removebb')}}" class="btn btn-danger btn-lg center-block"><br>Remove BB form Stock<br><br></a>
						</div>
					</div>
					@endif

				@endif
				
				
			</div>
		</div>
	</div>
</div>
@endsection
