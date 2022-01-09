@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Prepare Table (last 7 days)
                           
                            </div>
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
                                        <th data-sortable="true"><b>BB code</b></th>
                                        <th data-sortable="true"><b>BB name</b></th>
                                        <th>Inteos (1=Su, 2=Ki)</th>
                                        <th data-sortable="true">R number</th>
                                        <th data-sortable="true">Username</th>
                                        <th>Function</th>
                                        <th>Po</th>
                                        <th>Style</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Qty</th>
                                        <th>Bagno</th>
                                        <th>Operation</th>
                                        <th>Date</th>
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody class="searchable">
                                @foreach ($batch as $req)
                                    <tr>
                                        {{-- <td>{{ $req->id }}</td> --}}
                                        <td>{{ $req->bbcode }}</td>
                                        <td>{{ $req->bbname }}</td>
                                        <td>{{ $req->inteosdb }}</td>
                                        <td>{{ $req->rnumber }}</td>
                                        <td>{{ $req->username }}</td>
                                        <td>{{ $req->f }}</td>
                                        <td>{{ $req->po }}</td>
                                        <td>{{ $req->style }}</td>
                                        <td>{{ $req->color }}</td>
                                        <td>{{ $req->size }}</td>
                                        <td>{{ $req->qty }}</td>
                                        <td>{{ $req->bagno }}</td>
                                        <td>{{ $req->operation }}</td>
                                        <td>{{ $req->created_at }}</td>
                                        
                                    </tr>
                                @endforeach
                                
                                </tbody>   
                                </table> 
                        </div>
                    </div>

                </div>
         </div>
    </div>
</div>
@endsection