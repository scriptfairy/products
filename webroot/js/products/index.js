const PAGE_SIZE = 2;

const newProduct = () => ({
  id: 0,
  name: '',
  description: '',
  picture: '',
  price: 0,
});

const cloneProduct = (product) => ({
  id: product.id,
  name: product.name,
  description: product.description,
  picture: product.picture,
  price: product.price,
});

const renderProducts = (products, error) => {
  const app = new Vue({

    el: '#products-container',

    data: {
      products: products,
      currentSortBy: 'name',
      product: null,
      productPicture: null,
      productsPrefixUrl: '/img/products/',
      isSaving: false,
      isDeleting: false,
      isFetching: false,
      error: error,
      offset: 0,
    },

    computed: {

      showProductForm: function() {
        return !!this.product;
      },

      showProductList: function() {
        return !!this.products && !this.product;
      },

      enablePreviousPage: function() {
        return this.hasPreviousPage() && !this.isFetching;
      },

      enableNextPage: function() {
        return this.hasNextPage() && !this.isFetching;
      },

      enableSort: function() {
        return !this.isFetching;
      }

    },

    methods: {

      hasPreviousPage: function() {
        return this.offset >= PAGE_SIZE;
      },

      hasNextPage: function() {
        return this.offset < (this.products.records - PAGE_SIZE);
      },

      fetchProducts: function() {
        this.isFetching = true;
        fetchProducts(this.offset, PAGE_SIZE, this.currentSortBy)
          .then((products) => {
            this.products = products;
            this.isFetching = false;
          })
          .catch((error) => {
            this.error = error;
            this.isFetching = false;
          });
      },

      nextPage: function () {
        if (this.hasNextPage()) {
          this.offset = this.offset + PAGE_SIZE;
          this.fetchProducts();
        }
      },

      previousPage: function () {
        if (this.hasPreviousPage()) {
          this.offset = this.offset - PAGE_SIZE;
          this.fetchProducts();
        }
      },

      sortBy: function(field) {
        this.currentSortBy = field;
        this.offset = 1;
        this.fetchProducts();
      },

      sortIndicator: function(field) {
        return this.currentSortBy === field ? '^' : '';
      },

      addProduct: function() {
        this.product = newProduct();
        this.productPicture = null;
      },

      cancelProduct: function() {
        this.product = null;
        this.productPicture = null;
        this.error = null;
      },

      editProduct: function(product) {
        this.product = cloneProduct(product);
        this.productPicture = null;
      },

      selectProductPicture: function(event) {
        this.productPicture = event.target.files[0];
      },

      deleteProduct: function(product) {
        this.error = null;
        const message = `Are you sure you want to delete ${product.name}?`;
        const result = window.confirm(message);
        if(result) {
          this.isDeleting = true;
          deleteProduct(product)
            .then((response) => {
              this.isDeleting = false;
              const index = this.products.indexOf(product);
              this.products.data.splice(index, 1);
            })
            .catch((error) => {
              console.log(error);
              this.isDeleting = false;
              this.error = 'There was a problem deleting the product.';
            });
        }
        else {
          return false;
        }
      },

      saveProduct: function() {
        if(!this.product.name || !this.product.description || !this.product.price || !this.productPicture){
          this.error = "Error saving the product. Provide mandatory fields.";
          return false;
        }
        this.isSaving = true;
        this.btnDisabled = true;
        this.error = null;
        saveProduct(this.product, this.productPicture)
          .then((newProduct) => {
            this.product = null;
            this.productPicture = null;
            this.isSaving = false;
            const foundProduct = this.products.data.find(product => product.id === newProduct.id);
            if (foundProduct) {
              this.products.data = this.products.data.map(product => {
                return (product.id === newProduct.id) ? newProduct : product;
              });
            } else {
              this.products.push(newProduct);
            }
          })
          .catch((error) => {
            console.log(error);
            this.isSaving = false;
            this.error = 'There was a problem saving the product.';
          });
      },
    }
  });

  const el = document.getElementById('products-container');
  el.style.display = 'block';
};

fetchProducts(1, PAGE_SIZE, 'name')
  .then((products) => {
    renderProducts(products, null);
  })
  .catch((error) => {
    renderProducts(null, 'There was a problem loading the products.');
  });
