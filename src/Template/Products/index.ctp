<div id="products-container" style="display: none">

  <!--
  * Product load Error
  -->
  <div v-if="error">
    <div class="alert alert-danger">
        {{error}}
    </div>
  </div>

  <!--
  * Product form
  -->
  <form v-if="showProductForm">
    <div class="form-group">
      <label for="product-name">Product Name</label>
      <input
        id="product-name"
        class="form-control"
        type="text"
        v-model="product.name"
      >
    </div>

    <div class="form-group">
      <label for="product-description">Product Description</label>
      <input
        id="product-decription"
        class="form-control"
        type="text"
        v-model="product.description"
      >
    </div>

    <div class="form-group">
      <label for="product-price">Product Price</label>
      <input
        id="product-price"
        class="form-control"
        type="number"
        v-model="product.price"
      >
    </div>

    <div v-if="product.picture">
      <img
        v-bind:src="productsPrefixUrl + product.picture"
        width="200"
      >
    </div>

    <div class="form-group">
      <label for="upload-image">Upload Image</label>
      <input
        id="upload-image"
        class="form-control"
        type="file"
        accept="image/png, image/jpeg, image/jpg, image/gif"
        v-on:change="selectProductPicture($event)"
      >
    </div>

    <div class="row">
      <div class="col-md-12">
        <button
          type="button"
          class="btn btn-primary mr-2"
          v-bind:disabled="isSaving"
          v-on:click="saveProduct()">
          <span v-if="isSaving">Saving ...</span>
          <span v-else>Save</span>
        </button>
        <button
          type="button"
          class="btn btn-light"
          v-bind:disabled="isSaving"
          v-on:click="cancelProduct()">
          Cancel
        </button>
      </div>
    </div>

  </form>

  <!--
  * Product list
  -->
  <div v-if="showProductList">

    <div class="row mb-2">
      <div class="col-md-12">
        <button
          type="button"
          class="btn btn-primary"
          v-on:click="addProduct()">
          Add Product
        </button>
      </div>
    </div>

    <div v-if="products.data.length === 0">
      <div class="alert alert-info" role="alert">
        No products
      </div>
    </div>

    <table class="table" v-if="products.data.length > 0">
      <tr>
        <th>Picture</th>
        <th>
          <button
            type="button"
            class="btn btn-light btn-sm"
            v-bind:disabled="!enableSort"
            v-on:click="sortBy('name')">
            Name
          </button>
           {{ sortIndicator('name') }}
        </th>
        <th>
          <button
            type="button"
            class="btn btn-light btn-sm"
            v-bind:disabled="!enableSort"
            v-on:click="sortBy('price')">
            Price
          </button>
           {{ sortIndicator('price') }}
        </th>
        <th></th>
      </tr>
      <tr v-for="product in products.data">
        <td>
          <img
            v-bind:src="productsPrefixUrl + product.picture"
            width="100"
            v-on:click="editProduct(product)"
          />
        </td>
        <td>
          <span
            v-on:click="editProduct(product)"
            class="btn-link">
              {{ product.name }}
          </span>
        </td>
        <td>{{ product.price }}</td>
        <td>
          <button
            type="button"
            class="btn btn-outline-primary btn-sm"
            v-bind:disabled="isDeleting"
            v-on:click="editProduct(product)">
            Edit
          </button>
          <button
            type="button"
            class="btn btn-outline-danger btn-sm"
            v-on:click="deleteProduct(product)"
            v-bind:disabled="isDeleting">
            <span v-if="isDeleting">Deleting ...</span>
            <span v-else>Delete</span>
          </button>
        </td>
      <tr>
    </table>

    <div class="row">
      <div class="col-md-12">
        <button
          type="button"
          class="btn btn-outline-primary btn-sm mr-2"
          v-bind:disabled="!enablePreviousPage"
          v-on:click="previousPage()">
          Previous
        </button>
        <button
          type="button"
          class="btn btn-outline-primary btn-sm"
          v-bind:disabled="!enableNextPage"
          v-on:click="nextPage()">
          Next
        </button>
      </div>
    </div>

  </div>

</div>

<script src="/js/api.js"></script>
<script src="/js/products/index.js"></script>
