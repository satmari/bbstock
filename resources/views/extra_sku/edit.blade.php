@extends('mainpage')

@section('content')
<div class="container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Extra operation by SKU:
				{!! Form::open(['method'=>'POST', 'url'=>'/extra_sku_delete/'.$data->id]) !!}
					{!! Form::hidden('id', $data->id, ['class' => 'form-control']) !!}
					{!! Form::submit('Set as NOT ACTIVE', ['class' => 'btn  btn-danger btn-xs center-block']) !!}
					{!! Form::close() !!}
				</div>
				<br>
					{!! Form::model($data , ['method' => 'POST', 'url' => 'extra_sku_update' ]) !!}

					<div class="panel-body">
						
					
						{!! Form::hidden('id', $data->id, ['class' => 'form-control']) !!}
						
						<!-- <div class="panel-body">
						<p>SKU:  <span sku="color:red;">*</span></p>
							{!! Form::input('string', 'sku', $data->sku, ['class' => 'form-control']) !!}
						</div> -->

						<div class="panel-body">
						<p>STYLE:  <span style="color:red;">*</span></p>
							{!! Form::input('string', 'style', $data->style, ['class' => 'form-control']) !!}
						</div>

						<div class="panel-body">
						<p>COLOR:  <span style="color:red;">*</span></p>
							{!! Form::input('string', 'color', $data->color, ['class' => 'form-control']) !!}
						</div>

						<div class="panel-body">
						<p>SIZE:  <span style="color:red;">*</span></p>
							{!! Form::input('string', 'size', $data->size, ['class' => 'form-control']) !!}
						</div>
						
						@if (isset($operation_list))
							<div class="panel-body">
			                    <p>Choose operation<i></i>: <span style="color:red;">*</span></p>
			                        <select name="operation_id" class="chosen">
			                            <option value="" selected></option>

			                            @foreach ($operation_list as $line)
			                                <option value="{{ $line->id }}"
			                                	@if ($line->id == $data->operation_id)
			                                	selected
			                                	@endif
			                                	>
			                                    {{ $line->operation }}
			                                </option>
			                            @endforeach
			                        </select>
			                </div>
						@endif
						<br>

						<div class="panel-body">
							{!! Form::submit('Save', ['class' => 'btn btn-success center-block']) !!}
						</div>

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