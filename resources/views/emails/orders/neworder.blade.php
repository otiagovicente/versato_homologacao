<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Nuevo Pedido</title>
    </head>
    <body>
        <h1>Pedido #{{ $order->id }}</h1>
        <table class="table table-striped table-hover" border="1">
            <thead>
                <tr border="0">
                    <th colspan="7" style="text-align:center"><b>Geral</b></th>
                </tr>
                <tr>
                    <th colspan="3">
                        Descuento Cliente:
                        @if($order->client_discount)
                            {{$order->client_discount}}
                        @else
                            0
                        @endif
                        %
                    </th>
                    <th colspan="4">
                        Descuento Representante:
                        @if($order->representative_discount)
                            {{$order->representative_discount}}
                        @else
                            0
                        @endif
                        %
                    </th>
                </tr>
                <tr>
                    <th colspan="7" style="text-align:center"><b>Productos</b></th>
                </tr>
                <tr>
                    <th style="width: 400px">Producto</th>
                    <th>Costo</th>
                    <th>Precio</th>
                    <th>Grid</th>
                    <th>Desc. Cliente</th>
                    <th>Desc. Representante</th>
                    <th style="width: 100px"><i class="fa fa-shopping-cart"></i> Total</th>
                </tr>
            </thead>
            <tfoot>
            <tr>
                <th style="text-align:left">Totales</th>
                <th style="text-align:center">${{$order->cost}}</th>
                <th style="text-align:center">${{$order->price}}</th>
                <th colspan="4" style="text-align:center">Total:&nbsp;&nbsp; ${{$order->total}}</th>
            </tr>
            </tfoot>
            <tbody>
                @foreach( $order->products as $product )
                    <tr>
                        <td>{{ $product->line->description}} {{$product->material->description}} {{$product->color->description}}</td>
                        <td>${{ $product->cost}}</td>
                        <td>${{ $product->price}}</td>
                        <td>
                            @foreach ($product->grids as $grid)
                                @if ($grid->id == $product->pivot->grid_id)
                                    {{ $grid->description }}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @if($product->client_discount)
                                {{$product->client_discount}}
                            @else
                                0
                            @endif
                            %
                        </td>
                        <td>
                            @if($product->representative_discount)
                                {{$product->representative_discount}}
                            @else
                                0
                            @endif
                            %
                        </td>
                        <td>
                            ${{ $product->pivot->total }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>

</html>