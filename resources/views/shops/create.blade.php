@section('styles')
    <link href="/dashboard/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @include('shops.partials.header',[
        'pageTitle' => 'Crear Tienda',
        'url' => '/shops/create',
        'actions' => []
    ])

    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <shop-form/>
            </div>
        </div>
    </div>
@endsection