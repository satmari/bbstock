@extends('mainpage')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-4 col-md-offset-4">
            <div class="panel panel-default">
				<div class="panel-heading">Add new OPERATION by SKU</div>
				<br>
					{!! Form::open(['method'=>'POST', 'url'=>'/extra_sku_insert']) !!}
					<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">

						<div class="panel-body">
						<p>STYLE: <span style="color:red;">*</span></p>
							{!! Form::text('style', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
						</div>
						<div class="panel-body">
						<p>COLOR: <span style="color:red;">*</span></p>
							{!! Form::text('color', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
						</div>
						<div class="panel-body">
						<p>SIZE: <span style="color:red;">*</span></p>
							{!! Form::text('size', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
						</div>

						<!-- <div class="panel-body">
						<p>Extra operation: <span sku="color:red;">*</span></p>
							{!! Form::text('extra', null, ['class' => 'form-control']) !!}
						</div> -->

						@if (isset($operation_list))
							<div class="panel-body">
			                    <p>Choose operation<i></i>: <span style="color:red;">*</span></p>
			                        <select name="operation_id" class="chosen">
			                            <option value="" selected></option>
			                            @foreach ($operation_list as $line)
			                                <option value="{{ $line->id }}">
			                                    {{ $line->operation }}
			                                </option>
			                            @endforeach
			                        </select>
			                </div>
						@endif
						<br>

						{!! Form::submit('Save', ['class' => 'btn  btn-danger center-block']) !!}
						@include('errors.list')
					{!! Form::close() !!}
				
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/extra_sku')}}" class="btn btn-default">Back</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection