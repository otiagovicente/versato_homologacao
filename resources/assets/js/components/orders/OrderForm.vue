<style>
    div .product-list-photo{
        height: 50px;
        width: auto;
    }
</style>

<template>
    bla bla
</template>

<script>
    import toastr from 'toastr'
    import VueStrap from 'vue-strap'

export default{
    props:[
      'porder'
    ],
    
    components: {
        vSelect: VueStrap.select,
        vOption: VueStrap.option
    },
    
    data(){
        return{
            customers_select:[],
            representatives_select:[],
            brands_select:[],
            brand_id:[],
            products:[],
            orderProductsDelete:[],

            order: {
                id:'',
                cost:0,
                price:0,
                total:0,
                overalldiscount:0,
                representative_comision:0,
                representative_discount:0,
                client_discount:0,
                status_id:[],
                customer_id:[],
                representative_id:[],
                orderProducts:[]
            },
        }
    },
    ready(){
        window._this = this;
        toastr.options.closeButton = true;
        _this.getCustomers();
        _this.getRepresentatives();
        _this.getProducts(Versato.brand_id);
        
        //if(this.porder) this.loadOrder();
    },
    methods:{
        deleteProduct: function(index){
            _this.orderProductsDelete.push(this.order.orderProducts[index]);
            _this.order.orderProducts.splice(index, 1);
        },

        updateOrderValues: function(){
            _this.order.cost = 0;
            _this.order.price = 0;
            _this.order.total = 0;
            _this.order.overalldiscount = 0;

            for (var i = 0; i < this.order.orderProducts.length; i++) {
                var finalPrice = this.calcFinalPrice(_this.order.orderProducts[i]);
                _this.order.orderProducts[i].total = finalPrice.finalPrice;
                _this.order.orderProducts[i].totaldiscount = finalPrice.totalDiscount;

                _this.order.cost            += parseFloat(_this.order.orderProducts[i].cost);
                _this.order.price           += parseFloat(_this.order.orderProducts[i].price);
                _this.order.total           += parseFloat(_this.order.orderProducts[i].total);
                _this.order.overalldiscount += parseFloat(_this.order.orderProducts[i].totaldiscount);
            }
        },
        addToProductList: function(product){
            var finalPrice = _this.calcFinalPrice(product);
            
            _this.order.orderProducts.push({
              id:product.id,
              code:product.code,
              cost:product.cost,
              price:product.price,
              chk_client_discount:false,
              chk_representative_discount:false,
              client_discount: product.client_discount,
              representative_discount: product.representative_discount,
              total: finalPrice.finalPrice,
              totaldiscount:finalPrice.totalDiscount,
            });
            return _this.order.orderProducts[_this.order.orderProducts.length - 1];
        },
        
        calcFinalPrice: function(product){
            var finalPrice              = {finalPrice:0, totalDiscount:0};
            var finalDiscount           = 0;
            var totalGeneralDiscount    = 0;
            var totalIndividualDiscount = 0;

            totalGeneralDiscount    = _this.calcGeneralDiscount();
            totalIndividualDiscount = _this.calcIndidualDiscount(product);
            
            finalDiscount = totalIndividualDiscount? totalIndividualDiscount : totalGeneralDiscount;
            
            finalPrice.totalDiscount = ((parseFloat(finalDiscount)/100) * parseFloat(product.price));
            finalPrice.finalPrice = (parseFloat(product.price) - parseFloat(finalPrice.totalDiscount));
            
            return finalPrice;
        },
        calcGeneralDiscount: function(){
            var client_discount         = _this.order.client_discount         ? _this.order.client_discount         : 0;
            var representative_discount = _this.order.representative_discount ? _this.order.representative_discount : 0;
            return parseFloat(client_discount) + parseFloat(representative_discount);
        },
        calcIndidualDiscount: function(product){
            var client_discount         = product.client_discount         ? product.client_discount         : 0;
            var representative_discount = product.representative_discount ? product.representative_discount : 0;
            return parseFloat(client_discount) + parseFloat(representative_discount);
        },
        getProducts:function(brandid){
            this.$http.get('/api/products/list/'+brandid)
            .then(response => {
                _this.products = response.data;
            });
        },
        getCustomers: function(){
            this.$http.get('/api/customers/selectlist')
            .then(response => {
                _this.customers_select = response.json();
            });
        },
        getRepresentatives: function(){
            this.$http.get('/api/representatives/selectlist')
            .then(response => {
                _this.representatives_select = response.json();
            });
        },

        submitData: function(){
            if(!_this.order.id)
                _this.insertData();
            else
                _this.updateData();
        },
        
        insertData: function(){
            Vue.http.interceptors.push((request, next) => {
                request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;
                next();
            });
            this.$http.post('/orders', _this.order)
            .then((response) => {
              toastr.success('Sucesso!','Pedido creado con sucesso!');
            }, (response) => { 
              _this.showErrors(response.data); 
            });
        },
        
        updateData: function(){
          this.$http.put('/orders/'+_this.order.id, _this.order)
          .then((response) => {
            toastr.success('Sucesso!','Pedido atualizado con sucesso!');
          }, (response) => { 
            _this.showErrors(response.data); 
          }); 
        },
        
        showErrors: function(data){
          $.each(data, function (key, value) {
            toastr.warning('Atención', value);
            $('#'+key).addClass('has-error');
          }); 
        },
    },

    watch: {
        'order.orderProducts': function (val, oldVal) {
            _this.updateOrderValues();
        },
        'order.client_discount': function(val, oldVal){
            _this.updateOrderValues();
        },
        'order.representative_discount': function(val, oldVal){
            _this.updateOrderValues();
        },
    },
}
</script>