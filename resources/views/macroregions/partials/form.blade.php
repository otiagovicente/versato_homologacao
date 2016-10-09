@section('styles')
@stop

<div id="code-input" class="form-group">
    <label class="col-md-3 control-label">Nome</label>
      <div class="col-md-7">                
        <input type="text" 
          name="code"
          class="form-control" 
          placeholder="Nome"
          v-model="macroregion.name"
        >
      </div>
  </div>
  <div id="code-input" class="form-group">
    <label class="col-md-3 control-label">Descrição</label>
      <div class="col-md-7">                
        <input type="text" 
          name="code"
          class="form-control" 
          placeholder="Descrição"
          v-model="macroregion.description"
        >
      </div>
  </div>
  
  <div id="code-input" class="form-group">
    <label class="col-md-3 control-label">Região</label>
      <div class="col-md-12" style="padding:15px">
        
        <div id="vue-map">
            <div id="map_canvas2"></div>
        </div>

      </div>
  </div>
  
  <div class="row">
    <hr>
    <div class="container-fluid">
      <div class="col-md-3 pull-right">
        <div class="form-group">
          <button 
            type="button" 
            @click="submitData()" 
            class="btn blue btn-block"
          >
            Salvar
          </button>
        </div>
      </div>  
      <div class="col-md-3 pull-right">
        <div class="form-group">
          <a href="/macroregions/"><button type="button" class="btn grey btn-block">Cancel</button></a>
            </div>
        </div>
    </div>
  </div>


@section('scripts')
    <script>
        var App = new Vue({
            el: 'body',
            data: {
            
            },
            ready: function() {
                var myOptions = {
                    zoom: 12,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    center: new google.maps.LatLng(25.761680, -80.19179)
                };
                var map = new google.maps.Map(document.getElementById("map_canvas2"), myOptions);
            },
        });
    </script>
@stop