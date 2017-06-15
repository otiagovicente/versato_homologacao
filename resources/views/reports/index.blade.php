@extends('layouts.dashboard')

@section('content')
  <chart-orders-by-brand></chart-orders-by-brand>
  <chart-orders-by-customer></chart-orders-by-customer>
  <chart-orders-by-representative></chart-orders-by-representative>
<<<<<<< HEAD
=======
  <chart-orders-by-region></chart-orders-by-region>

>>>>>>> 9db5c1bc97c2bfe08339dca5aeb120c81be4919a
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
@endsection