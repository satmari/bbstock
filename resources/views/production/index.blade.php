@extends('app')

@section('content')

<!-- {{-- header( "refresh:3600;url=/production" ) --}} -->
<!-- {{-- header( "refresh:30;url=bbstock2/production" ) --}} -->

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
				<div class="panel-heading">


                @if (Auth::check() && Auth::user()->level() != 3)
                <a href="{{url('/target/'.$username)}}" class="left btn btn-default btn-danger"><b>Line target</b></a>
                &nbsp &nbsp &nbsp   
                @endif

                &nbsp 
                &nbsp 

                @foreach ($status_sum as $line)
                    @if ($line->status == 'DELIVERED')
                        STOCK IN FRONT: <b>{{ $line->sum_qty}}</b> Qty | <b>{{ round($line->sum_pitch_time, 0) }}</b> Min
                    @endif
                &nbsp  
                @endforeach
                &nbsp &nbsp 

                @if (Auth::check() && Auth::user()->level() != 3)
                <a href="{{url('/deliver/'.$username)}}" class="left btn btn-default btn-info"><b>WH</b> - Deliver BB</a>
                &nbsp &nbsp &nbsp   
                @endif

                Line <big><b>{{ $username }}</b></big>
               
                @if (Auth::check() && Auth::user()->level() != 3)
                &nbsp &nbsp &nbsp 
                <a href="{{url('/receive/'.$username)}}" class="right btn btn-default btn-info"><b>LL</b> - Receive BB</a>
                @endif

                &nbsp &nbsp
                <?php $i = 0; ?>
                @foreach ($status_sum as $line)
                    @if ($line->status == 'FINISHING' OR $line->status == 'WIP')
                        
                        <?php $i = $i + $line->sum_qty; ?>
                    @endif
                &nbsp  
                @endforeach

                WIP: <b>{{ $i }}</b> Qty
                &nbsp &nbsp 
                


                </div>
				
                

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
	                        <!-- <td>Id</td> -->
	                        <th>BB</th>
                            <th>Style</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Qty</th>
                            <th>Boxes</th>
                            {{--<th>Location</th>--}}
	                        <th>Status</th>
                            {{--<th>Updated</th>--}}
	                        
                            <td></td>
                            <td></td>
                            <td><a href="{{url('http://172.27.161.171/cutting/req_extrabb_line_history/'.$username)}}" class="right bt n bt n-default btn-info"><b>Cut request history</a></td>
                        </tr>
                    </thead>
                    <tbody class="searchable">
			        @foreach ($db as $req)
                        <tr>
                            {{--<td>{{ $req->id }}</td>--}}
                            <td><big>{{ substr($req->bbname,-13,10)  }} <b>{{substr($req->bbname,-3)}}</b></big></td>
                            <td>{{ $req->style }}</td>
                            <td>{{ $req->color }}</td>
                            <td>{{ $req->size }}</td>
                            <td>{{ $req->qty }}</td>
                            <td>{{ $req->numofbb }}</td>
                            {{--<td>{{ $req->location }}</td>--}}
                            <td><b>{{ $req->status }}</b></td>
                            {{--<td>{{ $req->updated_at }}</td>--}}

                            <td><a href="{{ url('/bundle/'.$req->id) }}" class="btn btn-info btn-xs center-block"
                            @if ($req->status != 'DELIVERED')
                                disabled
                            @endif
                                ><span style="font-size:xx-small">Bundle IN</span></a></td>
                            <td>
                                <a href="{{ url('/give/'.$req->id) }}" class="btn btn-info btn-xs center-block"
                            ><span style="font-size:xx-small">Give BB</span></a>
                            </td>
                            <td>
                                <a href="http://172.27.161.171/cutting/bb/{{ $username }}/{{ $req->id }} " class="btn btn-info btn-xs center-block"
                            ><span style="font-size:xx-small">Cut parts</span></a>
                            </td>
                        </tr>
                    @endforeach
                    
                    </tbody>				
			</div>
		</div>
	</div>
</div>
@endsection