@extends('mainpage')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Extra opetarion list</div>

                @if (Auth::check() && Auth::user()->level() != 3)
                <div class="panel-body">
                    <div class="">
                        <a href="{{url('/extra_op_new')}}" class="btn btn-success ">Add new</a>
                    </div>
                </div>
                @endif

                <div class="input-group"> <span class="input-group-addon">Filter</span>
                    <input id="filter" type="text" class="form-control" placeholder="Type here...">
                </div>

                <table class="table table-striped table-bordered" id="sort" 
                >
                <!--
                data-show-export="true"
                data-export-types="['excel']"
                data-search="true"
                data-show-refresh="true"
                data-show-toggle="true"
                data-query-params="queryParams" 
                data-pagination="true"
                data-height="300"
                data-show-columns="true" 
                data-export-options='{
                         "fileName": "preparation_app", 
                         "worksheetName": "test1",         
                         "jspdf": {                  
                           "autotable": {
                             "styles": { "rowHeight": 20, "fontSize": 10 },
                             "headerStyles": { "fillColor": 255, "textColor": 0 },
                             "alternateRowStyles": { "fillColor": [60, 69, 79], "textColor": 255 }
                           }
                         }
                       }'
                -->
                    <thead>
                        <tr>
                            <!-- <th>Id</th> -->
                            <th>EXTRA OPERATION</th> 
                            <!-- <th>STATUS</th> -->
                            
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="searchable">
                    @foreach ($data as $req)
                        <tr>
                            {{--<td>{{ $req->id }}</td>--}}
                            <td>{{ $req->operation }}</td>
                            
                            <!-- <td> 
                                @if ($req->active == 1)
                                    ACTIVE
                                @else
                                    <span style="color:red">NOT ACTIVE</span>
                                @endif
                            </td> -->
                            
                            @if (Auth::check() && Auth::user()->level() != 3)
                                @if ($req->active == 1)
                                    <td><a href="{{ url('/extra_op_edit/'.$req->id) }}" class="btn btn-info btn-xs center-block">Edit</a></td>
                                @else
                                    <td><a href="{{ url('/extra_op_edit/'.$req->id) }}" class="btn btn-info btn-xs center-block disabled">Edit</a></td>
                                @endif

                            @endif
                        </tr>
                    @endforeach
                    
                    </tbody>                
            </div>
        </div>
    </div>
</div>
@endsection