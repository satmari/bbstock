@extends('mainpage')

@section('index')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Search BB</div>
				<br>
				<div>
					<p>Enter password:</p>

				{!! Form::open(['url' => 'find_by_status']) !!}
                <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">

                <div class="panel-body">
                    {!! Form::input('string', 'password', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
                </div>

                <div class="panel-body">
                    {!! Form::submit('Search and delete BB by status (on module, using, closed)', ['class' => 'btn btn-success btn-lg center-block']) !!}
                </div>

                @include('errors.list')

                {!! Form::close() !!}

				</div>
				<!-- <div class="">
						<a href="{{url('/status/find')}}" class="btn btn-success btn-lg center-block">Search and delete BB by status (on module, using, closed)</a>
				</div> -->
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