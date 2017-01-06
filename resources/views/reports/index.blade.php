@extends('layouts.dashboard')

@section('content')
  <chart-sales-by-brand></chart-sales-by-brand>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
@endsection