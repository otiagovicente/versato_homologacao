@extends('layouts.dashboard')

@section('content')
  <chart-orders-by-brand></chart-orders-by-brand>
  <chart-orders-by-customer></chart-orders-by-customer>
  <chart-orders-by-representative></chart-orders-by-representative>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
@endsection