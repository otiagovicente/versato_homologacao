@extends('layouts.dashboard')

@section('content')

@include('lines.partials.header', [
    'pageTitle' => $line->name,
    'url' => '/lines/'.$line->id,
    'actions' => [ 'Editar Linea' => '/lines/'.$line->id.'/edit' ]
])
	<div class="container-fluid">

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<a class="dashboard-stat dashboard-stat-v2 blue" href="#">
				<div class="visual">
					<i class="fa fa-sitemap"></i>
				</div>
				<div class="details">
					<div class="number">
						<span>{{$line->code}}</span>
					</div>
					<div class="desc"> {{$line->description}} </div>
				</div>
			</a>
		</div>
		<div class="clearfix"></div>
		<div class="col-md-6">
			@include('lines.partials.bests-sales')
		</div>


	</div>
@stop

@section('styles')
    <!-- BEGIN PAGE LEVEL PLUGINS -->


    <!-- END PAGE LEVEL PLUGINS -->
@stop
@section('scripts')

	<script type="text/javascript" charset="utf-8">

	</script>



@stop
