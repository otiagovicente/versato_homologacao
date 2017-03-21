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
  <line-list></line-list>
</div>
@endsection
