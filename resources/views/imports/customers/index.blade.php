@extends('layouts.dashboard')
@section('content')

<div class="portlet light">
    <div class="portlet-title">
        <div class="caption font-blue">
            <i class="fa fa-plus font-blue"></i>Importar Clientes
        </div>
    </div>
    
    <div class="portlet-body form">
        <div class="form-body">
            <div class="row">
                <div class="col-md-12">
                    <div id="code-input" class="form-group form-line-input">
                        <label class="col-md-3 control-label">Exportar Clientes</label>
                        <div class="col-md-12">
                            <a href="/imports/customer/downloadExcel/xls"><button class="btn btn-success">Download Excel xls</button></a>
                            <a href="/imports/customer/downloadExcel/xlsx"><button class="btn btn-success">Download Excel xlsx</button></a>
                            <a href="/imports/customer/downloadExcel/csv"><button class="btn btn-success">Download CSV</button></a>    
                        </div>
                    </div>
                </div>
            </div>     
            <div class="row">
                <div class="col-md-12">
                    <div id="code-input" class="form-group form-line-input">
                        <label class="col-md-3 control-label">Importar Clientes</label>
                        <div class="col-md-12">
                            <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;" 
	                            action="/imports/customer/importExcel" class="form-horizontal" method="post" enctype="multipart/form-data">
	                            {{ csrf_field() }}
                                <input type="file" name="import_file" />
	                            <button class="btn btn-primary">Import File</button>
                            </form>
                        </div>
                    </div>     
                </div>                      
            </div>                   
        </div>
    </div>
</div>
@stop