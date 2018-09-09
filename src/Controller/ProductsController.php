<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\BadRequestException;

class ProductsController extends AppController
{
  public function initialize() {
    parent::initialize();
    $this->loadModel('Product');
  }

  public function index()
  {
    $this->render();
  }

  public function api() {
    $this->viewBuilder()->setLayout('ajax');
    $method = $this->request->getQuery('method');
    $encode = true;

    switch($method){
      case 'getproducts':
        $offset = $this->request->getQuery('offset');
        $limit = $this->request->getQuery('limit');
        $order = $this->request->getQuery('sort');

        if (!isset($order) || !isset($offset) || !isset($limit)) {
          throw new BadRequestException();
        }

        $offsetInt = intval($offset);
        $limitInt = intval($limit);

        if ($limitInt < 1 || $offsetInt < 0) {
          throw new BadRequestException();
        }

        $query = $this->Product
          ->find()
          ->order([ $order => 'asc'])
          ->limit($limitInt)
          ->offset($offsetInt);

        $data = array(
          "offset" => $offsetInt,
          "limit" => $limitInt,
          "records" => $query->count(),
          "data" => $query
        );

        break;

      case 'saveproduct':
        $formData = $this->request->getData();

        $serverFileName = null;

        // Upload the file
        $hasPicture = isset($formData["picture"]);
        if ($hasPicture) {
          $formPicture = $formData["picture"];
          $tempFilePath = $formPicture["tmp_name"];
          $clientFileName = $formPicture["name"];
          $fileExt = pathinfo($clientFileName, PATHINFO_EXTENSION);
          $serverFileName = uniqid() . "." . $fileExt;
          $serverFilePath = WWW_ROOT . "img" . DS . "products" . DS . $serverFileName;
          move_uploaded_file($tempFilePath, $serverFilePath);
        }

        // Insert into the database
        $productsTable = TableRegistry::get('Product');
        if($formData["id"] > 0) {
          $product = $productsTable->get($formData["id"]);
        } else {
          $product = $productsTable->newEntity();
        }
        $product->name = $formData["name"];
        $product->description = $formData["description"];
        $product->price = $formData["price"];

        if ($serverFileName) {
          $product->picture = $serverFileName;
        }

        if ($productsTable->save($product)) {
            // The $product entity contains the id now
            $data["id"] = $product->id;
        }

        $data = $product;

        break;

      case 'deleteproduct':
        $productId = $this->request->getQuery('id');
        $entity = $this->Product->get($productId);
        $data = $this->Product->delete($entity);
        break;
    }

    if($encode){
      $body = json_encode($data);
    } else {
      $body = $data;
    }
    return $this->response
      ->withType('application/json')
      ->withStringBody($body);
  }

}
