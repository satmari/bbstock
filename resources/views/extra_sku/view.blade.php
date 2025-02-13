@extends('mainpage')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
                <div class="panel-heading">Opetarions </div>

               <a href="{{url('/extra_sku')}}" class="btn btn-default btn-info">Back</a>
               

                <div class="input-group"> <span class="input-group-addon">Filter</span>
                    <input id="filter" type="text" class="form-control" placeholder="Type here...">
                </div>

                <table class="table table-striped table-bordered" id="sort" 
                data-show-export="true"
                data-export-types="['excel']"
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
                            <th>BB</th>
                            <th>key</th>
                            <th>OPERATION ID</th>
                            <th>OPERATION</th>
                            <th>STATUS</th>
                            <th>ACTIVE</th>
                            <th></th>
                            
                        </tr>
                    </thead>
                    <tbody class="searchable">
                    @foreach ($data as $req)
                        <tr>
                            {{--<td>{{ $req->id }}</td>--}}
                            <td>{{ $req->bbname }}</td>
                            <td>{{ $req->key }}</td>
                            <td>{{ $req->operation_id }}</td>
                            <td>{{ $req->operation }}</td>
                            <td> 
                                @if ($req->status == 'DONE')
                                    <span style="color:green">DONE</span>
                                @else
                                    <span style="color:red">NOT DONE</span>
                                @endif
                            </td>
                            <td> 
                                @if ($req->active == 1)
                                    <span style="color:green">ACTIVE</span>
                                @else
                                    <span style="color:red">NOT ACTIVE</span>
                                @endif
                            </td>
                            <td></td>
                            
                        </tr>
                    @endforeach
                    
                    </tbody>                
            </div>
        </div>
    </div>
</div>
@endsection