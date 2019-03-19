@extends('mainpage')

@section('first')

<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-1">

			<!-- <img src="planets.gif" width="145" height="126" alt="Planets" usemap="#planetmap"> -->
			<img src="http://172.27.161.173/bbstock/public/plan.png" width="781px" height="384px" alt="Plan" usemap="#plan">

			<map name="plan" id="plan">
			    
			    <area alt="" title="01" href="{{url('/map/01')}}" shape="rect" coords="619,211,773,362" />
			    <area alt="" title="02" href="{{url('/map/02')}}" shape="rect" coords="438,211,591,362" />
			    <area alt="" title="03" href="{{url('/map/03')}}" shape="rect" coords="231,211,385,362" />
			    <area alt="" title="04" href="{{url('/map/04')}}" shape="rect" coords="18,210,172,362" />
			    <area alt="" title="05" href="{{url('/map/05')}}" shape="rect" coords="619,13,773,165" />
			    <area alt="" title="06" href="{{url('/map/06')}}" shape="rect" coords="438,13,591,164" />
			    <area alt="" title="07" href="{{url('/map/07')}}" shape="rect" coords="232,13,384,164" />
			    <area alt="" title="08" href="{{url('/map/08')}}" shape="rect" coords="19,12,172,164" />
			    
			</map>
			<br><br><br><br>
			<div class="text-center col-md-6 col-md-offset-10">
				<a href="{{url('/map/group1')}}" class="btn btn-default btn-lg center-block">Group 1</a>
				<a href="{{url('/map/group2')}}" class="btn btn-default btn-lg center-block">Group 2</a>
				<a href="{{url('/map/suspended')}}" class="btn btn-default btn-lg center-block">Suspended</a>
			</div>

		</div>
	</div>
</div>

@endsection
