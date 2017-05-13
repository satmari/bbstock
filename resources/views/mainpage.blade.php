<!DOCTYPE html>
<html lang="en">
<head>
	{{--@extends('head')--}}
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BBStock</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/css.css') }}" rel="stylesheet">
	<!-- <link href="{{ asset('/css/bootstrap.min.css') }}" rel='stylesheet' type='text/css'> -->
	<link href="{{ asset('/css/bootstrap-table.css') }}" rel='stylesheet' type='text/css'>
	<link href="{{ asset('/css/jquery-ui.min.css') }}" rel='stylesheet' type='text/css'>
	<link href="{{ asset('/css/custom.css') }}" rel="stylesheet">

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
				<a class="navbar-brand" href="{{ url('/') }}"><b>BBStock Application</b></a>
			</div>
			
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

				@if (Auth::guest())
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">Main menu</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/export') }}">Export to all CSV</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/map') }}">Map</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/table') }}">Table</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/status') }}">Delete by status</a></li>
				</ul>
				@else

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

    <script src="{{ asset('/js/bootstrap-table.js') }}" type="text/javascript" ></script>
	<script src="{{ asset('/js/jquery-ui.min.js') }}" type="text/javascript" ></script>

	<script src="{{ asset('/js/tableExport.js') }}" type="text/javascript" ></script>
	<script src="{{ asset('/js/FileSaver.min.js') }}" type="text/javascript" ></script>
	<script src="{{ asset('/js/bootstrap-table-export.js') }}" type="text/javascript" ></script>

        <script type="text/javascript">
	$(function() {
		$('#filter').keyup(function () {

	        var rex = new RegExp($(this).val(), 'i');
	        $('.searchable tr').hide();
	        $('.searchable tr').filter(function () {
	            return rex.test($(this).text());
	        }).show();
		});
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
