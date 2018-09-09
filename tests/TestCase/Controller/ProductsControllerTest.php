<?php

namespace App\Test\TestCase\Controller;

use App\Controller\ProductsController;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\IntegrationTestCase;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

class ProductsControllerTest extends IntegrationTestCase
{

    public $fixtures = ['app.product'];

    public function getBody()
    {
      $json = (string) $this->_response->getBody();
      return json_decode($json);
    }

    public function testIndex()
    {
        $this->get('/');
        $this->assertResponseOk();
    }

    public function testApiGetProducts1()
    {
      $this->get('/products/api/?method=getproducts&offset=0&limit=1&sort=id');
      $this->assertResponseOk();
      $body = $this->getBody();
      $this->assertEquals(1, count($body->data));
      $this->assertEquals('Red Hat', $body->data[0]->name);
    }

    public function testApiGetProducts2()
    {
      $this->get('/products/api/?method=getproducts&offset=1&limit=2&sort=name');
      $this->assertResponseOk();
      $body = $this->getBody();
      $this->assertEquals(2, count($body->data));
      $this->assertEquals('Hello Kitty', $body->data[0]->name);
      $this->assertEquals('Paperclips', $body->data[1]->name);
    }

    public function testApiGetProducts3()
    {
      $this->get('/products/api/?method=getproducts&offset=2&limit=3&sort=price');
      $this->assertResponseOk();
      $body = $this->getBody();
      $this->assertEquals(3, count($body->data));
      $this->assertEquals('Hello Kitty', $body->data[0]->name);
      $this->assertEquals('Rubber Band', $body->data[1]->name);
      $this->assertEquals('Blue Bag', $body->data[2]->name);
    }

    public function testApiGetProductsError()
    {
      $this->get('/products/api/?method=getproducts');
      $this->assertResponseCode(400);
    }
}
