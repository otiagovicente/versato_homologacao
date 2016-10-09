@extends('layouts.dashboard')

@section('scripts')
	{{--<script src="/dashboard/pages/scripts/dashboard.min.js" type="text/javascript"></script>--}}
@endsection

@section('content')

@include('lines.partials.header', [
    'pageTitle' => 'Mostrar Todos',
    'url' => '/lines',
    'actions' => []
])
	<div class="container-fluid">
        <?php

            $i = 0;
            $colors = ['red','yellow-casablanca', 'yellow-lemon', 'green-steel','blue-steel','blue'];
        ?>
		@foreach($lines as $line)


			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<a class="dashboard-stat dashboard-stat-v2 grey" href="/lines/{{$line->id}}">
					<div class="visual">
						<i class="fa fa-sitemap"></i>
					</div>
					<div class="details">
						<div class="number">
							<span>{{$line->code}}</span>
						</div>
						<div class="desc"> {{$line->description}}
                        </div>
                    </div>

				</a>
			</div>
            <?php
                $i++;
            ?>
            @if($i == count($colors))
                <?php $i = 0; ?>
            @endif

	    @endforeach
	</div>
@endsection