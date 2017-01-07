<style>
  body, html {
    padding:0px; margin:0px;
  }
</style>
<html>
  <body>

<!-- inner email  -->
<table cellpadding="0" cellspacing="0" width="100%" height="100%">
  <tr>
    <td valign="top" align="center" bgcolor="#F3F3F3" width="100%">
    <!-- mail header -->
    <table cellspacing="0" cellpading="0" width="100%" height="100px" style="margin-top:50px;">
      <tr>
        <td valign="center" bgcolor="#33495F" width="60%">
            <img src="https://s3-sa-east-1.amazonaws.com/sistema-versato/products/7ce92de2da23db33cd9296a768e5fdd7.jpeg" 
              alt="" style="float:left; margin-left:30px;">
        </td>
        <td valign="top" bgcolor="#33495F" width="40%" align="right">
          <!-- linha 1 -->
          <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:24px; font-weight:normal; color: white; margin-top: 20px; margin-right:20px; float:left; width: 90%">Pedido <b>#{{$order->id}}</b></span>
          <!-- /linha 1 -->
          <!-- linha 2 -->
          <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:14px; font-weight:normal; color: #ccc; margin-top: 10px; float:left; margin-right:20px; width:90%">{{$order->created_at}} - {{$order->representative->user->name}}</span>
          <!-- /linha 2 -->
        </td>
      </tr>
    </table>
    <!-- /mail header -->
    <!-- info pedido -->
    <table cellspacing="0" cellpading="0" width="100%" height="80px" >
      <tr>
        <td valign="center" align="center" bgcolor="#FFFFFF" width="50%">
            <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:13px; font-weight:normal; color: #33495f;">
                Cliente: <b>{{$order->customer->name}}</b>
            </span> <br><br>
            <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:13px; font-weight:normal; color: #33495f; padding-top: 10px;">
                <!--Centro de Entrega:-->
            </span>
        </td>
        <td valign="center" align="center" bgcolor="#FFFFFF" width="50%">
            <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:13px; font-weight:normal; color: #33495f;  ">
                Descuento del Cliente: <b>{{$order->customer_discount? $order->customer_discount:0}}%</b>
            </span><br><br>
            <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:13px; font-weight:normal; color: #33495f; margin-top: 10px; ">
                Descuento del Representante: <b>{{$order->representative_discount? $order->representative_discount:0}}%</b>
            </span>
        </td>
      </tr>
    </table>
    <!-- /info pedido -->
    <!-- product list header -->
    <table cellspacing="5" cellpading="0" width="100%" height="60px" >
      <tr>
        <td valign="center" align="left" bgcolor="#f2f2f2" width="32%">
          <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:12px; font-weight:normal; color: #999; margin-top: 15px;  width: 100%; text-align:center"><b>Producto</b></span>
        </td>
        <td valign="center" align="center" bgcolor="#f2f2f2" width="16%">
          <span style="margin-left:5px; font-family: Helvetica, 'Arial', sans-serif; font-size:12px; font-weight:normal; color: #999; margin-top: 15px;   width: 100%; text-align:center"><b>Precio</b></span>
        </td>
        <td valign="center" align="center" bgcolor="#f2f2f2" width="10%">
          <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:12px; font-weight:normal; color: #999; margin-top: 15px;   width: 100%; text-align:center"><b>Tarea</b></span>
        </td>
        <td valign="center" align="center" bgcolor="#f2f2f2" width="10%">
          <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:12px; font-weight:normal; color: #999; margin-top: 15px;   width: 100%; text-align:center"><b>Desc. Cliente</b></span>
        </td>
        <td valign="center" align="center" bgcolor="#f2f2f2" width="10%">
          <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:12px; font-weight:normal; color: #999; margin-top: 15px;   width: 100%; text-align:center"><b>Desc. Rep</b></span>
        </td>
        <td valign="center" align="right" bgcolor="#f2f2f2" width="16%">
          <span style="margin-right:10px;font-family: Helvetica, 'Arial', sans-serif; font-size:12px; font-weight:normal; color: #999; margin-top: 15px;   width: 100%; text-align:center"><b>Total</b></span>
        </td>
      </tr>
    </table>
    <!-- /product list header -->
    <!-- product list -->

    
    <table cellspacing="1" cellpading="0" width="100%" >
      <!-- row 1 -->
        @foreach( $order->products as $product )
            <tr>
                <td valign="center" align="left" bgcolor="#ffffff" style="padding-left:2%;" width="32%" height="60px">
                    <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:12px; font-weight:normal; color: #000; margin-top: 15px;  width: 100%; text-align:center">
                        {{ $product->line->description}} {{$product->material->description}} {{$product->color->description}}
                    </span>
                </td>
                <td valign="center" align="center" bgcolor="#ffffff" width="16%">
                    <span style="margin-left:5px; font-family: Helvetica, 'Arial', sans-serif; font-size:12px; font-weight:normal; color: #000; margin-top: 15px;   width: 100%; text-align:center">
                        ${{ $product->price}}
                    </span>
                </td>
                <td valign="center" align="center" bgcolor="#ffffff" width="10%">
                    <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:12px; font-weight:normal; color: #000; margin-top: 15px;   width: 100%; text-align:center">
                        @foreach ($product->grids as $grid)
                            @if ($grid->id == $product->pivot->grid_id)
                                {{ $grid->description }}
                            @endif
                        @endforeach
                    </span>
                </td>
                <td valign="center" align="center" bgcolor="#ffffff" width="10%">
                    <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:12px; font-weight:normal; color: #000; margin-top: 15px;   width: 100%; text-align:center">
                        {{$product->discount? $product->discount:0}}%
                    </span>
                </td>
                <td valign="center" align="center" bgcolor="#ffffff" width="10%">
                    <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:12px; font-weight:normal; color: #000; margin-top: 15px;   width: 100%; text-align:center">
                        {{$product->representative_discount? $product->representative_discount : 0}}%
                    </span>
                </td>
                <td valign="center" align="right" bgcolor="#ffffff" width="16%">
                    <span style="margin-right:10px;font-family: Helvetica, 'Arial', sans-serif; font-size:12px; font-weight:normal; color: #000; margin-top: 15px;   width: 100%; text-align:center">
                        $ {{$product->pivot->total}}
                    </span>
                </td>
            </tr>
        @endforeach
      <!-- /row 1 -->
    </table>
    <!-- /product-list  -->
    <!-- totais -->
    <table cellspacing="4" cellpading="0" width="100%" height="60px" style="border:1px solid #e2e2e2; margin-top:5px;">
      <tr>
        <td valign="center" align="left" bgcolor="#f2f2f2" width="35%">
          <span style="margin-left:4%;font-family: Helvetica, 'Arial', sans-serif; font-size:12px; font-weight:normal; color: #999; margin-top: 15px;  width: 100%; text-align:center"><b>Totales</b></span>
        </td>
        <td valign="center" align="center" bgcolor="#f2f2f2" width="16%">
          <span style="margin-left:5px; font-family: Helvetica, 'Arial', sans-serif; font-size:16px; font-weight:normal; color: #000; margin-top: 15px;   width: 100%; text-align:center">
            <b></b>
          </span>
        </td>
        <!-- Deve manter, por motivos de alinhamento -->
        <td valign="center" align="center" bgcolor="#f2f2f2" width="10%">
          <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:12px; font-weight:normal; color: #999; margin-top: 15px;   width: 100%; text-align:center"></span>
        </td>
        <td valign="center" align="center" bgcolor="#f2f2f2" width="10%">
          <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:12px; font-weight:normal; color: #999; margin-top: 15px;   width: 100%; text-align:center"></span>
        </td>
        <td valign="center" align="center" bgcolor="#f2f2f2" width="10%">
          <span style="font-family: Helvetica, 'Arial', sans-serif; font-size:12px; font-weight:normal; color: #999; margin-top: 15px;   width: 100%; text-align:center"></span>
        </td>
        <!-- Fim dos objetos fantasmas -->
        <td valign="center" align="right" bgcolor="#f2f2f2" width="46%">
          <span style="margin-right:10px;font-family: Helvetica, 'Arial', sans-serif; font-size:16px; font-weight:normal; color: #000; margin-top: 15px;   width: 100%; text-align:center"><b>${{$order->total}}</b></span>
        </td>
      </tr>
    </table>
    <!-- /totais -->
    <!--  spacer -->
    <table width="100%">
      <tr>
        <td height="40px"></td>
      </tr>
    </table>
    <!--  /spacer -->
    </td>
  </tr>
</table>
<!-- /inner email -->


  </body>
</html>
