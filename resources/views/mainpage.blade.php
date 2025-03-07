<!DOCTYPE html>
<html lang="en">
<head>
	{{--@extends('head')--}}
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BBStock2</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/css.css') }}" rel="stylesheet">
	<!-- <link href="{{ asset('/css/bootstrap.min.css') }}" rel='stylesheet' type='text/css'> -->
	<link href="{{ asset('/css/choosen.css') }}" rel='stylesheet' type='text/css'>
	<link href="{{ asset('/css/bootstrap-table.css') }}" rel='stylesheet' type='text/css'>
	<link href="{{ asset('/css/jquery-ui.min.css') }}" rel='stylesheet' type='text/css'>
	<link href="{{ asset('/css/custom.css') }}" rel="stylesheet">
	<link rel="manifest" href="{{ asset('/css/manifest.json') }}">

</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					{{--<span class="sr-only">Toggle Navigation</span>--}}
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}"><b>BBStock</b></a>
			</div>
			
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

				@if (Auth::guest())
				
				@else

					@if (Auth::user()->name == 'magacin' OR Auth::user()->name == 'admin')
					<!-- <ul class="nav navbar-nav">
						<li><a href="{{ url('/') }}">Main menu</a></li>
					</ul> -->
					<ul class="nav navbar-nav">
						<li>
							<div class="dropdown">
								<button class="btn btn-default dropdown-toggle" style="margin: 8px 5px !important;" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								Extra operations
								<span class="caret"></span>
								</button>
							  	<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							    
							    <li role="separator" class="divider">Functions</li>
							    <li role="separator" class="divider">Functions</li>
							    <li><a href="{{ url('/op_by_op') }}">Confirm extra op by op</a></li>
							    <li><a href="{{ url('/op_by_bb') }}">Confirm extra op by BB</a></li>
							    <li><a href="{{ url('/all_by_bb') }}">Confirm ALL extra op by BB</a></li>
							    <li role="separator" class="divider">Tables</li>
							    <li role="separator" class="divider">Tables</li>
							    <li><a href="{{ url('/extra_sku') }}">Extra op by SKU</a></li>
							    <li><a href="{{ url('/extra_style_size') }}">Extra op by Style and Size</a></li>
							    <li><a href="{{ url('/extra_style') }}">Extra op by Style</a></li>
							    <li role="separator" class="divider">Tables</li>
							    <li><a href="{{ url('/extra_op') }}">Extra op</a></li>
							    
							  </ul>
							</div>
						</li>
					</ul>
					<!-- <ul class="nav navbar-nav">
						<li><a href="{{ url('/export') }}">Export to all CSV</a></li>
					</ul> -->
					<!-- <ul class="nav navbar-nav">
						<li><a href="{{ url('/map') }}">Map</a></li>
					</ul> -->
					<ul class="nav navbar-nav">
						<li>
							<div class="dropdown">
								<button class="btn btn-default dropdown-toggle" style="margin: 8px 5px !important;" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								Log tables
								<span class="caret"></span>
								</button>
							  	<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							    
							    <li><a href="{{ url('/tablelog') }}">Table Log</a></li>
							    <li><a href="{{ url('/deliveredlog') }}">Delivered Log</a></li>
							    <li><a href="{{ url('/bundlelog') }}">Bundle Log</a></li>
							    <!-- <li role="separator" class="divider">Tables</li> -->
							    
							  </ul>
							</div>
						</li>
					</ul>
					<ul class="nav navbar-nav">
						<li>
							<div class="dropdown">
								<button class="btn btn-default dropdown-toggle" style="margin: 8px 5px !important;" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								Locations
								<span class="caret"></span>
								</button>
							  	<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							    
							    <li><a href="{{ url('/locations') }}">Location table</a></li>
							    <li><a href="{{ url('/location_new') }}">Add new location</a></li>
							    <!-- <li role="separator" class="divider">Tables</li> -->
							    
							  </ul>
							</div>
						</li>
					</ul>
					<ul class="nav navbar-nav">
						<li><a href="{{ url('/table') }}">BBStock Table</a></li>
					</ul>
					<!-- <ul class="nav navbar-nav">
						<li><a href="{{ url('/tablelog') }}">Table Log</a></li>
					</ul>
					<ul class="nav navbar-nav">
						<li><a href="{{ url('/deliveredlog') }}">Delivered Log</a></li>
					</ul>
					<ul class="nav navbar-nav">
						<li><a href="{{ url('/bundlelog') }}">Bundle Log</a></li>
					</ul> -->
					<!-- <ul class="nav navbar-nav">
						<li><a href="{{ url('/status') }}">Delete by status</a></li>
					</ul> -->
					<!-- <ul class="nav navbar-nav">
						<li><a href="{{ url('/locations') }}">Locations</a></li>
					</ul> -->
					<ul class="nav navbar-nav">
						<li><a href="{{ url('/searchbypo') }}">Search by PO</a></li>
					</ul>
					<!-- <ul class="nav navbar-nav">
						<li><a href="{{ url('/searchbybb') }}">Search by BB</a></li>
					</ul>  -->
					@endif

					@if (Auth::user()->name == 'workstudy')
					<ul class="nav navbar-nav">
						<li><a href="{{ url('/export') }}">Export to all CSV</a></li>
					</ul>
					<ul class="nav navbar-nav">
						<li><a href="{{ url('/table') }}">Table</a></li>
					</ul>
					@endif

				@endif

				{{--<ul class="nav navbar-nav">
					<li><a href="{{ url('/home') }}">Home</a></li>
				</ul>
				--}}
				
				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						{{-- <li><a href="{{ url('/auth/register') }}">Register</a></li> --}}
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
				
			</div>
			
		</div>
	</nav>

	@yield('index')
	@yield('content')
	@yield('first')
	@yield('findbb')
	@yield('create')
	@yield('error')

	<!-- Scripts -->
	<script src="{{ asset('/js/jquery.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript" ></script>

    <script src="{{ asset('/js/choosen.js') }}" type="text/javascript" ></script>

    <script src="{{ asset('/js/bootstrap-table.js') }}" type="text/javascript" ></script>
	<script src="{{ asset('/js/jquery-ui.min.js') }}" type="text/javascript" ></script>

	<script src="{{ asset('/js/tableExport.js') }}" type="text/javascript" ></script>
	<script src="{{ asset('/js/FileSaver.min.js') }}" type="text/javascript" ></script>
	<script src="{{ asset('/js/bootstrap-table-export.js') }}" type="text/javascript" ></script>

    <script type="text/javascript">
	$(function() {
		$("#checkAll").click(function () {
			console.log('test check');
	    	$(".check").prop('checked', $(this).prop('checked'));
		});
	});    
	$(function() {
		$('#filter').keyup(function () {

	        var rex = new RegExp($(this).val(), 'i');
	        $('.searchable tr').hide();
	        $('.searchable tr').filter(function () {
	            return rex.test($(this).text());
	        }).show();
		});
	$(function () {
	var $table = $('.table');
		$('#toolbar').find('select').change(function () {
    		$table.bootstrapTable('refreshOptions', {
		      exportDataType: $(this).val()
    		});
  		});
	});
	$('#sort').bootstrapTable({
    
	});
	$(".chosen").chosen();
	
	/*
    $('.session').keypress(function(event) {
  		if ( event.which == 13 ) {
     		event.preventDefault();
  		}
  		xTriggered++;
  		var msg = "Handler for .keypress() called " + xTriggered + " time(s).";
  		$.print( msg, "html" );
  		//$.print( event );
	});
	*/
	// $('#proba').keyup(function(e){
	// 	if(e.keyCode == 13) {
	// 		var bblist = $('#proba').val();
	//   		$("#display").append("<li>" + bblist + "</li>");

	//   		$('#proba').val('');

	//   		var optionTexts = [];
	// 		$("#display li").each(function() {
	// 			optionTexts.push($(this).text()) 
	// 		});

	// 		console.log(optionTexts);
	// 	}
	// });
	
	/*
	$("#proba").change(function() {
    	alert("Something happened!");
	});
		
	$('#proba').keyup(function () {
  		$('#display').text($(this).val());
	});
	*/
	//console.log("proba");

	});	
    </script>


	
</body>
</html>

