var app = new Vue({
  el: '#vuejscrudproduct',
  data: {
    showAddModal: false,
    showEditModal: false,
    view: true,
    products: [],
    newProduct: {product_name: '', product_description: '', quantity: '', price: ''},
    clickProduct: {},
    disableStatus: {},
  },

  methods: {
    disable(product) {
      this.view = false;
      app.disableStatus = product;
    },
    enable() {
      this.view = true;
    },
    getAllProduct: function() {
      axios.get('api.php')
        .then(function(response) {
          if (response.data.error) {
            app.errorMessage = response.data.message;
          } else {
            app.products = response.data.products;
          }
        })
        .catch(function(error) {
          console.error(error);
        });
    },
    saveProduct() {
      var prodForm = app.toFormData(app.newProduct);
      
      axios.post('api.php?crud=create', prodForm)
        .then(function(response){
          app.newProduct = {product_name: '', product_description: '', quantity: '', price: ''};
          if (response.data.error) {
            app.errorMessage = response.data.message;
          } else {
            app.successMessage = response.data.products;
            app.getAllProduct();
          }
        });
    },

    updateProduct(){
      var prodForm = app.toFormData(app.clickProduct);
      
      axios.post('api.php?crud=update', prodForm)
        .then(function(response){
          app.clickProduct = {};
          if (response.data.error) {
            app.errorMessage = response.data.message;
          } else {
            app.successMessage = response.data.products;
            app.getAllProduct();
          }
        });
    },

    updateStatusdisable(){
      var prodForm = app.toFormData(app.disableStatus);
      axios.post('api.php?crud=updateDisableStatus', prodForm)
        .then(function(response){
          app.disableStatus = {};
          if (response.data.error) {
            app.errorMessage = response.data.message;
          } else {
            app.successMessage = response.data.products;
            app.getAllProduct();
          }
        });
    },

    selectProduct(product){
      app.clickProduct = product;
    },

    toFormData: function(obj){
      var form_data = new FormData();
      for(var key in obj){
        form_data.append(key, obj[key]);
      }
      return form_data
    },
    clearMessage: function(){
      app.errorMessage = '';
      app.successMessage = '';
    },
  },


  
  
  mounted: function() {
    this.getAllProduct();
  }
  
});

