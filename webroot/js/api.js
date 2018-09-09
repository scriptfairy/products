const apiRequest = (path, body, options) => {
  const _options = options || {};
  const method = _options.method || 'GET';
  return new Promise((resolve, reject) => {

    const headers = {
      'X-Requested-With': 'XMLHttpRequest',
    };

    let _body;

    if (method === 'POST' && body) {
      const isFormData = body instanceof FormData;
      if (isFormData) {
        _body = body;
      }
      else {
        headers['Content-Type'] = 'application/json; charset=utf-8';
        _body = JSON.stringify(body);
      }
    }

    const options = {
      method: method,
      cache: 'no-cache',
      credentials: 'same-origin',
      headers: headers,
      body: _body,
    };

    fetch(path, options)
      .then(response => response.json())
      .then(resolve)
      .catch(reject);
  });
};

const apiGet = (path) => apiRequest(path, undefined, { method: 'GET' });

const apiPost = (path, body) => apiRequest(path, body, { method: 'POST' });

const fetchProducts = (offset, limit, sort) =>
  apiGet(`/products/api/?method=getproducts&offset=${offset}&limit=${limit}&sort=${sort}`);

const saveProduct = (product, productPicture) => {
  const formData = new FormData();
  formData.append('id', product.id);
  formData.append('name', product.name);
  formData.append('description', product.description);
  formData.append('price', product.price);
  if (productPicture) {
    formData.append('picture', productPicture);
  }
  const options = {
    method: 'POST',
    body: formData,
    // If you add this, upload won't work
    // headers: {
    //   'Content-Type': 'multipart/form-data',
    // }
  };
  return apiPost('/products/api/?method=saveproduct', formData);
}

const deleteProduct = (product) =>
  apiGet(`/products/api/?method=deleteproduct&id=${product.id}`)
