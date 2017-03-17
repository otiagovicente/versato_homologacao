@extends('layouts.lock')

@section('content')

    <div class="container-fluid">

        @foreach($brands as $brand)
            <div class="row">

                <div class="container" >
                    <a href="{{ url('/brands/'.$brand->id.'/setselected') }}" alt="Selecionar Marca">
                      <img src="{{ $brand->image }}" alt="{{ $brand->name }}" width="100%">
                    </a>
                </div>
            </div>
            <br>

        @endforeach
    </div>

@endsection