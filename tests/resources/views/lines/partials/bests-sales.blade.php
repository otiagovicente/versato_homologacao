    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-comments"></i>Productos más vendidos </div>
            <div class="tools">
                <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
                <a href="javascript:;" class="reload" data-original-title="" title=""> </a>
                <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-scrollable">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th> # </th>
                        <th> Codigo </th>
                        <th> Precio </th>
                        <th> Status </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td><img style="width: 100px; height: auto;" src="{{$product->photo}}" alt="{{$product->code}}"></td>
                            <td>{{$product->code}} </td>
                            <td> {{$product->price}} </td>
                            <td> @if($product->published == 1)
                                    <span class="label label-sm label-success"> Aprovado </span>
                                 @else
                                    <span class="label label-sm label-danger"> Reprovado </span>
                                 @endif
                            </td>
                            <td>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->