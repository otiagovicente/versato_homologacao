<!DOCTYPE html>

<html>

    <head>

        <meta charset="UTF-8">

        <title>Nuevo Pedido</title>

    </head>

    <body>

        <h1>Pedido #{{$order->id}}</h1>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Producto</th>
                <th>Costo</th>
                <th>Precio</th>
                <th>Grid</th>
                <th>Desc. Cliente</th>
                <th>Desc. Representante</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
                @foreach($order->products as $product)
                        <tr>
                            <td>{{$product->line->description}} {{$product->material->description}} {{$product->color->description}}</td>
                            <td>${{$product->cost}}</td>
                            <td>${{$product->price}}</td>
                            <td>{{$product->grid->description}}</td>
                            <td>{{$product->client_discount}}%</td>
                            <td>{{$product->representative_discount}}%</td>
                            <td>${{$product->total}}</td>

                        </tr>
                @endforeach
            </tbody>
        </table>
    </body>

</html>